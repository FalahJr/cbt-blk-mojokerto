<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\Pelatihan;
use App\Models\Periode;
use App\Models\QuizAttempts;
use App\Models\Quizzes;
use App\Models\User;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public function index()
    {
        return view('pages.dashboard-guru');
    }

    public function indexDashboardMurid()
    {
        $newest_notifikasi = Notifikasi::where('role', '=', 'Murid')->orderBy('id', 'desc')->first();
        $get_new_periode = Periode::latest()->first();
        $get_new_quiz = Quizzes::where("periode_id", "=", $get_new_periode->id)->first();
        if ($get_new_quiz !== null) {
            $list_leaderboard = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $get_new_quiz->id)->select('quiz_attempts.*', 'user.nama_lengkap')->get();
        } else {
            $get_newest_quiz = Quizzes::orderBy('id', 'desc')->first();
            $list_leaderboard = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $get_newest_quiz->id)->select('quiz_attempts.*', 'user.nama_lengkap')->get();
        }
        // dd($list_leaderboard);



        // dd($data);
        return view('pages.dashboard', compact('newest_notifikasi', 'list_leaderboard'));
    }
    public function indexDashboardGuru()
    {
        // Ambil notifikasi terbaru
        $newest_notifikasi = Notifikasi::where('role', '=', 'Murid')->orderBy('id', 'desc')->first();

        // Ambil periode terbaru
        $get_new_periode = Periode::latest()->first();
        $list_leaderboard = [];
        $listMurid = [];

        // Cek apakah ada periode terbaru
        if ($get_new_periode) {
            // Ambil quiz terbaru berdasarkan periode terbaru
            $get_new_quiz = Quizzes::where("periode_id", "=", $get_new_periode->id)->first();

            if ($get_new_quiz) {
                // Ambil leaderboard untuk quiz terbaru
                $list_leaderboard = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
                    ->where("quizzes_id", "=", $get_new_quiz->id)
                    ->where('user.pelatihan_id', '=', Session('user')['pelatihan_id'])
                    ->select('quiz_attempts.*', 'user.nama_lengkap')
                    ->limit(5)
                    ->get();
            } else {
                // Jika tidak ada quiz untuk periode terbaru, ambil quiz terakhir
                $get_newest_quiz = Quizzes::orderBy('id', 'desc')->first();

                if ($get_newest_quiz) {
                    $list_leaderboard = QuizAttempts::join('user', 'user.id', '=', 'quiz_attempts.user_id')
                        ->where("quizzes_id", "=", $get_newest_quiz->id)
                        ->where('user.pelatihan_id', '=', Session('user')['pelatihan_id'])
                        ->select('quiz_attempts.*', 'user.nama_lengkap')
                        ->limit(5)
                        ->get();
                }
            }
        }

        // Ambil list murid berdasarkan pelatihan, hanya jika pelatihan_id tersedia
        if (Session('user')['pelatihan_id'] ?? null) {
            $listMurid = User::where('role', '=', 'Murid')
                ->where('pelatihan_id', '=', Session('user')['pelatihan_id'])
                ->limit(4)
                ->get();
        }

        return view('pages.dashboard-guru', compact('newest_notifikasi', 'list_leaderboard', 'listMurid'));
    }


    public function indexDashboardAdmin()
    {
        // $newest_notifikasi = Notifikasi::where('role', '=', 'Murid')->orderBy('id', 'desc')->first();
        // $get_new_periode = Periode::latest()->first();
        // $get_new_quiz = Quizzes::where("periode_id", "=", $get_new_periode->id)->first();

        // if ($get_new_quiz !== null) {
        //     $list_leaderboard = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $get_new_quiz->id)->select('quiz_attempts.*', 'user.nama_lengkap')->get();
        // } else {
        //     $get_newest_quiz = Quizzes::orderBy('id', 'desc')->first();
        //     $list_leaderboard = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $get_newest_quiz->id)->select('quiz_attempts.*', 'user.nama_lengkap')->get();
        // }
        $listMurid = User::where('role', '=', 'Murid')->count();
        $listGuru = User::where('role', '=', 'Guru')->count();
        $listPelatihan = Pelatihan::count();

        // dd($listPelatihan);



        // dd($data);
        return view('pages.dashboard-guru', compact('listGuru', 'listPelatihan', 'listMurid'));
    }
}
