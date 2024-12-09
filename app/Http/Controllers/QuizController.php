<?php

namespace App\Http\Controllers;

use App\Imports\QuestionsImport;
use App\Models\Quiz;
use App\Models\Questions;
use App\Models\Materi;
use App\Models\Periode;
use App\Models\QuizAttempts;
use App\Models\Quizzes;
use App\Models\UserAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quizzes::with('periode')->get();
        return view('pages.manage-kuis', compact('quizzes'));
    }

    public function create()
    {
        $periode = Periode::all();
        return view('pages.add-kuis', compact('periode'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'title' => 'required|string|max:255',
        ]);

        // dd($request->title);
        $randomKode = Str::random(6);

        Quizzes::create([
            'periode_id' => $request->periode_id,
            'title' => $request->title,
            'timer' => $request->timer,
            'tanggal_mulai' => $request->tanggal_mulai,
            'kode' => $randomKode
        ]);


        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }


    public function show($id)
    {
        $quiz = Quizzes::with('questions')->findOrFail($id);
        return view('pages.detail-kuis', compact('quiz'));
    }

    public function edit($id)
    {
        $quiz = Quizzes::findOrFail($id);
        $periode = Periode::all();
        return view('pages.edit-kuis', compact('quiz', 'periode'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'title' => 'required|string|max:255',
        ]);

        $quiz = Quizzes::findOrFail($id);
        $quiz->update([
            'periode_id' => $request->periode_id,
            'title' => $request->title,
            'timer' => $request->timer,
            'tanggal_mulai' => $request->tanggal_mulai,

        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy($id)
    {
        // dd($id);
        // $quiz = Quizzes::findOrFail($id);
        // $quiz->delete();
        $getQuestion = Questions::where('quizzes_id', '=', $id)->first();

        if ($getQuestion) {
            $getQuizAttempt = QuizAttempts::where('quizzes_id', '=', $id)->first();
            // dd($getQuizAttempt);
            if ($getQuizAttempt) {
                $deleteUserAnswer = UserAnswers::where('quiz_attempts_id', $getQuizAttempt->id)->delete();

                if ($deleteUserAnswer) {
                    $deleteQuizAttempt = QuizAttempts::where('quizzes_id', '=', $id)->delete();
                    if ($deleteQuizAttempt) {

                        $deleteQuestion = Questions::where('quizzes_id', $id)->delete();

                        if ($deleteQuestion) {
                            Quizzes::where('id', $id)->delete();
                            return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
                        }
                    }
                }
            } else {
                $deleteQuestion = Questions::where('quizzes_id', $id)->delete();

                if ($deleteQuestion) {
                    Quizzes::where('id', $id)->delete();
                    return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
                }
            }
        } else {
            Quizzes::where('id', $id)->delete();
            return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
        }



        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    public function createQuestion($quiz_id)
    {
        $quiz = Quizzes::findOrFail($quiz_id);
        return view('pages.add-question', compact('quiz'));
    }

    public function storeQuestion(Request $request, $quiz_id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',
        ]);

        // dd($quiz_id);
        Questions::create([
            'quizzes_id' => $quiz_id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('quizzes.show', $quiz_id)->with('success', 'Question added successfully.');
    }

    public function importQuestions(Request $request, $quiz_id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Proses import menggunakan Laravel Excel
        Excel::import(new QuestionsImport($quiz_id), $request->file('file'));

        return redirect()->route('quizzes.show', $quiz_id)->with('success', 'Soal berhasil diimport!');
    }

    public function editQuestion($quiz_id, $question_id)
    {
        $question = Questions::findOrFail($question_id);
        return view('pages.edit-question', compact('question', 'quiz_id'));
    }

    public function updateQuestion(Request $request, $quiz_id, $question_id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',

        ]);

        $question = Questions::findOrFail($question_id);
        $question->update([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('quizzes.show', $quiz_id)->with('success', 'Question updated successfully.');
    }

    public function destroyQuestion($quiz_id, $question_id)
    {
        $question = Questions::findOrFail($question_id);
        $question->delete();

        return redirect()->route('quizzes.show', $quiz_id)->with('success', 'Question deleted successfully.');
    }
}
