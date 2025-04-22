<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AksesController extends Controller
{
    public function akses()
    {
        return view('modules.admin.pengaturan-akses', [
            'title' => 'Pengaturan Akses',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Sistem']
            ]),
            'user' => Auth::user(),
        ]);
    }
}
