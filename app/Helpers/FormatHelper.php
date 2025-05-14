<?php

namespace App\Helpers;

class FormatHelper
{
    public static function tanggal($tanggal)
    {
        if (!$tanggal) return '-';

        setlocale(LC_TIME, 'id_ID.UTF-8');
        \Carbon\Carbon::setLocale('id');
        return \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y');
    }
}
