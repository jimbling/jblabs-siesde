<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Services\DashboardService;
use App\Http\Controllers\Controller;
use App\Helpers\BreadcrumbHelper;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        return view('modules.admin.adminpanel', [
            'title' => 'Dashboard',
            'stats' => $this->dashboardService->getDashboardStats(),
            'recentStudents' => $this->dashboardService->getRecentStudents(),
            'birthdays' => $this->dashboardService->getUpcomingBirthdays(),
            'top_kelurahan' => $this->dashboardService->getTopKelurahan(),
            'studentsIncompleteDocs' => $this->dashboardService->getStudentsWithMissingSpecificDocuments(),
            'rombelStats' => $this->dashboardService->getJumlahPesertaPerRombel(),
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Dashboard']])
        ]);
    }
}
