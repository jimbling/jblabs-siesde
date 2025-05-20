<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document Verification')</title>
    <style>
        @import url("https://rsms.me/inter/inter.css");
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --color-primary: #4361ee;
            --color-success: #28a745;
            --color-text: #2d3748;
            --color-text-light: #718096;
            --color-bg: #f8fafc;
            --color-card: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            line-height: 1.6;
        }

        .verification-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--color-success);
            font-weight: 600;
        }

        .document-card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .document-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        }

        .document-header {
            background-color: var(--color-primary);
            color: white;
            padding: 1.5rem;
        }

        .document-body {
            padding: 2rem;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
        }

        .info-table th {
            text-align: left;
            padding: 0.5rem 1rem;
            color: var(--color-text-light);
            font-weight: 500;
            width: 35%;
        }

        .info-table td {
            padding: 0.5rem 1rem;
            font-weight: 500;
            background-color: #f8fafc;
            border-radius: 6px;
        }

        .section-title {
            position: relative;
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--color-primary);
            border-radius: 4px;
        }


        @media print {
            .no-print {
                display: none;
            }

            body {
                background-color: white !important;
            }

            .document-card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>


    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <div class="container mx-auto py-8 px-4 max-w-4xl relative">


        <!-- Verification Card -->
        <div class="document-card bg-white mb-8 relative z-10">
            <!-- Header -->
            <div class="document-header">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold">Verifikasi Dokumen Resmi</h1>
                        <p class="text-blue-100">Sistem Verifikasi Digital</p>
                    </div>
                    <div class="verification-badge px-3 py-1 rounded-md text-sm font-medium flex items-center gap-2"
                        style="background-color: {{ $log->is_valid ? '#28a745' : '#dc3545' }};
                                color: white; border-radius: 12px; border: 1px solid {{ $log->is_valid ? '#28a745' : '#dc3545' }};">
                        @if ($log->is_valid)
                            <!-- Ikon Centang -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                            <span>Dokumen Sah</span>
                        @else
                            <!-- Ikon X -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0Zm2.53 10.47a.75.75 0 1 1-1.06 1.06L8 9.06l-1.47 1.47a.75.75 0 0 1-1.06-1.06L6.94 8 5.47 6.53a.75.75 0 0 1 1.06-1.06L8 6.94l1.47-1.47a.75.75 0 0 1 1.06 1.06L9.06 8Z" />
                            </svg>
                            <span>Dokumen Tidak Sah</span>
                        @endif
                    </div>
                </div>
            </div>



            <!-- Body -->
            <div class="document-body">
                <!-- Document Info -->
                <div class="mb-8">
                    <h2 class="section-title text-xl font-semibold">Informasi Dokumen</h2>
                    <table class="info-table">
                        <tr>
                            <th>Nomor Dokumen</th>
                            <td>{{ $log->nomor_dokumen }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Dokumen</th>
                            <td class="font-semibold">{{ $log->jenis_dokumen }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Cetak</th>
                            <td>{{ \Carbon\Carbon::parse($log->waktu_cetak)->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Dicetak Oleh</th>
                            <td>{{ $log->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Verifikasi</th>
                            <td class="{{ $log->is_valid ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                <div class="flex items-center gap-2">
                                    @if ($log->is_valid)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                        <span>Dokumen Sah - Diterbitkan oleh sistem resmi</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-xbox-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10m3.6 5.2a1 1 0 0 0 -1.4 .2l-2.2 2.933l-2.2 -2.933a1 1 0 1 0 -1.6 1.2l2.55 3.4l-2.55 3.4a1 1 0 1 0 1.6 1.2l2.2 -2.933l2.2 2.933a1 1 0 0 0 1.6 -1.2l-2.55 -3.4l2.55 -3.4a1 1 0 0 0 -.2 -1.4" />
                                        </svg>
                                        <span>Dokumen Tidak Sah - Versi ini telah digantikan</span>
                                    @endif
                                </div>
                            </td>
                        </tr>


                    </table>
                </div>

                <!-- Student Info -->
                <div>
                    <h2 class="section-title text-xl font-semibold">Identitas Siswa</h2>
                    <table class="info-table">
                        <tr>
                            <th>Nama Lengkap</th>
                            <td class="font-semibold">{{ $log->student->nama }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>{{ $log->student->nisn }}</td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td>{{ $log->student->tempat_lahir }}, {{ $log->student->tanggal_lahir->format('d-m-Y') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Verification Details -->
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="text-blue-500 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-800 mb-2">Tentang Verifikasi Ini</h3>
                    <p class="text-blue-700">Dokumen ini telah diverifikasi keasliannya melalui sistem digital.
                        Informasi yang tercantum sesuai dengan data resmi yang tercatat dalam database sekolah dan
                        diterbitkan melalui domain resmi sekolah : {{ system_setting('website') }}</p>
                </div>
            </div>
        </div>

        <!-- Replace the button section with this Tabler-compatible version -->
        <div class="text-center text-muted mt-8 no-print">
            <p>Halaman verifikasi ini dihasilkan otomatis oleh sistem dan tidak memerlukan tanda tangan basah.</p>
            <p class="mt-2">Dokumen sah terverifikasi pada
                {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}</p>
            <button onclick="window.print()" class="btn btn-danger">
                <!-- Download SVG icon from http://tabler.io/icons/icon/link -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                </svg>Cetak
            </button>
            <div class="mt-6 d-flex justify-center gap-4">

            </div>
        </div>
    </div>
</body>

</html>
