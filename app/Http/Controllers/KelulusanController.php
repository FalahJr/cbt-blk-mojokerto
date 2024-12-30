<?php

namespace App\Http\Controllers;

use App\Models\Kelulusan;
use Illuminate\Http\Request;


class KelulusanController extends Controller
{

    public function index()
    {
        $kelulusan = Kelulusan::with(['user', 'quizAttempt'])->paginate(10);
        return view('pages.list-kelulusan', compact('kelulusan'));
    }

    public function edit($id)
    {
        $kelulusan = Kelulusan::with(['user', 'quizAttempt'])->findOrFail($id);
        return view('pages.edit-kelulusan', compact('kelulusan'));
    }


    public function update(Request $request, $id)
    {
        $kelulusan = Kelulusan::findOrFail($id);
        $kelulusan->update($request->only('status'));

        return redirect()->route('kelulusan.index')->with('success', 'Data kelulusan berhasil diupdate.');
    }
}
