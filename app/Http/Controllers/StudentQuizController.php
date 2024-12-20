<?php

namespace App\Http\Controllers;

use App\Exports\QuizAttemptsExport;
use App\Models\Kelulusan;
use App\Models\Pelatihan;
use App\Models\Quizzes;
use App\Models\Questions;
use App\Models\QuizAttempts;
use App\Models\UserAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentQuizController extends  Controller
{
    public function index()
    {
        if (Session('user')['role'] == 'Murid') {
            $quizzes = Quizzes::join('periode', 'periode.id', '=', 'quizzes.periode_id')->select('quizzes.*', 'periode.id as id_periode')->latest()->first();
            $quiz_attempt = QuizAttempts::where('user_id', '=', Session('user')['id'])->where('quizzes_id', '=', $quizzes->id)->latest()->first();
            if ($quiz_attempt) {
                $kelulusan = Kelulusan::where('user_id', '=', Session('user')['id'])->where('quiz_attempts_id', '=', $quiz_attempt->id)->first();
            } else {
                $kelulusan = Kelulusan::where('user_id', '=', Session('user')['id'])->latest()->first();
            }
        } else {
            $quizzes = Quizzes::all();
            $kelulusan = null;
            $quiz_attempt = null;

            // dd($quizzes);
        }


        // dd((Session('user')['role']));

        return view('pages.kuis', compact('quizzes', 'kelulusan', 'quiz_attempt'));
    }

    public function showQuiz($id)
    {
        // dd($id);
        $quiz = Quizzes::with('questions')->findOrFail($id);
        $quiz->questions = $quiz->questions->shuffle();
        // $quiz = Quizzes::all;

        // dd($quiz);

        return view('pages.soal-kuis', compact('quiz'));
    }

    public function submitQuiz(Request $request, $id)
    {
        // dd($request->all());
        $quiz = Quizzes::with('questions')->findOrFail($id);
        $user =  Session('user')['id'];

        // Create a new quiz attempt
        $quizAttempt = QuizAttempts::create([
            'user_id' => $user,
            'quizzes_id' => $quiz->id,
            'score' => 0,
        ]);

        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            $answer = $request->input('question_' . $question->id);

            // Set empty answers to null or ""
            if (is_null($answer)) {
                $answer = ""; // You can also use null if you prefer
            }

            UserAnswers::create([
                'quiz_attempts_id' => $quizAttempt->id,
                'question_id' => $question->id,
                'chosen_answer' => $answer,
            ]);

            if ($answer == $question->correct_answer) {
                $correctAnswers++;
            }
        }

        // Calculate the score
        $score = ($correctAnswers / $quiz->questions->count()) * 100;
        $quizAttempt->update(['score' => $score]);

        $latestQuizAttempt = QuizAttempts::latest()->first();

        Kelulusan::create([
            'user_id' => $user,
            'quiz_attempts_id' => $latestQuizAttempt->id,
            'nilai_wawancara' => 0,
            'status' => "Pending",
        ]);

        return redirect()->route('student.quizzes.result', ['id' => $quiz->id, 'attempt_id' => $quizAttempt->id]);
    }


    public function showResult($id, $attempt_id)
    {
        $quiz = Quizzes::findOrFail($id);
        $quizAttempt = QuizAttempts::with('userAnswers')->findOrFail($attempt_id);
        return view('pages.hasil-kuis', compact('quiz', 'quizAttempt'));
    }

    public function showResultByUser($user_id, $quiz_id)
    {
        $quiz = Quizzes::findOrFail($quiz_id);
        $quizAttempt = QuizAttempts::with('userAnswers')->where('user_id', '=', $user_id)->where('quizzes_id', "=", $quiz_id)->first();
        // $listQuizAttempt = QuizAttempts::with('userAnswers')->join('user', 'user.id', '=', 'quiz_attempts.user_id')->where('quizzes_id', "=", $quiz_id)->get();
        $listQuizAttempt = QuizAttempts::with('userAnswers')
            ->join('user', 'user.id', '=', 'quiz_attempts.user_id')
            ->where('quizzes_id', '=', $quiz_id)
            ->orderBy('score', 'desc')
            ->get();
        // dd($listQuizAttempt);

        return view('pages.score', compact('quiz', 'quizAttempt', 'listQuizAttempt'));
    }

    public function showAllResultByGuru($quizzes_id)
    {
        $listQuizAttempt = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $quizzes_id)->where('user.pelatihan_id', '=', Session('user')['pelatihan_id'])->select('quiz_attempts.*', 'user.nama_lengkap', 'user.pelatihan_id')
            ->orderBy('score', 'desc')
            ->get();

        $pelatihan = Pelatihan::all();


        // dd(Session('user')['pelatihan_id']);

        return view('pages.score', compact('listQuizAttempt', 'pelatihan', 'quizzes_id'));
    }

    public function showAllResultByAdmin($quizzes_id, Request $request)
    {
        // Pastikan hanya data yang sesuai dengan quiz dan pelatihan yang dipilih
        $query = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
            ->where('quiz_attempts.quizzes_id', '=', $quizzes_id)
            ->select('quiz_attempts.*', 'user.nama_lengkap')
            ->orderBy('quiz_attempts.score', 'desc');
        $listQuizAttempt = Null;

        // Tambahkan filter pelatihan jika parameter pelatihan_id diberikan
        if (isset($request->pelatihan_id)) {
            $pelatihan_id = $request->pelatihan_id;
            $query->where('user.pelatihan_id', '=', $pelatihan_id);
            $listQuizAttempt = $query->get();
        }

        $pelatihan_id = $request->pelatihan_id;


        // dd($listQuizAttempt);

        // Ambil daftar pelatihan untuk dropdown atau keperluan lainnya
        $pelatihan = Pelatihan::all();
        // dd($pelatihan);
        // dd($request->pelatihan_id);
        // dd($query->toSql(), $query->getBindings(), $listQuizAttempt);

        return view('pages.score', compact('listQuizAttempt', 'pelatihan', 'quizzes_id', 'pelatihan_id'));
    }

    public function exportToExcel($quizzes_id, Request $request)
    {
        $pelatihan_id = $request->pelatihan_id ?? null;
        if (Session('user')['role'] == 'Guru') {
            $pelatihan_id = Session('user')['pelatihan_id'];
            $pelatihan = Pelatihan::where('id', $pelatihan_id)->first();
        } else {
            $pelatihan = Pelatihan::where('id', $pelatihan_id)->first();
        }

        return Excel::download(new QuizAttemptsExport($quizzes_id, $pelatihan_id), 'Nilai Pelatihan ' . $pelatihan->nama . '.xlsx');
    }
}
