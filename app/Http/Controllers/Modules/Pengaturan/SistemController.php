<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SistemController extends Controller
{
    public function sistem()
    {
        return view('modules.admin.pengaturan-sistem', [
            'title' => 'Pengaturan Sistem',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Sistem']
            ]),
            'user' => Auth::user(),
        ]);
    }
}
