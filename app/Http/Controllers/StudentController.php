<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class StudentController extends Controller
{

    public function index()
    {
        $data = User::where("role", "=", "Murid")
            ->get();

        // dd($data);
        return view('pages.list-murid', compact('data'));
    }





    public function create()
    {
        return view('pages.add-student');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {
            if ($request->hasFile('gambar')) {

                // $getPegawaiBaru = Pegawai::orderBy('created_at', 'desc')->first();
                // $getKonfigCuti = Konfig_cuti::where('tahun',(new \DateTime())->format('Y'))->first();
                $fileName = $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move('img/murid', $fileName);

                $user = new User;
                $user->nama_lengkap = $request->nama_lengkap;
                $user->role = "Murid";
                $user->email = $request->email;
                $user->password = $request->password;
                $user->alamat = $request->alamat;
                $user->nomor_induk = $request->nomor_induk;
                $user->gambar = $fileName;
                $user->created_at = Carbon::now();
                $user->updated_at = Carbon::now();

                $user->save();

                return redirect('/teacher/manage-student');



                // ->with('success', 'Berhasil membuat Materi');
            } else {
                return redirect('/teacher/manage-student');
                // ->with('failed', 'Gagal membuat Materi');
            }
        } else {
            return redirect('/teacher/materi');
            // ->with('failed', 'Gagal membuat Materi');
        }
    }
    public function edit(Request $request)
    {
        // $data['karyawan'] = Pegawai::where([
        //     'id' => $request->segment(3)
        // ])->first();
        $murid = User::where([
            'id' => $request->segment(3)
        ])->first();

        return view('pages.edit-student', compact('murid'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $user = User::where([
            'id' => $request->segment(3)
        ])->first();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->alamat = $request->alamat;
        $user->nomor_induk = $request->nomor_induk;
        // $user->gambar = "Tes";
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        // $karyawan->image=$request->image;

        if ($request->hasFile('gambar')) {
            $fileName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('img/murid', $fileName);

            $user->gambar = $fileName;
            $user->save();
            return redirect('/teacher/manage-student');
        } else {
            $user->save();
            return redirect('/teacher/manage-student');
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);



        if ($user->delete()) {
            return redirect('/teacher/manage-student');
        } else {
            return redirect('/teacher/manage-student');
        }
    }
}
