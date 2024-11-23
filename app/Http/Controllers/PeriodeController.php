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

    public function indexMateriMurid()
    {
        $data = Materi::join('user', 'user.id', '=', 'materi.user_id')
            ->select('materi.*', 'user.nama_lengkap')
            ->orderBy('id', 'desc')
            ->get();



        // dd($data);
        return view('pages.materi', compact('data'));
    }

    public function detailMateri(Request $request)
    {
        $materi = Materi::where([
            'id' => $request->segment(3)
        ])->first();

        $activityLog = ActivityLog::create([
            'user_id' => Session('user')['id'],
            'materi_id' => $request->segment(3),
            'start_time' => Carbon::now('Asia/Jakarta'),
        ]);

        // $activityLogs = ActivityLog::

        //     // ->join('user', 'user.id', '=', 'activity_log.user_id')
        //     ->join('materi', 'materi.id', '=', 'activity_log.materi_id')
        //     ->
        //     ->select('activity_log.*', 'materi.judul')
        //     ->first();

        // dd($activityLogs);
        return view('pages.detail-materi', compact('materi', 'activityLog'));
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
        $materi = Periode::where([
            'id' => $request->segment(3)
        ])->first();

        return view('pages.edit-materi', compact('materi'));
    }

    public function update(Request $request)
    {
        $materi = Materi::where([
            'id' => $request->segment(3)
        ])->first();
        // dd($request->all());
        $materi->judul = $request->judul;
        $materi->user_id = 2;
        $materi->deskripsi = $request->deskripsi;
        $materi->created_at = Carbon::now();
        $materi->updated_at = Carbon::now();
        // $karyawan->image=$request->image;

        // if ($materi->save()) {
        if ($request->hasFile('gambar') && $request->hasFile('file')) {
            $gambarName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('img/materi', $gambarName);

            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('file_upload/materi', $fileName);

            $materi->gambar = $gambarName;
            $materi->file = $fileName;

            $materi->save();
            return redirect('/teacher/materi');
        } elseif ($request->hasFile('gambar')) {
            $gambarName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('img/materi', $gambarName);


            $materi->gambar = $gambarName;

            $materi->save();
            return redirect('/teacher/materi');
        } elseif ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('file_upload/materi', $fileName);

            $materi->file = $fileName;

            $materi->save();
            return redirect('/teacher/materi');
        } else {
            $materi->save();
            return redirect('/teacher/materi');
        }
    }

    public function destroy(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);



        if ($materi->delete()) {
            return redirect('/teacher/materi');
        } else {
            return redirect('/teacher/materi');
        }
    }
}
