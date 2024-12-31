<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelulusan;
use App\Models\Pelatihan;
use App\Models\Periode;
use App\Models\Questions;
use App\Models\QuizAttempts;
use App\Models\Quizzes;
use App\Models\UserAnswers;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan
     */
    public function index()
    {
        return view('pages.setting');
    }

    /**
     * Reset semua data kecuali admin dan guru
     */
    public function resetData()
    {
        try {
            DB::beginTransaction();

            // Urutan penghapusan sesuai relasi foreign key
            DB::table('user_answers')->delete(); // Foreign key ke quiz_attempts
            DB::table('kelulusan')->delete(); // Foreign key ke quiz_attempts
            DB::table('quiz_attempts')->delete(); // Foreign key ke quizzes
            DB::table('questions')->delete(); // Foreign key ke quizzes atau periode
            DB::table('quizzes')->delete(); // Foreign key ke periode
            DB::table('periode')->delete(); // Parent table
            DB::table('user')->whereNotIn('role', ['Admin', 'Guru'])->delete(); // Hapus user kecuali admin/guru

            DB::commit();

            return redirect()->route('settings.index')->with('success', 'Semua data berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('settings.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
