<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingEssayOnline;
use Carbon\Carbon;
class SettingtimenilEssayController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }

    public function index()
    {
        $setting = SettingEssayOnline::get();
        return view('admin.ujian.uts.baak.setting_essay.index',compact('setting'));
    }

    public function edit($id)
    {
        $setting = SettingEssayOnline::findOrFail($id);
        $setting->mulai = Carbon::parse($setting->mulai)->format('Y-m-d H:i:s');
        $setting->selsai = Carbon::parse($setting->selsai)->format('Y-m-d H:i:s');
        return view('admin.ujian.uts.baak.setting_essay.edit', compact('setting'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'mulai' => 'required|date',
            'selsai' => 'required|date|after_or_equal:mulai',
            'paket' => 'required|string',
            'petugas' => 'required|string',
        ], [
            'selsai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.'
        ]);
    
        $setting = SettingEssayOnline::findOrFail($id);
        $setting->update([
            'mulai' => $request->mulai,
            'selsai' => $request->selsai,
            'paket' => $request->paket,
            'petugas' => $request->petugas,
        ]);
    
        return redirect()->route('nilai-essay-online.index')->with('success', 'Data berhasil diperbarui.');
    }
    
    
}
