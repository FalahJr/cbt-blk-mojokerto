<?php

namespace App\Exports;

use App\Models\QuizAttempts;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class QuizAttemptsExport implements FromView
{
    protected $quiz;
    protected $periode;
    protected $pelatihan_id;

    public function __construct($quiz, $periode, $pelatihan_id = null)
    {
        $this->quiz = $quiz;
        $this->periode = $periode;
        $this->pelatihan_id = $pelatihan_id;
    }

    public function view(): View
    {
        // Ambil semua skor berdasarkan quiz_id dan periode
        $listQuizAttempt = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
            ->where('quiz_attempts.quizzes_id', $this->quiz->id)
            ->where('user.pelatihan_id', $this->pelatihan_id)
            ->orderBy('quiz_attempts.score', 'desc')
            ->select('quiz_attempts.*', 'user.nama_lengkap')
            ->get();

        return view('exports.quiz_attempts', [
            'listQuizAttempt' => $listQuizAttempt,
            'quiz' => $this->quiz,
            'periode' => $this->periode
        ]);
    }
}
