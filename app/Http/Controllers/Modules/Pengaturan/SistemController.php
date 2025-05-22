<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Pengaturan\Sistem\SystemSettingService;
use App\Helpers\BreadcrumbHelper;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Pengaturan\Sistem\UpdateSystemSettingRequest;

class SistemController extends Controller
{
    protected $systemSettingService;

    public function __construct(SystemSettingService $systemSettingService)
    {
        $this->systemSettingService = $systemSettingService;
    }

    public function sistem()
    {
        return view('modules.admin.pengaturan-sistem', [
            'setting' => $this->systemSettingService->getSystemSetting(),
            'title' => 'Pengaturan Sistem',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Sistem']
            ]),
            'user' => Auth::user(),
        ]);
    }

    public function update(UpdateSystemSettingRequest $request)
    {
        $setting = SystemSetting::findOrFail(1);
        $this->systemSettingService->updateSystemSetting($setting, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan berhasil diperbarui.'
        ]);
    }
}
