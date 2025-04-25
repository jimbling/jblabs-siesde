<?php

namespace App\Imports;

use App\Models\Agama;
use App\Models\Student;
use App\Models\OrangTua;
use App\Models\JenisTinggal;
use App\Models\AlatTransportasi;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class StudentsImport implements ToModel, WithHeadingRow
{
    protected $daftarAgama;
    protected $daftarJenisTinggal;
    protected $daftarTransportasi;

    public function __construct()
    {
        $this->daftarAgama = Agama::pluck('id', 'nama')->toArray();
        $this->daftarJenisTinggal = JenisTinggal::pluck('id', 'nama')->toArray();
        $this->daftarTransportasi =  AlatTransportasi::pluck('id', 'nama')->toArray();
        Log::info('Construct Import dijalankan');
    }

    public function model(array $row)
    {
        Log::info('Masuk ke fungsi model()');
        Log::info('Data Siswa: ' . json_encode($row));

        try {
            // Konversi tanggal Excel ke format Y-m-d
            $tanggalLahir = Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');

            // Mapping data master
            $agama = $this->daftarAgama[$row['agama_id']] ?? null;
            $jenisTinggal = $this->daftarJenisTinggal[$row['jenis_tinggal_id']] ?? null;
            $alatTransportasi = $this->daftarTransportasi[$row['alat_transportasi_id']] ?? null;

            // Validasi data master
            if (!$agama || !$jenisTinggal || !$alatTransportasi) {
                Log::error("Data referensi tidak ditemukan. Agama: $agama, Tinggal: $jenisTinggal, Transportasi: $alatTransportasi");
                return null;
            }

            // Simpan siswa
            $student = Student::create([
                'uuid' => $row['uuid'],
                'nama' => $row['nama'],
                'nipd' => $row['nipd'],
                'jk' => $row['jk'],
                'nisn' => $row['nisn'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $tanggalLahir,
                'nik' => $row['nik'],
                'alamat' => $row['alamat'],
                'rt' => $row['rt'],
                'rw' => $row['rw'],
                'dusun' => $row['dusun'],
                'kelurahan' => $row['kelurahan'],
                'kecamatan' => $row['kecamatan'],
                'kode_pos' => $row['kode_pos'],
                'telepon' => $row['telepon'],
                'hp' => $row['hp'],
                'email' => $row['email'],
                'skhun' => $row['skhun'],
                'penerima_kps' => $row['penerima_kps'],
                'no_kps' => $row['no_kps'],
                'penerima_kip' => $row['penerima_kip'],
                'nomor_kip' => $row['nomor_kip'],
                'nama_di_kip' => $row['nama_di_kip'],
                'nomor_kks' => $row['nomor_kks'],
                'no_registrasi_akta' => $row['no_registrasi_akta'],
                'bank' => $row['bank'],
                'nomor_rekening' => $row['nomor_rekening'],
                'rekening_atas_nama' => $row['rekening_atas_nama'],
                'layak_pip' => $row['layak_pip'],
                'alasan_layak_pip' => $row['alasan_layak_pip'],
                'kebutuhan_khusus' => $row['kebutuhan_khusus'],
                'anak_ke' => $row['anak_ke'],
                'no_kk' => $row['no_kk'],
                'jumlah_saudara_kandung' => $row['jumlah_saudara_kandung'],
                'jarak_rumah_km' => is_numeric($row['jarak_rumah_km']) ? floor((float)$row['jarak_rumah_km']) : null,
                'lintang' => $row['lintang'],
                'bujur' => $row['bujur'],
                'agama_id' => $agama,
                'jenis_tinggal_id' => $jenisTinggal,
                'alat_transportasi_id' => $alatTransportasi,
                'riwayat_sekolah_id' => null,
            ]);

            // Simpan data orang tua dan hubungkan
            foreach (['Ayah', 'Ibu'] as $tipe) {
                try {
                    $tipeLower = strtolower($tipe);
                    $nama = $row['nama_' . $tipeLower] ?? null;

                    if (!$nama) {
                        Log::warning("Data $tipe tidak tersedia untuk siswa UUID: " . $row['uuid']);
                        continue;
                    }

                    Log::info("Memproses $tipe untuk siswa UUID: " . $row['uuid']);

                    $orangTua = OrangTua::create([
                        'siswa_uuid' => $row['uuid'],
                        'tipe' => $tipeLower,
                        'nama' => $nama,
                        'tahun_lahir' => $row['tahun_lahir_' . $tipeLower] ?? null,
                        'pendidikan_id' => $row['pendidikan_id_' . $tipeLower] ?? null,
                        'pekerjaan_id' => $row['pekerjaan_id_' . $tipeLower] ?? null,
                        'penghasilan_id' => $row['penghasilan_id_' . $tipeLower] ?? null,
                        'nik' => $row['nik_' . $tipeLower] ?? null,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal menyimpan data $tipe untuk siswa UUID: " . $row['uuid'] . ' | Error: ' . $e->getMessage());
                    continue;
                }
            }


            return $student;
        } catch (\Exception $e) {
            Log::error('Error saat memproses baris: ' . $e->getMessage());
            return null;
        }
    }

    // Fungsi untuk menyimpan atau mencari orang tua
    private function saveOrFindOrangTua($row, $tipe)
    {
        // Cari orang tua berdasarkan tipe dan nik
        $orangTua = OrangTua::where('siswa_uuid', $row['uuid'])->where('tipe', $tipe)->first();

        // Jika tidak ada, buat orang tua baru
        if (!$orangTua) {
            $orangTua = OrangTua::create([
                'siswa_uuid' => $row['uuid'],
                'tipe' => $tipe,
                'nama' => $row['nama_' . strtolower($tipe)],
                'tahun_lahir' => $row['tahun_lahir_' . strtolower($tipe)],
                'pendidikan_id' => $row['pendidikan_id_' . strtolower($tipe)],
                'pekerjaan_id' => $row['pekerjaan_id_' . strtolower($tipe)],
                'penghasilan_id' => $row['penghasilan_id_' . strtolower($tipe)],
                'nik' => $row['nik_' . strtolower($tipe)],
            ]);
        }

        return $orangTua;
    }
}
