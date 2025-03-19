@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', 'Lisensi')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-lg-8">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="markdown">
                            <p>
                                Ini adalah perjanjian hukum antara Anda, selaku Pembeli, dan JB Labs. Dengan membeli atau
                                menggunakan aplikasi
                                yang dikembangkan oleh JB Labs, Anda menyetujui syarat dan ketentuan lisensi ini.
                            </p>

                            <h3>Hak Penggunaan</h3>
                            <ol>
                                <li>Anda diberikan hak non-eksklusif dan tidak dapat dialihkan untuk menggunakan aplikasi
                                    ini dalam proyek pribadi atau komersial.</li>
                                <li>Aplikasi hanya dapat digunakan untuk <strong>satu domain</strong> sesuai dengan
                                    perjanjian pembelian. Jika ingin menggunakan di domain lain, Anda harus membeli lisensi
                                    tambahan.</li>
                                <li>Anda diizinkan untuk <strong>memodifikasi</strong> kode sesuai kebutuhan internal tanpa
                                    membagikan atau mendistribusikan ulang versi modifikasi tersebut.</li>
                                <li>Anda <strong>tidak diharuskan</strong> memberikan atribusi atau mencantumkan kredit
                                    kepada JB Labs dalam proyek yang menggunakan aplikasi ini.</li>
                            </ol>

                            <h3>Batasan Penggunaan</h3>
                            <ol>
                                <li><strong>Dilarang</strong> mendistribusikan, menjual kembali, menyewakan, melisensikan
                                    ulang, atau menawarkan aplikasi kepada pihak ketiga dalam bentuk apa pun.</li>
                                <li><strong>Dilarang</strong> mengunggah atau menyebarkan kode sumber aplikasi ini ke
                                    repositori publik, baik yang bersifat gratis maupun berbayar.</li>
                                <li><strong>Dilarang</strong> mengklaim aplikasi ini sebagai hasil pengembangan pihak lain.
                                </li>
                                <li>Untuk aplikasi yang menggunakan <strong>Tabler</strong>, Anda tetap harus mematuhi
                                    lisensi <strong>MIT</strong> dari Tabler dalam penggunaannya.</li>
                                <li>JB Labs tidak bertanggung jawab atas segala bentuk kerusakan atau kehilangan data akibat
                                    penggunaan aplikasi ini.</li>
                            </ol>

                            <h3>Kebijakan Dukungan dan Pembaruan</h3>
                            <ol>
                                <li>JB Labs menyediakan dukungan teknis <strong>terbatas</strong> untuk setiap pembelian
                                    aplikasi.</li>
                                <li>Pembaruan aplikasi hanya diberikan kepada pelanggan yang masih dalam masa dukungan,
                                    sesuai perjanjian yang berlaku.</li>
                                <li>Kustomisasi tambahan di luar cakupan standar dikenakan biaya tambahan sesuai dengan
                                    kesepakatan.</li>
                            </ol>

                            <h3>Ketentuan Lainnya</h3>
                            <p>
                                Perjanjian ini dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu. Dengan
                                menggunakan aplikasi ini,
                                Anda dianggap telah membaca dan menyetujui ketentuan yang berlaku.
                            </p>
                            <p>
                                Jika Anda memiliki pertanyaan atau ingin membeli lisensi tambahan, silakan hubungi JB Labs.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/scale -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-md">
                                    <path d="M7 20l10 0" />
                                    <path d="M6 6l6 -1l6 1" />
                                    <path d="M12 3l0 17" />
                                    <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0" />
                                    <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0" />
                                </svg>
                            </div>
                            <div>
                                <small class="text-secondary">Siesde dilisensikan di bawah </small>
                                <h3 class="lh-1">MIT License</h3>
                            </div>
                        </div>
                        <div class="text-secondary mb-3">
                            MIT License adalah lisensi yang bersifat sederhana dan permisif, dengan hanya beberapa ketentuan
                            yang perlu dipenuhi, yaitu menjaga pemberitahuan hak cipta dan lisensi. Karya yang dilisensikan,
                            modifikasi, serta karya yang lebih besar dapat didistribusikan dengan syarat berbeda dan tanpa
                            kode sumber.
                        </div>
                        <h4>Hak (Permissions)</h4>
                        <ul class="list-unstyled space-y-1">
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-green icon-2">
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                Penggunaan komersial
                            </li>
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-green icon-2">
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                Modifikasi
                            </li>
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-green icon-2">
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                Distribusi
                            </li>
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-green icon-2">
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                Penggunaan pribadi
                            </li>
                        </ul>
                        <h4>Batasan (Limitations)</h4>
                        <ul class="list-unstyled space-y-1">
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/x -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-red icon-2">
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                                Tidak ada jaminan (Warranty)
                            </li>
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/x -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-red icon-2">
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                                Warranty
                            </li>
                        </ul>
                        <h4>Ketentuan (Conditions)</h4>
                        <ul class="list-unstyled space-y-1">
                            <li>
                                <!-- Download SVG icon from http://tabler.io/icons/icon/info-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon text-blue icon-2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 9h.01" />
                                    <path d="M11 12h1v4h1" />
                                </svg>
                                Harus menyertakan pemberitahuan lisensi dan hak cipta saat menggunakan atau mendistribusikan
                                ulang
                            </li>
                        </ul>




                    </div>
                    <div class="card-footer">
                        <!-- Tabler Icon -->
                        <a href="https://tabler.io" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Kunjungi Tabler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-brand-tabler">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M17 2a5 5 0 0 1 5 5v10a5 5 0 0 1 -5 5h-10a5 5 0 0 1 -5 -5v-10a5 5 0 0 1 5 -5zm-1 12h-3a1 1 0 0 0 0 2h3a1 1 0 0 0 0 -2m-7.293 -5.707a1 1 0 0 0 -1.414 0l-.083 .094a1 1 0 0 0 .083 1.32l2.292 2.293l-2.292 2.293a1 1 0 0 0 1.414 1.414l3 -3a1 1 0 0 0 0 -1.414z" />
                            </svg> Tabler
                        </a>



                        <!-- Laravel Icon -->
                        <a href="https://laravel.com" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Kunjungi Laravel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#FF2D20" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-laravel">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 17l8 5l7 -4v-8l-4 -2.5l4 -2.5l4 2.5v4l-11 6.5l-4 -2.5v-7.5l-4 -2.5z" />
                                <path d="M11 18v4" />
                                <path d="M7 15.5l7 -4" />
                                <path d="M14 7.5v4" />
                                <path d="M14 11.5l4 2.5" />
                                <path d="M11 13v-7.5l-4 -2.5l-4 2.5" />
                                <path d="M7 8l4 -2.5" />
                                <path d="M18 10l4 -2.5" />
                            </svg> Laravel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- END PAGE BODY -->


@endsection
