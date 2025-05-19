<?php

use App\Models\SystemSetting;

if (!function_exists('system_setting')) {
    /**
     * Ambil nilai pengaturan sistem berdasarkan kolom.
     *
     * @param string|null $key Kolom yang ingin diambil.
     * @param mixed $default Nilai default jika tidak ditemukan.
     * @return mixed
     */
    function system_setting(?string $key = null, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = SystemSetting::first();
        }

        if (!$settings) {
            return $default;
        }

        if ($key === null) {
            return $settings;
        }

        return $settings->{$key} ?? $default;
    }
}
