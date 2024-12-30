<?php

namespace App\Exports;

use App\Models\QuizAttempts;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class QuizAttemptsPerQuizExport implements FromView
{
    protected $quiz;
    protected $pelatihan;

    public function __construct($quiz, $pelatihan)
    {
        $this->quiz = $quiz;
        $this->pelatihan = $pelatihan;
    }

    public function view(): View
    {
        // Ambil semua quiz_attempts yang terkait dengan quiz dan pelatihan
        $listQuizAttempt = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
            ->where('quiz_attempts.quizzes_id', $this->quiz->id) // Filter berdasarkan quiz
            ->where('user.pelatihan_id', $this->pelatihan->id) // Filter berdasarkan pelatihan_id di tabel user
            ->orderBy('quiz_attempts.score', 'desc')
            ->select('quiz_attempts.*', 'user.nama_lengkap')
            ->get();

        // Jika tidak ada data quiz_attempts, tampilkan sheet kosong atau informasi
        if ($listQuizAttempt->isEmpty()) {
            return view('exports.empty', [
                'quiz' => $this->quiz,
                'pelatihan' => $this->pelatihan
            ]);
        }

        return view('exports.quiz_attempts', [
            'listQuizAttempt' => $listQuizAttempt,
            'quiz' => $this->quiz,
            'pelatihan' => $this->pelatihan
        ]);
    }
}
