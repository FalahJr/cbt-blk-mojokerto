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

            // Hapus tabel yang memiliki relasi foreign key terlebih dahulu
            DB::table('kelulusan')->delete();
            DB::table('quiz_attempts')->delete();
            DB::table('questions')->delete();
            DB::table('quizzes')->delete();
            DB::table('periode')->delete();
            DB::table('user_answers')->delete();

            // Jangan hapus admin/guru
            DB::table('user')->whereNotIn('role', ['Admin', 'Guru'])->delete();

            DB::commit();

            return redirect()->route('settings.index')->with('success', 'Semua data berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('settings.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
