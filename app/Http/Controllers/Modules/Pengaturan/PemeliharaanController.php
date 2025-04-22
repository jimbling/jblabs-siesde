<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PemeliharaanController extends Controller
{
    public function pemeliharaan()
    {
        return view('modules.admin.pengaturan-pemeliharaan', [
            'title' => 'Pemeliharaan Sistem',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pemeliharaan Sistem']
            ]),
            'user' => Auth::user(),
        ]);
    }
}
