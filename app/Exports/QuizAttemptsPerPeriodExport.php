<?php

namespace App\Exports;

use App\Models\QuizAttempts;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;

class QuizAttemptsPerPeriodExport implements FromView, WithTitle
{
    protected $periode;
    protected $pelatihan;

    public function __construct($periode, $pelatihan)
    {
        $this->periode = $periode;
        $this->pelatihan = $pelatihan;
    }

    // Method untuk mendapatkan nama sheet (worksheet)
    public function title(): string
    {
        return $this->periode->nama; // Menggunakan nama periode untuk nama sheet
    }

    // Method untuk menampilkan data pada sheet
    public function view(): View
    {
        $listQuizAttempt = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
            ->join('quizzes', 'quizzes.id', '=', 'quiz_attempts.quizzes_id')
            ->where('quizzes.periode_id', $this->periode->id)
            ->where('user.pelatihan_id', $this->pelatihan->id)
            ->orderBy('quiz_attempts.score', 'desc')
            ->select('quiz_attempts.*', 'user.nama_lengkap', 'user.nomor_peserta', 'quizzes.title as quiz_name')
            ->get();

        return view('exports.quiz_attempts', [
            'listQuizAttempt' => $listQuizAttempt,
            'periode' => $this->periode,
            'pelatihan' => $this->pelatihan
        ]);
    }
}
