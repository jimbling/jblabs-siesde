<?php

namespace App\Helpers;

class BreadcrumbHelper
{
    public static function generate(array $crumbs): array
    {
        // Selalu mulai dengan Home
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('dashboard')],
        ];

        // Tambahkan breadcrumb yang dikirim
        foreach ($crumbs as $crumb) {
            $breadcrumbs[] = [
                'name' => $crumb['name'],
                'url' => $crumb['url'] ?? null, // URL opsional
            ];
        }

        return $breadcrumbs;
    }
}
