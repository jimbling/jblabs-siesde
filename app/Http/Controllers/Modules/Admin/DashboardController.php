<?php

namespace App\Http\Controllers\Modules\Admin;

use Carbon\Carbon;
use App\Models\Rombel;
use App\Models\Student;
use App\Models\Semester;
use App\Models\StudentRombel;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = $this->getDashboardStats();
        $recentStudents = $this->getRecentStudents();
        $birthdays = $this->getUpcomingBirthdays();
        $studentsIncompleteDocs = $this->getStudentsWithMissingSpecificDocuments();
        $rombelStats = $this->getJumlahPesertaPerRombel(); // <- Tambahan ini

        return view('modules.admin.adminpanel', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentStudents' => $recentStudents,
            'birthdays' => $birthdays,
            'top_kelurahan' => $this->getTopKelurahan(),
            'studentsIncompleteDocs' => $studentsIncompleteDocs,
            'rombelStats' => $rombelStats, // <- Kirim ke view
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Dashboard']
            ])
        ]);
    }


    protected function getDashboardStats()
    {
        return [
            'total' => Student::count(),
            'new_this_month' => Student::whereMonth('created_at', now()->month)->count(),
            'special_needs' => Student::whereNotNull('kebutuhan_khusus')->count(),
            'scholarship' => Student::where('penerima_kps', 1)->orWhere('penerima_kip', 1)->count(),
            'gender_distribution' => Student::select('jk', DB::raw('count(*) as total'))
                ->groupBy('jk')
                ->get()
                ->pluck('total', 'jk'),
            'incomplete_docs' => Student::has('dokumen', '<', 3)->count(),
            'top_kelurahan' => $this->getTopKelurahan(),
            'studentsIncompleteDocs' => $this->getStudentsWithMissingSpecificDocuments()
        ];
    }


    protected function getRecentStudents()
    {
        return Student::with(['currentRombel.rombel', 'statusTerakhir'])
            ->whereHas('statusTerakhir', function ($q) {
                $q->where('status', 'aktif');
            })
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($student) {
                return [
                    'uuid' => $student->uuid,
                    'nama' => $student->nama,
                    'nipd' => $student->nipd,
                    'kelas' => $student->currentRombel && $student->currentRombel->rombel
                        ? $student->currentRombel->rombel->nama
                        : 'Belum ada kelas',
                    'status' => optional($student->statusTerakhir)->status,
                    'foto' => optional($student->fotoTerbaru)->path ?? asset('assets/img/avatar-default.png')
                ];
            });
    }


    protected function getUpcomingBirthdays()
    {
        return Student::whereHas('statusTerakhir', function ($q) {
            $q->where('status', 'aktif');
        })
            ->whereMonth('tanggal_lahir', now()->month)
            ->whereDay('tanggal_lahir', '>=', now()->day)
            ->orderByRaw('DAY(tanggal_lahir)')
            ->take(5)
            ->get()
            ->map(function ($student) {
                return [
                    'nama' => $student->nama_panggilan ?? $student->nama,
                    'tanggal' => $student->tanggal_lahir->format('d M'),
                    'umur' => $student->tanggal_lahir->age,
                    'foto' => optional($student->fotoTerbaru)->path ?? asset('assets/img/avatar-default.png')
                ];
            });
    }


    protected function getTopKelurahan()
    {
        return Student::whereHas('statusTerakhir', function ($q) {
            $q->where('status', 'aktif');
        })
            ->select('kelurahan', DB::raw('count(*) as total'))
            ->whereNotNull('kelurahan')
            ->groupBy('kelurahan')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'kelurahan' => $item->kelurahan,
                    'total' => $item->total
                ];
            });
    }


    protected function getStudentsWithMissingSpecificDocuments()
    {
        $requiredDocs = ['akta_kelahiran', 'kk'];

        return Student::whereHas('statusTerakhir', function ($q) {
            $q->where('status', 'aktif');
        })
            ->where(function ($query) use ($requiredDocs) {
                foreach ($requiredDocs as $doc) {
                    $query->orWhereDoesntHave('dokumen', function ($q) use ($doc) {
                        $q->where('tipe_dokumen', $doc);
                    });
                }

                // Tambahan: siswa yang tidak punya satu pun entri foto
                $query->orWhereDoesntHave('fotoSiswa');
            })
            ->with([
                'dokumen',
                'fotoTerbaru',
                'fotoSiswa',
                'currentRombel.rombel',
                'statusTerakhir', // kalau mau ditampilkan
            ])
            ->orderBy('nama')
            ->get()
            ->map(function ($student) use ($requiredDocs) {
                $existingTypes = $student->dokumen->pluck('tipe_dokumen')->toArray();
                $missing = array_diff($requiredDocs, $existingTypes);

                if ($student->fotoSiswa->isEmpty()) {
                    $missing[] = 'foto';
                }

                return [
                    'uuid' => $student->uuid,
                    'nama' => $student->nama,
                    'kelas' => optional($student->currentRombel?->rombel)->nama ?? 'Belum ada kelas',
                    'foto' => optional($student->fotoTerbaru)->path ?? asset('assets/img/avatar-default.png'),
                    'missing_docs' => $missing
                ];
            });
    }

    protected function getJumlahPesertaPerRombel()
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        if (!$semesterAktif) {
            return collect(); // Tidak ada semester aktif
        }

        // Ambil semua rombel
        $semuaRombel = Rombel::orderBy('nama')->get();

        // Ambil data student_rombel untuk semester aktif
        $dataRombelAktif = StudentRombel::with(['siswa.statusTerakhir'])
            ->where('semester_id', $semesterAktif->id)
            ->get()
            ->groupBy('rombel_id');

        // Gabungkan semua rombel dengan hasil count
        $hasil = $semuaRombel->map(function ($rombel) use ($dataRombelAktif) {
            $group = $dataRombelAktif->get($rombel->id, collect());

            $l = 0;
            $p = 0;

            foreach ($group as $sr) {
                $student = $sr->siswa;
                if (
                    $student &&
                    optional($student->statusTerakhir)->status === 'aktif'
                ) {
                    if ($student->jk === 'L') {
                        $l++;
                    } elseif ($student->jk === 'P') {
                        $p++;
                    }
                }
            }

            return [
                'rombel' => $rombel->nama,
                'L' => $l,
                'P' => $p,
                'jumlah' => $l + $p,
            ];
        });

        return $hasil;
    }
}
