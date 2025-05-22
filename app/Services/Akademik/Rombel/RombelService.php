<?php

namespace App\Services\Akademik\Rombel;

use App\Models\Rombel;

class RombelService
{
    public function getAllRombels()
    {
        return Rombel::all();
    }

    public function createRombel($data)
    {
        return Rombel::create($data);
    }

    public function updateRombel($rombel, $data)
    {
        return $rombel->update($data);
    }

    public function deleteRombels($ids)
    {
        return Rombel::whereIn('id', $ids)->delete();
    }
}
