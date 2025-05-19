<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SistemController extends Controller
{
    public function sistem()
    {
        // Ambil data pertama, jika tidak ada akan memunculkan error
        $setting = SystemSetting::first(); // Jika yakin hanya ada satu data

        return view('modules.admin.pengaturan-sistem', [
            'setting' => $setting,
            'title' => 'Pengaturan Sistem',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Sistem']
            ]),
            'user' => Auth::user(),
        ]);
    }



    public function update(Request $request)
    {
        $setting = SystemSetting::findOrFail(1);

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'alamat_lengkap' => 'nullable|string',
            'desa_kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten_kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'negara' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string|max:20',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:30',
            'tahun_berdiri' => 'nullable|digits:4',
            'jenjang_pendidikan' => 'nullable|string|max:50',
            'status_sekolah' => 'nullable|string|max:20',
            'kurikulum_berlaku' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'kop_sekolah' => 'nullable|mimes:png,svg+xml|max:2048',
            'qrcode_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Replace logo
        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('img_setting', 'public');
        }

        // Replace QRCode Logo
        if ($request->hasFile('qrcode_logo')) {
            if ($setting->qrcode_logo && Storage::disk('public')->exists($setting->qrcode_logo)) {
                Storage::disk('public')->delete($setting->qrcode_logo);
            }
            $validated['qrcode_logo'] = $request->file('qrcode_logo')->store('img_setting', 'public');
        }

        // Replace favicon
        if ($request->hasFile('favicon')) {
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('img_setting', 'public');
        }

        // Replace kop sekolah
        if ($request->hasFile('kop_sekolah')) {
            if ($setting->kop_sekolah && Storage::disk('public')->exists($setting->kop_sekolah)) {
                Storage::disk('public')->delete($setting->kop_sekolah);
            }
            $validated['kop_sekolah'] = $request->file('kop_sekolah')->store('img_setting', 'public');
        }

        $setting->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan berhasil diperbarui.'
        ]);
    }
}
