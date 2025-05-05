<?php

namespace App\Imports;

use App\Models\Agama;
use App\Models\Student;
use App\Models\OrangTua;
use App\Models\JenisTinggal;
use App\Models\RiwayatSekolah;
use App\Models\AlatTransportasi;
use App\Exports\ImportErrorExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;




class StudentsImport implements ToCollection, WithHeadingRow, WithEvents
{
    protected $daftarAgama;
    protected $daftarJenisTinggal;
    protected $daftarTransportasi;
    protected $daftarPendidikan;
    protected $daftarPekerjaan;
    protected $daftarPenghasilan;
    protected $errorRows = [];
    protected $hasErrors = false;

    public function hasErrors()
    {
        return $this->hasErrors;
    }

    public function __construct()
    {
        $this->daftarAgama = Agama::pluck('id', 'nama')->toArray();
        $this->daftarJenisTinggal = JenisTinggal::pluck('id', 'nama')->toArray();
        $this->daftarTransportasi =  AlatTransportasi::pluck('id', 'nama')->toArray();
        $this->daftarPendidikan = DB::table('pendidikan')->pluck('id', 'jenjang')->toArray();
        $this->daftarPekerjaan = DB::table('pekerjaan')->pluck('id', 'nama')->toArray();
        $this->daftarPenghasilan = DB::table('penghasilan')->pluck('id', 'rentang')->toArray();
    }

    public function collection(Collection $rows)
    {


        foreach ($rows as $index => $row) {
            // Lewati baris kosong
            if ($row->filter()->isEmpty()) {
                continue;
            }

            try {
                $tanggalLahir = Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
                $tanggalMasuk = Date::excelToDateTimeObject($row['tanggal_masuk'])->format('Y-m-d');

                $agama = $this->cariMapping($this->daftarAgama, $row['agama_id']);
                $jenisTinggal = $this->cariMapping($this->daftarJenisTinggal, $row['jenis_tinggal_id']);
                $alatTransportasi = $this->cariMapping($this->daftarTransportasi, $row['alat_transportasi_id']);

                if (!$agama || !$jenisTinggal || !$alatTransportasi) {
                    $this->hasErrors = true;
                    $this->errorRows[] = array_merge($row->toArray(), [
                        'keterangan_error' => 'Data tidak valid pada kolom: ' .
                            (!$agama ? 'Agama, ' : '') .
                            (!$jenisTinggal ? 'Jenis Tinggal, ' : '') .
                            (!$alatTransportasi ? 'Transportasi, ' : '')
                    ]);
                    continue;
                }


                // Validasi referensi dari DB (pekerjaan, pendidikan, dll)
                $pendidikanAyah = $this->cariMapping($this->daftarPendidikan, $row['pendidikan_id_ayah']);
                $pekerjaanAyah = $this->cariMapping($this->daftarPekerjaan, $row['pekerjaan_id_ayah']);
                $penghasilanAyah = $this->cariMapping($this->daftarPenghasilan, $row['penghasilan_id_ayah']);

                $pendidikanIbu = $this->cariMapping($this->daftarPendidikan, $row['pendidikan_id_ibu']);
                $pekerjaanIbu = $this->cariMapping($this->daftarPekerjaan, $row['pekerjaan_id_ibu']);
                $penghasilanIbu = $this->cariMapping($this->daftarPenghasilan, $row['penghasilan_id_ibu']);


                if (!$pendidikanAyah || !$pekerjaanAyah || !$penghasilanAyah || !$pendidikanIbu || !$pekerjaanIbu || !$penghasilanIbu) {
                    $failedFields = [];
                    if (!$pendidikanAyah) $failedFields[] = "Pendidikan Ayah: {$row['pendidikan_id_ayah']}";
                    if (!$pekerjaanAyah) $failedFields[] = "Pekerjaan Ayah: {$row['pekerjaan_id_ayah']}";
                    if (!$penghasilanAyah) $failedFields[] = "Penghasilan Ayah: {$row['penghasilan_id_ayah']}";
                    if (!$pendidikanIbu) $failedFields[] = "Pendidikan Ibu: {$row['pendidikan_id_ibu']}";
                    if (!$pekerjaanIbu) $failedFields[] = "Pekerjaan Ibu: {$row['pekerjaan_id_ibu']}";
                    if (!$penghasilanIbu) $failedFields[] = "Penghasilan Ibu: {$row['penghasilan_id_ibu']}";

                    $this->hasErrors = true;
                    $this->errorRows[] = array_merge($row->toArray(), [
                        'keterangan_error' => 'Mapping gagal data orang tua: ' . implode(', ', $failedFields)
                    ]);
                    continue;
                }
                $siswa = Student::create([

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
                    'jarak_rumah_km' => is_numeric($row['jarak_rumah_km']) ? floor((float) $row['jarak_rumah_km']) : null,
                    'lintang' => $row['lintang'],
                    'bujur' => $row['bujur'],
                    'agama_id' => $agama,
                    'jenis_tinggal_id' => $jenisTinggal,
                    'alat_transportasi_id' => $alatTransportasi,
                ]);

                // Simpan data orang tua (ayah dan ibu)
                OrangTua::create([
                    'siswa_uuid' => $siswa->uuid,
                    'tipe' => 'Ayah',
                    'nama' => $row['nama_ayah'],
                    'tahun_lahir' => $row['tahun_lahir_ayah'],
                    'pendidikan_id' => $pendidikanAyah,
                    'pekerjaan_id' => $pekerjaanAyah,
                    'penghasilan_id' => $penghasilanAyah,
                    'nik' => $row['nik_ayah'],
                ]);

                OrangTua::create([
                    'siswa_uuid' => $siswa->uuid,
                    'tipe' => 'Ibu',
                    'nama' => $row['nama_ibu'],
                    'tahun_lahir' => $row['tahun_lahir_ibu'],
                    'pendidikan_id' => $pendidikanIbu,
                    'pekerjaan_id' => $pekerjaanIbu,
                    'penghasilan_id' => $penghasilanIbu,
                    'nik' => $row['nik_ibu'],
                ]);

                // Setelah siswa tersimpan, baru buat RiwayatSekolah
                $riwayatSekolah = RiwayatSekolah::create([
                    'siswa_uuid' => $siswa->uuid,
                    'sekolah_asal' => $row['sekolah_asal'],
                    'jenis_pendaftar' => $row['jenis_pendaftar'],
                    'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_masuk'])->format('Y-m-d'),
                ]);
                // Update siswa, isi riwayat_sekolah_id
                $siswa->update([
                    'riwayat_sekolah_id' => $riwayatSekolah->id,
                ]);
            } catch (\Throwable $th) {
                $this->hasErrors = true;
                $this->errorRows[] = array_merge($row->toArray(), [
                    'keterangan_error' => 'Terjadi kesalahan saat menyimpan data: ' . $th->getMessage()
                ]);
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterImport::class => function () {
                if (!empty($this->errorRows)) {
                    $filename = 'error_import_siswa_' . now()->format('Ymd_His') . '.xlsx';

                    // Simpan file di folder storage/app/public/logs
                    Excel::store(new ImportErrorExport($this->errorRows), 'logs/' . $filename, 'public');

                    // Simpan path lengkap ke session untuk akses di view
                    session()->flash('import_error_file', asset('storage/logs/' . $filename));
                }
            },
        ];
    }


    private function cariMapping(array $daftar, $cari)
    {
        foreach ($daftar as $key => $value) {
            if (strtolower(trim($key)) === strtolower(trim($cari))) {
                return $value;
            }
        }
        return null;
    }
}





// class StudentsImport implements ToModel, WithHeadingRow
// {
//     protected $daftarAgama;
//     protected $daftarJenisTinggal;
//     protected $daftarTransportasi;

//     public function __construct()
//     {
//         $this->daftarAgama = Agama::pluck('id', 'nama')->toArray();
//         $this->daftarJenisTinggal = JenisTinggal::pluck('id', 'nama')->toArray();
//         $this->daftarTransportasi =  AlatTransportasi::pluck('id', 'nama')->toArray();
//         Log::info('Construct Import dijalankan');
//     }

//     public function model(array $row)
//     {
//         // Cek apakah seluruh baris kosong
//         if (empty(array_filter($row))) {
//             Log::info('Baris kosong dilewati.');
//             return null;
//         }

//         // Cek apakah kolom penting kosong (misalnya nama dan nisn)
//         if (empty($row['nama']) || empty($row['nisn'])) {
//             Log::warning('Baris dilewati karena kolom wajib kosong. Nama atau NISN kosong.');
//             return null;
//         }
//         Log::info('Masuk ke fungsi model()');
//         Log::info('Data Siswa: ' . json_encode($row));

//         try {
//             // Konversi tanggal lahir dari format Excel
//             $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');

//             $agama = $this->cariMapping($this->daftarAgama, $row['agama_id']);
//             if (!$agama) {
//                 Log::error('Agama tidak ditemukan: ' . $row['agama_id']);
//                 return null;
//             }

//             $jenisTinggal = $this->cariMapping($this->daftarJenisTinggal, $row['jenis_tinggal_id']);
//             if (!$jenisTinggal) {
//                 Log::error('Jenis tinggal tidak ditemukan: ' . $row['jenis_tinggal_id']);
//                 return null;
//             }

//             $alatTransportasi = $this->cariMapping($this->daftarTransportasi, $row['alat_transportasi_id']);
//             if (!$alatTransportasi) {
//                 Log::error('Alat transportasi tidak ditemukan: ' . $row['alat_transportasi_id']);
//                 return null;
//             }



//             $pendidikanAyah = DB::table('pendidikan')->where('jenjang', $row['pendidikan_id_ayah'])->value('id');
//             $pekerjaanAyah = DB::table('pekerjaan')->where('nama', $row['pekerjaan_id_ayah'])->value('id');
//             $penghasilanAyah = DB::table('penghasilan')->where('rentang', $row['penghasilan_id_ayah'])->value('id');

//             $pendidikanIbu = DB::table('pendidikan')->where('jenjang', $row['pendidikan_id_ibu'])->value('id');
//             $pekerjaanIbu = DB::table('pekerjaan')->where('nama', $row['pekerjaan_id_ibu'])->value('id');
//             $penghasilanIbu = DB::table('penghasilan')->where('rentang', $row['penghasilan_id_ibu'])->value('id');


//             // Simpan data siswa terlebih dahulu
//             $siswa = Student::create([

//                 'nama' => $row['nama'],
//                 'nipd' => $row['nipd'],
//                 'jk' => $row['jk'],
//                 'nisn' => $row['nisn'],
//                 'tempat_lahir' => $row['tempat_lahir'],
//                 'tanggal_lahir' => $tanggalLahir,
//                 'nik' => $row['nik'],
//                 'alamat' => $row['alamat'],
//                 'rt' => $row['rt'],
//                 'rw' => $row['rw'],
//                 'dusun' => $row['dusun'],
//                 'kelurahan' => $row['kelurahan'],
//                 'kecamatan' => $row['kecamatan'],
//                 'kode_pos' => $row['kode_pos'],
//                 'telepon' => $row['telepon'],
//                 'hp' => $row['hp'],
//                 'email' => $row['email'],
//                 'skhun' => $row['skhun'],
//                 'penerima_kps' => $row['penerima_kps'],
//                 'no_kps' => $row['no_kps'],
//                 'penerima_kip' => $row['penerima_kip'],
//                 'nomor_kip' => $row['nomor_kip'],
//                 'nama_di_kip' => $row['nama_di_kip'],
//                 'nomor_kks' => $row['nomor_kks'],
//                 'no_registrasi_akta' => $row['no_registrasi_akta'],
//                 'bank' => $row['bank'],
//                 'nomor_rekening' => $row['nomor_rekening'],
//                 'rekening_atas_nama' => $row['rekening_atas_nama'],
//                 'layak_pip' => $row['layak_pip'],
//                 'alasan_layak_pip' => $row['alasan_layak_pip'],
//                 'kebutuhan_khusus' => $row['kebutuhan_khusus'],
//                 'anak_ke' => $row['anak_ke'],
//                 'no_kk' => $row['no_kk'],
//                 'jumlah_saudara_kandung' => $row['jumlah_saudara_kandung'],
//                 'jarak_rumah_km' => is_numeric($row['jarak_rumah_km']) ? floor((float) $row['jarak_rumah_km']) : null,
//                 'lintang' => $row['lintang'],
//                 'bujur' => $row['bujur'],
//                 'agama_id' => $agama,
//                 'jenis_tinggal_id' => $jenisTinggal,
//                 'alat_transportasi_id' => $alatTransportasi,
//             ]);

//             // Simpan data orang tua (ayah dan ibu)
//             OrangTua::create([
//                 'siswa_uuid' => $siswa->uuid,
//                 'tipe' => 'Ayah',
//                 'nama' => $row['nama_ayah'],
//                 'tahun_lahir' => $row['tahun_lahir_ayah'],
//                 'pendidikan_id' => $pendidikanAyah,
//                 'pekerjaan_id' => $pekerjaanAyah,
//                 'penghasilan_id' => $penghasilanAyah,
//                 'nik' => $row['nik_ayah'],
//             ]);

//             OrangTua::create([
//                 'siswa_uuid' => $siswa->uuid,
//                 'tipe' => 'Ibu',
//                 'nama' => $row['nama_ibu'],
//                 'tahun_lahir' => $row['tahun_lahir_ibu'],
//                 'pendidikan_id' => $pendidikanIbu,
//                 'pekerjaan_id' => $pekerjaanIbu,
//                 'penghasilan_id' => $penghasilanIbu,
//                 'nik' => $row['nik_ibu'],
//             ]);

//             // Setelah siswa tersimpan, baru buat RiwayatSekolah
//             $riwayatSekolah = RiwayatSekolah::create([
//                 'siswa_uuid' => $siswa->uuid,
//                 'sekolah_asal' => $row['sekolah_asal'],
//                 'jenis_pendaftar' => $row['jenis_pendaftar'],
//                 'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_masuk'])->format('Y-m-d'),
//             ]);
//             // Update siswa, isi riwayat_sekolah_id
//             $siswa->update([
//                 'riwayat_sekolah_id' => $riwayatSekolah->id,
//             ]);
//         } catch (\Exception $e) {
//             Log::error('Error saat memproses baris: ' . $e->getMessage());
//         }
//     }

//     private function cariMapping(array $daftar, $cari)
//     {
//         foreach ($daftar as $key => $value) {
//             if (strtolower($key) === strtolower($cari)) {
//                 return $value;
//             }
//         }
//         return null;
//     }
// }
