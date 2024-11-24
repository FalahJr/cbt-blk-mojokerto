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
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;

class PelatihanKategoriController extends Controller
{

    public function index()
    {
        $data = Pelatihan::all();

        // dd($data);
        return view('pages.pelatihan-kategori-admin', compact('data'));
    }



    public function create()
    {
        return view('pages.add-pelatihan-kategori');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {
            $kategori = new Pelatihan;
            $kategori->nama = $request->nama;
            $kategori->created_at = Carbon::now();
            $kategori->updated_at = Carbon::now();
            $kategori->save();

            return redirect('/admin/kategori-pelatihan');


            // ->with('success', 'Berhasil membuat Materi');
        } else {
            return redirect('/admin/kategori-pelatihan');
            // ->with('failed', 'Gagal membuat Materi');
        }
    }
    public function edit(Request $request)
    {
        // $data['karyawan'] = Pegawai::where([
        //     'id' => $request->segment(3)
        // ])->first();
        $kategori = Pelatihan::where([
            'id' => $request->segment(3)
        ])->first();

        return view('pages.edit-pelatihan-kategori', compact('kategori'));
    }

    public function update(Request $request)
    {
        $kategori = Pelatihan::where([
            'id' => $request->segment(3)
        ])->first();
        $kategori->nama = $request->nama;
        $kategori->updated_at = Carbon::now();
        $kategori->save();



        return redirect('/admin/kategori-pelatihan');
    }

    public function destroy(Request $request, $id)
    {
        $kategori = Pelatihan::findOrFail($id);



        if ($kategori->delete()) {
            return redirect('/admin/kategori-pelatihan');
        } else {
            return redirect('/admin/kategori-pelatihan');
        }
    }
}
