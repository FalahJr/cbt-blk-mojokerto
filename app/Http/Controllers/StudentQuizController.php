<?php

namespace App\Http\Controllers;

use App\Models\Quizzes;
use App\Models\Questions;
use App\Models\QuizAttempts;
use App\Models\UserAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    public function index()
    {
        $quizzes = Quizzes::join('materi', 'materi.id', '=', 'quizzes.materi_id')->select('quizzes.*', 'materi.id as id_materi')->get();
        return view('pages.kuis', compact('quizzes'));
    }

    public function showQuiz($id)
    {
        // dd($id);
        $quiz = Quizzes::with('questions')->findOrFail($id);
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
        $listQuizAttempt = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $quizzes_id)->select('quiz_attempts.*', 'user.nama_lengkap')
            ->orderBy('score', 'desc')
            ->get();

        return view('pages.score', compact('listQuizAttempt'));
    }
}
