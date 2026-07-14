<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;  
use App\Models\Tutor;  

class TutorController extends Controller
{
    public function index()
    {
        $tutors = Tutor::with('user')
        ->latest()
        ->get();

        return view('tutor.index', compact('tutors'));
    }


    public function applyPage()
    {
        return view('tutor.apply');
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'utbk_file' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'reason' => 'required',
        ], [
            'utbk_file.required' => 'File UTBK wajib diunggah.',
            'utbk_file.file' => 'File yang diunggah tidak valid.',
            'utbk_file.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG.',
            'utbk_file.max' => 'Ukuran file maksimal 2 MB.',
            'reason.required' => 'Alasan menjadi tutor wajib diisi.'
        ]);

        if(!$request->has('tps') && !$request->has('literasi') && !$request->has('numerasi')) {
            return back()->with('error', 'Pilih minimal satu bidang yang ingin diajarkan!');
        }

        // upload file
        $path = $request->file('utbk_file')->store('utbk_files', 'public');

        DB::table('tutor_applications')->insert([
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'utbk_file' => $path,
            'tps' => $request->has('tps') ? 1 : 0,
            'literasi' => $request->has('literasi') ? 1 : 0,
            'numerasi' => $request->has('numerasi') ? 1 : 0,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        return redirect()->route('tutor')->with('success_message', 'Apply berhasil, tunggu approval!');
    }

    public function show($id)
    {
        $tutor = Tutor::with('user')->findOrFail($id);

        return view('tutor.show', compact('tutor'));
    }
}