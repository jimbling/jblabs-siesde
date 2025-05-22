<?php

namespace App\Http\Requests\Akademik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRombelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama rombel harus diisi.',
            'tingkat.required' => 'Tingkat harus diisi.',
        ];
    }
}
