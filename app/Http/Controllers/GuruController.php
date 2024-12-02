<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\Pelatihan;
use App\Models\User;
use Carbon\Carbon;

class GuruController extends Controller
{

    public function index()
    {
        $data = User::where("role", "=", "Guru")
            ->get();

        // dd($data);
        return view('pages.list-guru', compact('data'));
    }





    public function create()
    {

        $pelatihan = Pelatihan::all();

        return view('pages.add-guru', compact('pelatihan'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {
            if ($request->hasFile('gambar')) {

                // $getPegawaiBaru = Pegawai::orderBy('created_at', 'desc')->first();
                // $getKonfigCuti = Konfig_cuti::where('tahun',(new \DateTime())->format('Y'))->first();
                $fileName = $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move('img/guru', $fileName);

                $user = new User;
                $user->nama_lengkap = $request->nama_lengkap;
                $user->role = "Guru";
                $user->email = $request->email;
                $user->password = $request->password;
                $user->alamat = $request->alamat;
                $user->pelatihan_id = $request->pelatihan_id;

                // $user->nomor_induk = $request->nomor_induk;
                $user->gambar = $fileName;
                $user->created_at = Carbon::now();
                $user->updated_at = Carbon::now();

                $user->save();

                return redirect('/admin/manage-guru');
            } else {
                return redirect('/admin/manage-guru');
            }
        } else {
            return redirect('/admin/manage-guru');
        }
    }
    public function edit(Request $request)
    {
        // $data['karyawan'] = Pegawai::where([
        //     'id' => $request->segment(3)
        // ])->first();
        $guru = User::where([
            'id' => $request->segment(3)
        ])->first();

        $pelatihan = Pelatihan::all();


        return view('pages.edit-guru', compact('guru', 'pelatihan'));
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
        $user->nomor_peserta = $request->nomor_peserta;
        $user->pelatihan_id = $request->pelatihan_id;

        // $user->gambar = "Tes";
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        // $karyawan->image=$request->image;

        if ($request->hasFile('gambar')) {
            $fileName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('img/guru', $fileName);

            $user->gambar = $fileName;
            $user->save();
            return redirect('/admin/manage-guru');
        } else {
            $user->save();
            return redirect('/admin/manage-guru');
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);



        if ($user->delete()) {
            return redirect('/admin/manage-guru');
        } else {
            return redirect('/admin/manage-guru');
        }
    }
}
