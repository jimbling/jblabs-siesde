<?php

namespace App\Http\Requests\Akademik;

use Illuminate\Foundation\Http\FormRequest;

class StoreRombelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|integer|unique:rombel,tingkat',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama rombel harus diisi.',
            'nama.string' => 'Nama rombel harus berupa teks.',
            'nama.max' => 'Nama rombel maksimal 255 karakter.',
            'tingkat.required' => 'Tingkat harus diisi.',
            'tingkat.integer' => 'Tingkat harus berupa angka.',
            'tingkat.unique' => 'Tingkat sudah terdaftar, pilih tingkat lain.',
        ];
    }
}
