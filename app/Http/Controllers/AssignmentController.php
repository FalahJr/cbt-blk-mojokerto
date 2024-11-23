<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\Quizzes;
use App\Models\User;
use Carbon\Carbon;

class AssignmentController extends Controller
{

    public function index()
    {
        $data = Assignment::orderBy('id', 'desc')
            ->get();

        // dd($data);
        return view('pages.assignment-guru', compact('data'));
    }

    public function indexAssignmentMurid()
    {
        $data = Assignment::join('materi', 'materi.id', '=', 'assignment.materi_id')
            ->select('assignment.*', 'materi.judul as judul_materi')
            // ->orderBy('id', 'desc')
            ->get();




        // dd($data);
        return view('pages.assignment', compact('data'));
    }





    public function create()
    {
        $materi = Materi::all();
        // dd($materi);


        return view('pages.add-assignment', compact('materi'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {
            if ($request->hasFile('gambar') && $request->hasFile('file')) {
                // save gambar ke folder public
                $fileGambarName = $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move('img/assignment', $fileGambarName);

                // save file ke folder public
                $fileName = $request->file('file')->getClientOriginalName();
                $request->file('file')->move('file_upload/assignment', $fileName);

                $assignment = new Assignment;
                $assignment->judul = $request->judul;
                $assignment->materi_id = $request->materi_id;
                $assignment->deskripsi = $request->deskripsi;
                $assignment->gambar = $fileGambarName;
                $assignment->file = $fileName;
                $assignment->start_date = $request->start_date;
                $assignment->end_date = $request->end_date;
                $assignment->created_at = Carbon::now();
                $assignment->updated_at = Carbon::now();


                // if ($materi->save()) {

                //     $notifikasi = new Notifikasi;
                //     $notifikasi->role = "Murid";
                //     $notifikasi->judul = "Materi baru dengan judul '" . $request->judul  . "' telah diunggah, yuk pelajari !!!";
                //     $notifikasi->is_seen = "N";
                //     $notifikasi->created_at = Carbon::now();
                //     $notifikasi->updated_at = Carbon::now();

                //     $notifikasi->save();

                //     return redirect('/teacher/materi');
                // }

                $assignment->save();
                return redirect('/teacher/assignment');
            }
            // ->with('success', 'Berhasil membuat Materi');
        } else {
            return redirect('/teacher/assignment');
            // ->with('failed', 'Gagal membuat Materi');
        }
    }
    public function edit(Request $request)
    {
        // $data['karyawan'] = Pegawai::where([
        //     'id' => $request->segment(3)
        // ])->first();


        // dd($request->segment(4));

        if (Session('user')['role'] == 'Guru') {
            $assignment = Assignment::where([
                'id' => $request->segment(3)
            ])->first();

            $materi = Materi::all();

            return view('pages.edit-assignment', compact('assignment', 'materi'));
        } else {
            $assignment = Assignment::where([
                'id' => $request->segment(4)
            ])->with('materi')->first();

            // dd($assignment->materi->judul);

            return view('pages.detail-assignment', compact('assignment'));
        }
    }

    public function viewSubmissions($id)
    {
        // dd($id);
        $murid = User::where('role', '=', 'Murid')->get();
        // dd($murid);
        $data = [];

        foreach ($murid as $list_murid) {
            $cek = AssignmentSubmission::where('assignment_id', '=', $id)
                ->where('user_id', '=', $list_murid->id)
                ->first();

            $data[] = [
                'nama_lengkap' => $list_murid->nama_lengkap,
                'status' => $cek ? $cek->status : "Belum Mengumpulkan",
                'tgl_submit' => $cek ? Carbon::parse($cek->created_at) : NULL,
                'file' => $cek ? $cek->file : NULL,
            ];

            // dd($cek);

            # code...
        }
        // dd($data);
        return view('pages.view-submissions', compact('data'));
    }

    public function update(Request $request)
    {

        $assignment = Assignment::where([
            'id' => $request->segment(3)
        ])->first();
        $assignment->judul = $request->judul;
        $assignment->materi_id = $request->materi_id;
        $assignment->deskripsi = $request->deskripsi;
        // $assignment->gambar = $fileGambarName;
        // $assignment->file = $fileName;
        $assignment->start_date = $request->start_date;
        $assignment->end_date = $request->end_date;
        $assignment->created_at = Carbon::now();
        $assignment->updated_at = Carbon::now();
        // $karyawan->image=$request->image;

        // if ($materi->save()) {
        if ($request->hasFile('gambar') && $request->hasFile('file')) {
            $fileGambarName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('img/assignment', $fileGambarName);

            // save file ke folder public
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('file_upload/assignment', $fileName);

            $assignment->gambar = $fileGambarName;
            $assignment->file = $fileName;
            $assignment->save();
            return redirect('/teacher/assignment');
        } elseif ($request->hasFile('gambar')) {
            // dd($request->all());

            $fileGambarName = $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move('img/assignment', $fileGambarName);


            $assignment->gambar = $fileGambarName;
            $assignment->save();
            return redirect('/teacher/assignment');
        } elseif ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('file_upload/assignment', $fileName);



            $assignment->file = $fileName;

            $assignment->save();
            return redirect('/teacher/assignment');
        } else {
            $assignment->save();
            return redirect('/teacher/assignment');
        }
    }

    public function destroy(Request $request, $id)
    {
        // $assignment = Assignment::findOrFail($id);
        $getAssignmentSubmission = AssignmentSubmission::where('assignment_id', '=', $id)->get();
        if ($getAssignmentSubmission) {
            $deleteAssignmentSubmission = AssignmentSubmission::where('assignment_id', '=', $id)->delete();

            if ($deleteAssignmentSubmission) {
                Assignment::where('id', $id)->delete();
                return redirect('/teacher/assignment');
            }
        } else {
            Assignment::where('id', $id)->delete();
            return redirect('/teacher/assignment');
        }


        // if ($assignment->delete()) {
        //     return redirect('/teacher/assignment');
        // } else {
        //     return redirect('/teacher/assignment');
        // }
    }

    public function submitSubmission(Request $request, $id)
    {
        // dd($id);
        if ($request->hasFile('file')) {
            // dd($request->all());

            $file = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('file_upload/submission/', $file);


            // Ambil assignment berdasarkan ID
            $assignment = Assignment::findOrFail($id);
            // dd($assignment);

            // Periksa apakah pengumpulan dilakukan sebelum atau setelah deadline
            $currentDateTime = Carbon::now();
            $endTime = Carbon::parse($assignment->end_date);
            // dd($assignment->end_date);

            $status = $currentDateTime->lessThanOrEqualTo($endTime) ? "Sudah Mengumpulkan" : "Terlambat";


            $submission = new AssignmentSubmission;
            $submission->user_id = Session('user')['id'];
            $submission->assignment_id = $id;
            $submission->file = $file;
            $submission->status = $status;
            $submission->save();
            return redirect('/student/assignment/submission/' . $id);
        }
        return redirect('assignment/submission/submission/' . $id);
    }
}
