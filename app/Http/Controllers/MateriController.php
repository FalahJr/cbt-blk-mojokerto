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

class MateriController extends Controller
{

    public function index()
    {
        $data = Materi::join('user', 'user.id', '=', 'materi.user_id')
            ->select('materi.*', 'user.nama_lengkap')
            ->get();

        // dd($data);
        return view('pages.materi-guru', compact('data'));
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

    public function logEndTime(Request $request)
    {
        // $activityLog = ActivityLog::findOrFail($request->log_id);
        // $activityLog->update([
        //     'end_time' => Carbon::now('Asia/Jakarta'),
        // ]);
        $activityLog = ActivityLog::where('activity_log.id', $request->log_id)
            // ->join('user', 'user.id', '=', 'activity_log.user_id')
            ->join('materi', 'materi.id', '=', 'activity_log.materi_id')
            ->select('activity_log.*', 'materi.judul')
            ->first();

        // $getData = ActivityLog::where('id', $request->log_id)
        //     // ->join('user', 'user.id', '=', 'activity_log.user_id')
        //     ->join('materi', 'materi.id', '=', 'activity_log.materi_id')
        //     ->select('activity_log.*', 'materi.judul as judul_materi')
        //     ->first();

        if ($activityLog) {
            $activityLog->update(['end_time' => Carbon::now('Asia/Jakarta')]);

            // Create a notification for the teacher
            // dd($activityLog);
            Notifikasi::create([
                'role' => 'Guru',
                'judul' => Session('user')['nama'] . ' selesai membaca materi',
                'deskripsi' =>  Session('user')['nama'] . ' telah selesai membaca materi : ' . $activityLog->judul . ' dari jam : ' . Carbon::parse($activityLog->created_at)->format('H:i:s A') . ' sampai ' . Carbon::parse($activityLog->end_time)->format('H:i:s A'),
                'is_seen' => 'N',
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);

            // $notifikasi = new Notifikasi;
            // $notifikasi->role = "Guru";
            // $notifikasi->judul = "Murid selesai membaca materi";
            // $notifikasi->is_seen = "N";
            // $notifikasi->created_at = Carbon::now();
            // $notifikasi->updated_at = Carbon::now();

            // $notifikasi->save();


            return response()->json(['message' => 'End time logged successfully']);
        }

        return response()->json(['message' => 'Log not found'], 404);



        // $logId = $request->input('log_id');
        // // Update the end time in the activity log
        // $activityLog = ActivityLog::find($logId);
        // if ($activityLog) {
        //     $activityLog->end_time = now();
        //     $activityLog->save();
        // }

        // return response()->json(['status' => 'success']);
    }

    public function create()
    {
        return view('pages.add-materi');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {
            if ($request->hasFile('gambar') && $request->hasFile('file')) {

                $gambarName = $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move('img/materi', $gambarName);

                $fileName = $request->file('file')->getClientOriginalName();
                $request->file('file')->move('file_upload/materi', $fileName);

                $materi = new Materi;
                $materi->judul = $request->judul;
                $materi->user_id = 2;
                $materi->deskripsi = $request->deskripsi;
                $materi->gambar = $gambarName;
                $materi->file = $fileName;
                $materi->created_at = Carbon::now();
                $materi->updated_at = Carbon::now();


                if ($materi->save()) {

                    $notifikasi = new Notifikasi;
                    $notifikasi->role = "Murid";
                    $notifikasi->judul = "Materi baru dengan judul '" . $request->judul  . "' telah diunggah, yuk pelajari !!!";
                    $notifikasi->is_seen = "N";
                    $notifikasi->created_at = Carbon::now();
                    $notifikasi->updated_at = Carbon::now();

                    $notifikasi->save();

                    return redirect('/teacher/materi');
                }
                return redirect('/teacher/materi');
            } elseif ($request->hasFile('gambar')) {

                $gambarName = $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move('img/materi', $gambarName);


                $materi = new Materi;
                $materi->judul = $request->judul;
                $materi->user_id = 2;
                $materi->deskripsi = $request->deskripsi;
                $materi->gambar = $gambarName;
                $materi->created_at = Carbon::now();
                $materi->updated_at = Carbon::now();


                if ($materi->save()) {

                    $notifikasi = new Notifikasi;
                    $notifikasi->role = "Murid";
                    $notifikasi->judul = "Materi baru dengan judul '" . $request->judul  . "' telah diunggah, yuk pelajari !!!";
                    $notifikasi->is_seen = "N";
                    $notifikasi->created_at = Carbon::now();
                    $notifikasi->updated_at = Carbon::now();

                    $notifikasi->save();

                    return redirect('/teacher/materi');
                }
                return redirect('/teacher/materi');
            }
            // ->with('success', 'Berhasil membuat Materi');
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
        $materi = Materi::where([
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
