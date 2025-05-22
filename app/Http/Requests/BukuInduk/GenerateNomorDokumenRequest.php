<?php

namespace App\Http\Requests\BukuInduk;

use Illuminate\Foundation\Http\FormRequest;

class GenerateNomorDokumenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ];
    }

    public function messages()
    {
        return [
            'student_ids.required' => 'Silakan pilih minimal satu siswa untuk generate nomor dokumen.',
            'student_ids.array' => 'Data siswa yang dipilih tidak valid. Silakan pilih siswa dengan benar.',
            'student_ids.*.exists' => 'Beberapa siswa yang Anda pilih tidak ditemukan dalam sistem.',
        ];
    }
}
