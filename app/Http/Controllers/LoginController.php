<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\User;

class LoginController extends Controller
{

    public function index_student()
    {
        return view('pages.login-student');
    }

    public function index_teacher()
    {
        return view('pages.login-teacher');
    }

    public function login_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('failed', 'Lengkapi isian form');
            return redirect('login');
        }

        // $karyawan = Karyawan::where([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // $check = $this->checkUser($request, $karyawan, 'Karyawan');
        // if($check != null){
        //     return $check;
        // }

        // $staf_hr = Pejabat_struktural::where([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // $check = $this->checkUser($request, $staf_hr, 'pejabat-struktural');
        // if($check != null){
        //     return $check;
        // }

        // $pegawai = User::where([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ])->with('divisi', 'jabatan')->first();
        // if ($pegawai) {
        //     // dd($pegawai);

        //     $check = $this->checkUser($request, $pegawai, $pegawai->jabatan->nama);
        //     // dd($check);

        //     if ($check != null) {
        //         return $check;
        //     }
        // }



        $admin = User::where([
            'email' => $request->email,
            'password' => $request->password,
        ])->first();

        // dd($admin);
        if ($admin) {

            $check = $this->checkUser($request, $admin, $admin->role);
            if ($check != null) {
                return $check;
            }

            return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
        } else {

            return redirect('/login')->with('failed', 'Data User Tidak Ditemukan');
        }
    }

    private function checkUser($request, $user, $role)
    {
        // Session::flush();

        if ($user->exists()) {
            // dd($user);

            // $user = $user->first()->toArray();
            // unset($user['password']);
            $user['role'] = $role;
            $user['id'] = $user['id'] ?? $user['id_admin'];
            $user['nama'] = $user['nama_lengkap'];
            $user['divisi'] = $user['divisi_id'] ?? null;
            Session(['user' => $user]);
            // dd($role);
            switch ($role) {
                case 'Admin':
                    return redirect('admin/home');
                    break;
                case 'Murid':
                    return redirect('student/home');
                    break;

                case 'Guru':
                    return redirect('teacher/home');
                    break;

                    // case 'Karyawan':
                    //     return redirect('/karyawan/home');
                    //     break;
                    // case 'Kepala Bagian':
                    //     return redirect('/kepala-bagian/home');
                    //     break;

                    // case 'Kepala Sub Bagian':
                    //     return redirect('/kepala-sub-bagian/home');
                    //     break;

                    // case 'Direktur':
                    //     return redirect('/direktur/home');
                    //     break;

                    //     // case 'Manager':
                    //     //     return redirect('/pejabat-struktural/home');
                    //     //     break;

                    // case 'admin':
                    //     return redirect('/admin/home');
                    //     break;

                default:
                    return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
                    break;
            }
        } else {
            return null;
        }
    }

    public function logout_action()
    {
        Session::flush();
        // dd(Session('user'));

        return redirect('/login');
    }
}
