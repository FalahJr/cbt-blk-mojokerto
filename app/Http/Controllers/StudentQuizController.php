<?php

namespace App\Http\Controllers;

use App\Exports\QuizAttemptsByPelatihanExport;
use App\Exports\QuizAttemptsByPeriodExport;
use App\Exports\QuizAttemptsExport;
use App\Models\Kelulusan;
use App\Models\Pelatihan;
use App\Models\Periode;
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
            // Ambil quiz terbaru berdasarkan periode, jika ada
            $quizzes = Quizzes::join('periode', 'periode.id', '=', 'quizzes.periode_id')
                ->select('quizzes.*', 'periode.id as id_periode')
                ->latest()
                ->first();

            $quiz_attempt = null;
            $kelulusan = null;

            // Pastikan $quizzes tidak null sebelum diakses
            if ($quizzes) {
                $quiz_attempt = QuizAttempts::where('user_id', '=', Session('user')['id'])
                    ->where('quizzes_id', '=', $quizzes->id)
                    ->latest()
                    ->first();

                if ($quiz_attempt) {
                    // Cari kelulusan berdasarkan quiz_attempt jika ada
                    $kelulusan = Kelulusan::where('user_id', '=', Session('user')['id'])
                        ->where('quiz_attempts_id', '=', $quiz_attempt->id)
                        ->first();
                } else {
                    // Cari kelulusan terakhir jika tidak ada quiz_attempt
                    $kelulusan = Kelulusan::where('user_id', '=', Session('user')['id'])->latest()->first();
                }
            }
        } else {
            // Jika bukan murid, ambil semua data quiz
            $quizzes = Quizzes::all();
            $kelulusan = null;
            $quiz_attempt = null;
        }

        // dd($quizzes);

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


    public function showAllResultIndexByAdmin()
    {
        // Pastikan hanya data yang sesuai dengan quiz dan pelatihan yang dipilih


        // dd($listQuizAttempt);

        // Ambil daftar pelatihan untuk dropdown atau keperluan lainnya
        $pelatihan = Pelatihan::all();
        // dd($pelatihan);

        return view('pages.result-score', compact('pelatihan'));
    }
    // public function showAllResultByAdmin($pelatihan_id, Request $request)
    // {
    //     // Pastikan hanya data yang sesuai dengan quiz dan pelatihan yang dipilih
    //     $query = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
    //         ->where('quiz_attempts.quizzes_id', '=', $quizzes_id)
    //         ->select('quiz_attempts.*', 'user.nama_lengkap')
    //         ->orderBy('quiz_attempts.score', 'desc');
    //     $listQuizAttempt = Null;

    //     // Tambahkan filter pelatihan jika parameter pelatihan_id diberikan
    //     if (isset($request->pelatihan_id)) {
    //         $pelatihan_id = $request->pelatihan_id;
    //         $query->where('user.pelatihan_id', '=', $pelatihan_id);
    //         $listQuizAttempt = $query->get();
    //     }

    //     $pelatihan_id = $request->pelatihan_id;


    //     // dd($listQuizAttempt);

    //     // Ambil daftar pelatihan untuk dropdown atau keperluan lainnya
    //     $pelatihan = Pelatihan::all();
    //     // dd($pelatihan);
    //     // dd($request->pelatihan_id);
    //     // dd($query->toSql(), $query->getBindings(), $listQuizAttempt);

    //     return view('pages.score', compact('listQuizAttempt', 'pelatihan', 'quizzes_id', 'pelatihan_id'));
    // }

    public function showAllResultByAdmin($pelatihan_id, Request $request)
    {
        // Ambil semua periode yang terkait dengan pelatihan
        $periodes = Periode::whereHas('quizzes', function ($query) {
            $query->select('id');
        })->get();
        // dd($pelatihan_id);

        // Periode aktif (default: periode pertama jika tidak ada `periode_id` di request)
        $periode_id = $request->periode_id ?? $periodes->first()?->id;

        // Ambil semua skor berdasarkan pelatihan dan periode
        $listQuizAttempt = QuizAttempts::join('quizzes', 'quizzes.id', '=', 'quiz_attempts.quizzes_id')
            ->join('user', 'user.id', '=', 'quiz_attempts.user_id')
            ->where('user.pelatihan_id', $pelatihan_id) // Filter berdasarkan pelatihan_id
            ->where('quizzes.periode_id', $periode_id) // Filter berdasarkan periode
            ->select('quiz_attempts.*', 'user.nama_lengkap', 'user.nomor_peserta')
            ->orderBy('quiz_attempts.score', 'desc')
            ->get();

        // Ambil data pelatihan untuk header
        $pelatihan = Pelatihan::find($pelatihan_id);


        return view('pages.score', compact('listQuizAttempt', 'periodes', 'pelatihan', 'periode_id'));
    }



    // public function exportToExcel($pelatihan_id, Request $request)
    // {
    //     // Ambil data pelatihan
    //     $pelatihan = Pelatihan::findOrFail($pelatihan_id);

    //     // Ambil periode_id dari request
    //     $periode_id = $request->periode_id;

    //     // Ambil quiz berdasarkan periode_id (quizzes terhubung dengan periode_id)
    //     $quizzes = Quizzes::where('periode_id', $periode_id)->get();

    //     // Cek jika quizzes kosong
    //     if ($quizzes->isEmpty()) {
    //         return back()->with('error', 'Tidak ada quiz yang ditemukan untuk periode ini.');
    //     }

    //     return Excel::download(new QuizAttemptsByPelatihanExport($quizzes, $pelatihan), 'Nilai Pelatihan ' . $pelatihan->nama . '.xlsx');
    // }

    public function exportToExcel($pelatihan_id, Request $request)
    {
        // Ambil data pelatihan
        $pelatihan = Pelatihan::findOrFail($pelatihan_id);

        // Ambil periode_id dari request
        $periode_id = $request->periode_id;

        // Ambil semua periode terkait pelatihan
        $periodes = Periode::whereHas('quizzes', function ($query) {
            $query->select('id');
        })->get();

        // Cek jika tidak ada periode terkait
        if ($periodes->isEmpty()) {
            return back()->with('error', 'Tidak ada periode yang terkait dengan pelatihan ini.');
        }

        // Kembalikan export Excel dengan setiap periode menjadi sheet terpisah
        return Excel::download(new QuizAttemptsByPelatihanExport($periodes, $pelatihan), 'Nilai Pelatihan ' . $pelatihan->nama . '.xlsx');
    }
}
