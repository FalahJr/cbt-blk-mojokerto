<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuizAttemptsByPeriodExport implements WithMultipleSheets
{
    use Exportable;

    protected $periodes;
    protected $pelatihan_id;

    public function __construct($periodes, $pelatihan_id)
    {
        $this->periodes = $periodes;
        $this->pelatihan_id = $pelatihan_id;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->periodes as $periode) {
            $sheets[] = new QuizAttemptsPerPeriodExport($this->pelatihan_id, $periode->id);
        }

        return $sheets;
    }
}
