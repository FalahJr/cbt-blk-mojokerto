<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Materi;
use App\Models\Notifikasi;
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
        $newest_notifikasi = Notifikasi::where('role', '=', 'Murid')->orderBy('id', 'desc')->first();
        $get_new_periode = Periode::latest()->first();
        $get_new_quiz = Quizzes::where("periode_id", "=", $get_new_periode->id)->first();

        if ($get_new_quiz !== null) {
            $list_leaderboard = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $get_new_quiz->id)->where('user.pelatihan_id', '=', Session('user')['pelatihan_id'])->select('quiz_attempts.*', 'user.nama_lengkap')->limit('5')->get();
        } else {
            $get_newest_quiz = Quizzes::orderBy('id', 'desc')->first();
            $list_leaderboard = QuizAttempts::join('user', 'user.id',  '=', 'quiz_attempts.user_id')->where("quizzes_id", "=", $get_newest_quiz->id)->where('user.pelatihan_id', '=', Session('user')['pelatihan_id'])->select('quiz_attempts.*', 'user.nama_lengkap')->limit('5')->get();
        }
        $listMurid = User::where('role', '=', 'Murid')->where('pelatihan_id', '=', Session('user')['pelatihan_id'])->limit('4')->get();

        // dd($get_new_materi->id);



        // dd($listMurid);
        return view('pages.dashboard-guru', compact('newest_notifikasi', 'list_leaderboard', 'listMurid'));
    }

    public function indexDashboardAdmin()
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
        $listMurid = User::where('role', '=', 'Murid')->limit('4')->get();

        // dd($get_new_materi->id);



        // dd($data);
        return view('pages.dashboard-guru', compact('newest_notifikasi', 'list_leaderboard', 'listMurid'));
    }
}
