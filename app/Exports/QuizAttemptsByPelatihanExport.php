<?php

namespace App\Exports;

use App\Models\QuizAttempts;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuizAttemptsByPelatihanExport implements WithMultipleSheets
{
    use Exportable;

    protected $periodes;
    protected $pelatihan;

    public function __construct($periodes, $pelatihan)
    {
        $this->periodes = $periodes;
        $this->pelatihan = $pelatihan;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Loop untuk setiap periode
        foreach ($this->periodes as $periode) {
            $quizAttemptsPerPeriod = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
                ->join('quizzes', 'quizzes.id', '=', 'quiz_attempts.quizzes_id')
                ->where('quizzes.periode_id', $periode->id)
                ->where('user.pelatihan_id', $this->pelatihan->id)
                ->get();

            if ($quizAttemptsPerPeriod->isNotEmpty()) {
                $sheets[] = new QuizAttemptsPerPeriodExport($periode, $this->pelatihan);
            }
        }

        return $sheets;
    }
}
