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

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian

        if (Session('user')['role'] == 'Guru') {
            $query = User::join('pelatihan', 'pelatihan.id', '=', 'user.pelatihan_id')
                ->where("role", "=", "Murid")
                ->where('pelatihan_id', '=', Session('user')['pelatihan_id']);
        } elseif (Session('user')['role'] == 'Admin') {
            $query = User::join('pelatihan', 'pelatihan.id', '=', 'user.pelatihan_id')
                ->where("role", "=", "Murid");
        } else {
            $query = User::where("role", "=", "Murid");
        }

        // Filter berdasarkan nama jika ada pencarian
        if ($search) {
            $query->where('user.nama_lengkap', 'LIKE', '%' . $search . '%');
        }

        // Gunakan paginate (misalnya 10 item per halaman)
        $data = $query->select('user.*', 'pelatihan.nama')->paginate(10)->appends(['search' => $search]);

        return view('pages.list-murid', compact('data'));
    }







    public function create()
    {
        $pelatihan = Pelatihan::all();

        return view('pages.add-student', compact('pelatihan'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request) {

            // $getPegawaiBaru = Pegawai::orderBy('created_at', 'desc')->first();
            // $getKonfigCuti = Konfig_cuti::where('tahun',(new \DateTime())->format('Y'))->first();


            $user = new User;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->role = "Murid";
            $user->email = $request->email;
            $user->password = $request->password;
            $user->alamat = $request->alamat;
            $user->nomor_peserta = $request->nomor_peserta;
            $user->pelatihan_id = $request->pelatihan_id;

            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            $user->save();

            return redirect('/admin/manage-student');



            // ->with('success', 'Berhasil membuat Materi');

        } else {
            return redirect('/admin/manage-student');
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
        $pelatihan = Pelatihan::all();
        // dd($pelatihan);


        return view('pages.edit-student', compact('murid', 'pelatihan'));
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


        $user->save();
        return redirect('/admin/manage-student');
    }

    public function destroy(Request $request, $id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // dd($id);

        try {
            // Hapus data terkait secara berurutan sesuai relasi
            // 1. Hapus UserAnswers melalui relasi QuizAttempts
            foreach ($user->quizAttempts as $quizAttempt) {
                $quizAttempt->userAnswers()->delete();
            }

            $user->kelulusan()->delete();

            // 2. Hapus QuizAttempts
            $user->quizAttempts()->delete();

            // 3. Hapus data Kelulusan

            // 4. Hapus user
            $user->delete();

            return redirect('/admin/manage-student')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan
            dd($e);

            return redirect('/admin/manage-student')->with('error', 'Terjadi kesalahan saat menghapus siswa.');
        }
    }
}
