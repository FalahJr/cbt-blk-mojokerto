<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class NotificationController extends Controller
{

    public function index()
    {
        $role = Session('user')['role'];

        // dd($role);
        if ($role == 'Guru') {
            $newest_notifikasi = Notifikasi::where('role', '=', 'Guru')->orderBy('id', 'desc')->get();

            return view('pages.notification', compact('newest_notifikasi'));
        } else {
            $newest_notifikasi = Notifikasi::where('role', '=', 'Murid')->orderBy('id', 'desc')->get();

            return view('pages.notification', compact('newest_notifikasi'));
        }
    }

    public function indexDashboardMurid()
    {
        $newest_notifikasi = Notifikasi::where('role', '=', 'Murid')->orderBy('id', 'desc')->first();




        // dd($data);
        return view('pages.dashboard', compact('newest_notifikasi'));
    }
}
