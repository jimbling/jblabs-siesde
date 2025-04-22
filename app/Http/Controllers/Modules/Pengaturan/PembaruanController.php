<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PembaruanController extends Controller
{
    public function pembaruan()
    {
        return view('modules.admin.pengaturan-pembaruan', [
            'title' => 'Pembaruan Sistem',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pembaruan Sistem']
            ]),
            'user' => Auth::user(),
        ]);
    }
}
