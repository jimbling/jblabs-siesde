<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTahunPelajaranRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tahun_ajaran' => 'required|string|max:9|regex:/^\d{4}\/\d{4}$/',
        ];
    }

    public function messages()
    {
        return [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tahun_ajaran.max' => 'Tahun ajaran tidak boleh lebih dari 9 karakter.',
            'tahun_ajaran.regex' => 'Format tahun ajaran harus seperti 2024/2025.',
        ];
    }
}
