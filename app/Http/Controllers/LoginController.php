<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Pelatihan;
use App\Models\User;

class LoginController extends Controller
{

    public function index()
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




        $admin = User::where([
            'email' => $request->email,
            'password' => $request->password,
        ])->first();

        // dd($admin);
        if ($admin) {

            $check = $this->checkUser($request, $admin, $admin->role, $admin->pelatihan_id);
            if ($check != null) {
                return $check;
            }

            return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
        } else {

            return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
        }
    }

    private function checkUser($request, $user, $role, $pelatihan_id)
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
            $user['pelatihan_id'] = $pelatihan_id;
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

        return redirect('/');
    }

    public function registerForm()
    {
        $pelatihan = Pelatihan::all();
        return view('pages.register', compact('pelatihan'));
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama_lengkap' => 'required|string|max:255',
            'password' => 'required|string',
            'pelatihan_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'password' => $request->password,
            'pelatihan_id' => $request->pelatihan_id,
            'role' => 'Murid', // Default role for new users
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($user) {
            return redirect('/')->with('success', 'Registrasi berhasil. Silakan login.');
        } else {
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat registrasi.');
        }
    }
}
