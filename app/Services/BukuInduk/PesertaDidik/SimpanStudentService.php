<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Models\Student;
use App\Models\OrangTua;
use App\Models\RiwayatSekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SimpanStudentService
{
    public function store(array $data): Student
    {
        return DB::transaction(function () use ($data) {
            // Simpan data siswa
            $student = new Student();
            $student->fill($data);
            $student->save();

            // Simpan orang tua
            $this->storeOrangTua($student->uuid, $data);

            // Simpan riwayat sekolah
            $riwayat = new RiwayatSekolah([
                'siswa_uuid'       => $student->uuid,
                'jenis_pendaftar'  => $data['jenis_pendaftar'] ?? null,
                'sekolah_asal'     => $data['sekolah_asal'] ?? null,
                'dari_sekolah'     => $data['dari_sekolah'] ?? null,
                'alasan_pindah'    => $data['alasan_pindah'] ?? null,
                'catatan_kembali'  => $data['catatan_kembali'] ?? null,
                'lama_belajar'     => $data['lama_belajar'] ?? null,
                'nomor_ijazah'     => $data['nomor_ijazah'] ?? null,
                'tanggal_ijazah'   => isset($data['tanggal_ijazah']) ? Carbon::createFromFormat('d-m-Y', $data['tanggal_ijazah'])->toDateString() : null,
                'skhun'            => $data['skhun'] ?? null,
                'tanggal_masuk'    => now()->toDateString(),
                'kelas_diterima'   => $data['kelas_diterima'] ?? null,
            ]);
            $riwayat->save();

            // Update siswa dengan riwayat
            $student->riwayat_sekolah_id = $riwayat->id;
            $student->save();

            return $student;
        });
    }

    protected function storeOrangTua(string $siswaUuid, array $data): void
    {
        $tipeList = ['ayah', 'ibu', 'wali'];
        foreach ($tipeList as $tipe) {
            if (!empty($data["{$tipe}_nama"])) {
                OrangTua::create([
                    'siswa_uuid'     => $siswaUuid,
                    'tipe'           => $tipe,
                    'nama'           => $data["{$tipe}_nama"],
                    'tahun_lahir'    => $data["{$tipe}_tahun_lahir"] ?? null,
                    'pendidikan_id'  => $data["{$tipe}_pendidikan_id"] ?? null,
                    'pekerjaan_id'   => $data["{$tipe}_pekerjaan_id"] ?? null,
                    'penghasilan_id' => $data["{$tipe}_penghasilan_id"] ?? null,
                    'nik'            => $data["{$tipe}_nik"] ?? null,
                    'kewarganegaraan' => $data["{$tipe}_kewarganegaraan"] ?? null,
                ]);
            }
        }
    }
}
