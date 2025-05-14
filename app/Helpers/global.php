<?php

use App\Helpers\FormatHelper;

if (!function_exists('tanggal')) {
    function tanggal($tanggal)
    {
        return FormatHelper::tanggal($tanggal);
    }
}
