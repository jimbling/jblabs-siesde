<?php

namespace App\Services\Pengaturan\Sistem;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;

class SystemSettingService
{
    public function getSystemSetting()
    {
        return SystemSetting::first(); // Mengambil satu data pengaturan sistem
    }

    public function updateSystemSetting(SystemSetting $setting, array $validatedData)
    {
        // Handle file uploads
        $validatedData = $this->handleFileUploads($setting, $validatedData);

        // Update data
        return $setting->update($validatedData);
    }

    private function handleFileUploads(SystemSetting $setting, array $validatedData)
    {
        $files = ['logo', 'qrcode_logo', 'favicon', 'kop_sekolah'];

        foreach ($files as $file) {
            if (request()->hasFile($file)) {
                // Hapus file lama jika ada
                if ($setting->$file && Storage::disk('public')->exists($setting->$file)) {
                    Storage::disk('public')->delete($setting->$file);
                }

                // Simpan file baru
                $validatedData[$file] = request()->file($file)->store('img_setting', 'public');
            }
        }

        return $validatedData;
    }
}
