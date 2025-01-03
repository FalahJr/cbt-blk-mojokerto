<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;

class PeriodeController extends Controller
{

    public function index()
    {
        $data = Periode::all();

        // dd($data);
        return view('pages.periode-admin', compact('data'));
    }



    public function create()
    {
        return view('pages.add-periode');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {
            $periode = new Periode;
            $periode->nama = $request->nama;
            $periode->created_at = Carbon::now();
            $periode->updated_at = Carbon::now();
            $periode->save();

            return redirect('/admin/periode');


            // ->with('success', 'Berhasil membuat Materi');
        } else {
            return redirect('/admin/periode');
            // ->with('failed', 'Gagal membuat Materi');
        }
    }
    public function edit(Request $request)
    {
        // $data['karyawan'] = Pegawai::where([
        //     'id' => $request->segment(3)
        // ])->first();
        $periode = Periode::where([
            'id' => $request->segment(3)
        ])->first();

        return view('pages.edit-periode', compact('periode'));
    }

    public function update(Request $request)
    {
        $periode = Periode::where([
            'id' => $request->segment(3)
        ])->first();
        $periode->nama = $request->nama;
        $periode->updated_at = Carbon::now();
        $periode->save();



        return redirect('/admin/periode');
    }

    public function destroy(Request $request, $id)
    {
        $periode = Periode::findOrFail($id);



        if ($periode->delete()) {
            return redirect('/admin/periode');
        } else {
            return redirect('/admin/periode');
        }
    }
}
