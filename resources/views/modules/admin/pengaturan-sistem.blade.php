@extends('layouts.tabler')

@section('title', $title ?? 'Pengaturan Sistem')

@section('page-title', 'Pengaturan Sistem')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Sekolah</h3>
                <div class="card-actions">
                    <button type="button" class="btn btn-primary" id="edit-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                        </svg>
                        Edit Pengaturan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="setting-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Nama Sekolah</label>
                                <input type="text" class="form-control" name="nama_sekolah"
                                    value="{{ $setting->nama_sekolah }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">NPSN</label>
                                <input type="text" class="form-control" name="npsn" value="{{ $setting->npsn }}"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat_lengkap" rows="2" disabled>{{ $setting->alamat_lengkap }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Desa / Kelurahan</label>
                                <input type="text" class="form-control" name="desa_kelurahan"
                                    value="{{ $setting->desa_kelurahan }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" name="kecamatan"
                                    value="{{ $setting->kecamatan }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kabupaten / Kota</label>
                                <input type="text" class="form-control" name="kabupaten_kota"
                                    value="{{ $setting->kabupaten_kota }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="provinsi" value="{{ $setting->provinsi }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Negara</label>
                                <input type="text" class="form-control" name="negara" value="{{ $setting->negara }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" value="{{ $setting->kode_pos }}"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="text" class="form-control" name="website" value="{{ $setting->website }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $setting->email }}"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" name="no_telp" value="{{ $setting->no_telp }}"
                            disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kepala Sekolah</label>
                                <input type="text" class="form-control" name="kepala_sekolah"
                                    value="{{ $setting->kepala_sekolah }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIP Kepala Sekolah</label>
                                <input type="text" class="form-control" name="nip_kepala_sekolah"
                                    value="{{ $setting->nip_kepala_sekolah }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tahun Berdiri</label>
                                <input type="text" class="form-control" name="tahun_berdiri"
                                    value="{{ $setting->tahun_berdiri }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jenjang Pendidikan</label>
                                <input type="text" class="form-control" name="jenjang_pendidikan"
                                    value="{{ $setting->jenjang_pendidikan }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status Sekolah</label>
                                <input type="text" class="form-control" name="status_sekolah"
                                    value="{{ $setting->status_sekolah }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kurikulum Berlaku</label>
                        <input type="text" class="form-control" name="kurikulum_berlaku"
                            value="{{ $setting->kurikulum_berlaku }}" disabled>
                    </div>

                    <div class="hr-text hr-text-left">Media Sekolah</div>

                    <div class="row">
                        <!-- Logo Sekolah -->
                        <div class="col-lg-4 mb-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <h3 class="card-title">Logo Sekolah</h3>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="min-height: 120px;">
                                            @if ($setting->logo)
                                                <div class="position-relative text-center">
                                                    <img id="logoPreview" src="{{ asset('storage/' . $setting->logo) }}"
                                                        alt="Logo Sekolah" class="img-fluid rounded"
                                                        style="max-height: 120px; width: auto;">
                                                    <button type="button"
                                                        class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1"
                                                        style="transform: translate(30%, -30%);"
                                                        onclick="removeImage('logoPreview', 'logo')"></button>
                                                </div>
                                            @else
                                                <div class="border-2 border-dashed rounded d-flex flex-column align-items-center justify-content-center text-center p-3"
                                                    style="width: 100%; height: 120px; background-color: #f8f9fa;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-photo" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M15 8h.01" />
                                                        <path
                                                            d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" />
                                                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                                        <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                                                    </svg>
                                                    <span class="text-muted mt-2">Belum ada logo</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <label class="btn btn-primary btn-sm flex-grow-1" style="cursor: pointer;">
                                                <input type="file" name="logo" class="visually-hidden"
                                                    accept="image/*" onchange="previewImage(event, 'logoPreview')">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-upload" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                    <path d="M7 9l5 -5l5 5" />
                                                    <path d="M12 4l0 12" />
                                                </svg>
                                                Unggah Logo
                                            </label>
                                            @if ($setting->logo)
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    onclick="removeImage('logoPreview', 'logo')">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="16"
                                                        height="16" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                        <div class="form-text text-muted small">
                                            Format: JPG, PNG (Maks: 2MB). Rekomendasi ukuran: 200×200px
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- QR Code Logo -->
                        <div class="col-lg-4 mb-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <h3 class="card-title">Logo QR Code</h3>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="min-height: 120px;">
                                            @if ($setting->qrcode_logo)
                                                <div class="position-relative text-center">
                                                    <img id="qrcodeLogoPreview"
                                                        src="{{ asset('storage/' . $setting->qrcode_logo) }}"
                                                        alt="QR Code Logo" class="img-fluid rounded"
                                                        style="max-height: 120px; width: auto;">
                                                    <button type="button"
                                                        class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1"
                                                        style="transform: translate(30%, -30%);"
                                                        onclick="removeImage('qrcodeLogoPreview', 'qrcode_logo')"></button>
                                                </div>
                                            @else
                                                <div class="border-2 border-dashed rounded d-flex flex-column align-items-center justify-content-center text-center p-3"
                                                    style="width: 100%; height: 120px; background-color: #f8f9fa;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-qrcode" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M3 3h4v4h-4zM17 3h4v4h-4zM3 17h4v4h-4zM17 17h4v4h-4z" />
                                                        <path d="M7 5h10M5 7v10M19 7v10M7 19h10" />
                                                    </svg>
                                                    <span class="text-muted mt-2">Belum ada logo QR</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <label class="btn btn-primary btn-sm flex-grow-1" style="cursor: pointer;">
                                                <input type="file" name="qrcode_logo" class="visually-hidden"
                                                    accept="image/*" onchange="previewImage(event, 'qrcodeLogoPreview')">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-upload" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                    <path d="M7 9l5 -5l5 5" />
                                                    <path d="M12 4l0 12" />
                                                </svg>
                                                Unggah Logo QR
                                            </label>
                                            @if ($setting->qrcode_logo)
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    onclick="removeImage('qrcodeLogoPreview', 'qrcode_logo')">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="16"
                                                        height="16" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                        <div class="form-text text-muted small">
                                            Format: PNG, JPG (Maks: 200KB). Rekomendasi ukuran: 150×150px
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Favicon -->
                        <div class="col-lg-4 mb-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <h3 class="card-title">Favicon</h3>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="min-height: 120px;">
                                            @if ($setting->favicon)
                                                <div class="position-relative text-center">
                                                    <img id="faviconPreview"
                                                        src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon"
                                                        class="img-fluid rounded" style="max-height: 64px; width: auto;">
                                                    <button type="button"
                                                        class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1"
                                                        style="transform: translate(30%, -30%);"
                                                        onclick="removeImage('faviconPreview', 'favicon')"></button>
                                                </div>
                                            @else
                                                <div class="border-2 border-dashed rounded d-flex flex-column align-items-center justify-content-center text-center p-3"
                                                    style="width: 100%; height: 120px; background-color: #f8f9fa;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-brand-apple" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M9 7c-3 0 -4 3 -4 5.5c0 3 2 7.5 4 7.5c1.088 -.046 1.679 -.5 3 -.5c1.312 0 1.5 .5 3 .5s4 -3 4 -5c-.028 -.01 -2.472 -.403 -2.5 -3c-.019 -2.17 2.416 -2.954 2.5 -3c-1.023 -1.492 -2.951 -1.963 -3.5 -2c-1.433 -.111 -2.83 1 -3.5 1c-.68 0 -1.9 -1 -3 -1z" />
                                                        <path d="M12 4a2 2 0 0 0 2 -2a2 2 0 0 0 -2 2" />
                                                    </svg>
                                                    <span class="text-muted mt-2">Belum ada favicon</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <label class="btn btn-primary btn-sm flex-grow-1" style="cursor: pointer;">
                                                <input type="file" name="favicon" class="visually-hidden"
                                                    accept="image/*" onchange="previewImage(event, 'faviconPreview')">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-upload" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                    <path d="M7 9l5 -5l5 5" />
                                                    <path d="M12 4l0 12" />
                                                </svg>
                                                Unggah Favicon
                                            </label>
                                            @if ($setting->favicon)
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    onclick="removeImage('faviconPreview', 'favicon')">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="16"
                                                        height="16" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                        <div class="form-text text-muted small">
                                            Format: ICO, PNG (Maks: 100KB). Rekomendasi ukuran: 32×32px
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kop Sekolah -->
                        <div class="col-12 mb-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <h3 class="card-title">Kop Sekolah</h3>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="min-height: 120px;">
                                            @if ($setting->kop_sekolah)
                                                <div class="position-relative text-center w-100">
                                                    <img id="kopSekolahPreview"
                                                        src="{{ asset('storage/' . $setting->kop_sekolah) }}"
                                                        alt="Kop Sekolah" class="img-fluid rounded"
                                                        style="max-height: 120px; width: auto;">
                                                    <button type="button"
                                                        class="btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1"
                                                        style="transform: translate(30%, -30%);"
                                                        onclick="removeImage('kopSekolahPreview', 'kop_sekolah')"></button>
                                                </div>
                                            @else
                                                <div class="border-2 border-dashed rounded d-flex flex-column align-items-center justify-content-center text-center p-3 w-100"
                                                    style="height: 120px; background-color: #f8f9fa;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-file-text" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                        <path
                                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                        <path d="M9 9l1 0" />
                                                        <path d="M9 13l6 0" />
                                                        <path d="M9 17l6 0" />
                                                    </svg>
                                                    <span class="text-muted mt-2">Belum ada kop sekolah</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <label class="btn btn-primary btn-sm flex-grow-1" style="cursor: pointer;">
                                                <input type="file" name="kop_sekolah" class="visually-hidden"
                                                    accept="image/*,.svg"
                                                    onchange="previewImage(event, 'kopSekolahPreview')">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-upload" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                    <path d="M7 9l5 -5l5 5" />
                                                    <path d="M12 4l0 12" />
                                                </svg>
                                                Unggah Kop Sekolah
                                            </label>
                                            @if ($setting->kop_sekolah)
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    onclick="removeImage('kopSekolahPreview', 'kop_sekolah')">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="16"
                                                        height="16" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                        <div class="form-text text-muted small">
                                            Format: SVG, PNG (Maks: 1MB). Rekomendasi ukuran: 800×200px
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-footer d-none" id="form-actions">
                        <button type="button" class="btn btn-primary" id="update-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M14 4l0 4l-6 0l0 -4" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-outline-secondary ms-auto" id="cancel-btn">
                            Batal
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('edit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const formActions = document.getElementById('form-actions');
            const formInputs = document.querySelectorAll(
                '#setting-form input, #setting-form textarea, #setting-form button[type=button]');
            const updateBtn = document.getElementById('update-btn');
            const form = document.getElementById('setting-form');

            function enableForm() {
                formInputs.forEach(input => {
                    input.disabled = false;
                });
                formActions.classList.remove('d-none');
                editBtn.classList.add('d-none');
            }

            function disableForm() {
                formInputs.forEach(input => {
                    input.disabled = true;
                });
                formActions.classList.add('d-none');
                editBtn.classList.remove('d-none');
            }

            editBtn.addEventListener('click', function() {
                enableForm();
            });

            cancelBtn.addEventListener('click', function() {
                disableForm();
            });

            disableForm(); // matikan semua input saat awal

            updateBtn.addEventListener('click', function(event) {
                event.preventDefault();

                const formData = new FormData(form);
                formData.append('_method', 'PUT'); // Method spoofing Laravel

                fetch('{{ route('pengaturan.sistem.update') }}', {
                        method: 'POST', // Tetap pakai POST
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Terjadi kesalahan jaringan.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message, // Pesan sukses dari response
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'swal2-popup-custom'
                                }
                            });
                            disableForm(); // Disable form setelah berhasil update
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: data.message || 'Terjadi kesalahan.',
                                showConfirmButton: false,
                                timer: 7000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'swal2-popup-custom'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Gagal mengirim data:', error);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Terjadi kesalahan jaringan.',
                            showConfirmButton: false,
                            timer: 7000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'swal2-popup-custom'
                            }
                        });
                    });
            });

        });
    </script>

    <script>
        function previewImage(event, elementId) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file size
            const maxSize = elementId === 'faviconPreview' ? 100 :
                (elementId === 'logoPreview' ? 2000 : 1000); // in KB
            if (file.size > maxSize * 1024) {
                alert(`Ukuran file terlalu besar. Maksimal ${maxSize}KB`);
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                let previewElement = document.getElementById(elementId);

                // If element doesn't exist (first upload), create it
                if (!previewElement) {
                    const container = event.target.closest('.d-flex.flex-column').querySelector(
                        '.d-flex.align-items-center');
                    previewElement = document.createElement('img');
                    previewElement.id = elementId;
                    previewElement.className = 'rounded border';
                    previewElement.style.maxHeight = elementId === 'faviconPreview' ? '32px' : '80px';
                    previewElement.style.width = 'auto';

                    // Remove placeholder if exists
                    const placeholder = container.querySelector('div.border.rounded');
                    if (placeholder) placeholder.remove();

                    // Add close button
                    const closeBtn = document.createElement('button');
                    closeBtn.type = 'button';
                    closeBtn.className = 'btn-close position-absolute top-0 end-0 bg-white rounded-circle p-1';
                    closeBtn.style.transform = 'translate(30%, -30%)';
                    closeBtn.onclick = () => removeImage(elementId, event.target.name);

                    const wrapper = document.createElement('div');
                    wrapper.className = 'position-relative';
                    wrapper.appendChild(previewElement);
                    wrapper.appendChild(closeBtn);

                    container.prepend(wrapper);
                }

                previewElement.src = reader.result;

                // Show delete button if hidden
                const deleteBtn = event.target.closest('.d-flex.flex-column').querySelector('.btn-outline-danger');
                if (deleteBtn) deleteBtn.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }

        function removeImage(elementId, inputName) {
            const previewElement = document.getElementById(elementId);
            const inputElement = document.querySelector(`input[name="${inputName}"]`);

            if (previewElement) {
                // Replace with placeholder
                const container = previewElement.closest('.d-flex.align-items-center');
                const placeholder = document.createElement('div');
                placeholder.className = 'border rounded d-flex align-items-center justify-content-center';
                placeholder.style.width = elementId === 'faviconPreview' ? '32px' : '100px';
                placeholder.style.height = elementId === 'faviconPreview' ? '32px' : '80px';
                placeholder.style.backgroundColor = '#f8f9fa';

                const text = document.createElement('span');
                text.className = 'text-muted text-center small';
                text.textContent = elementId === 'faviconPreview' ? 'No Icon' :
                    (elementId === 'logoPreview' ? 'No Logo' : 'No Header');
                placeholder.appendChild(text);

                container.querySelector('.position-relative')?.remove();
                container.prepend(placeholder);
            }

            if (inputElement) {
                inputElement.value = '';
            }

            // Hide delete button
            const deleteBtn = document.querySelector(`button[onclick="removeImage('${elementId}', '${inputName}')"]`);
            if (deleteBtn) deleteBtn.classList.add('d-none');
        }
    </script>
@endpush
