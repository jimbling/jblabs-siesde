<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;

class DashboardController extends Controller
{
    public function index()
    {
        return view('modules.admin.adminpanel', [
            'title' => 'Dashboard',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Dashboard']
            ])
        ]);
    }
}
