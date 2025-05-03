<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Semester;

class StoreSemesterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Aturan validasi dasar.
     */
    public function rules()
    {
        return [
            'semester' => 'required|string|max:20',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajaran,id',
            'is_aktif' => 'nullable|boolean',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ];
    }


    /**
     * Pesan error kustom.
     */
    public function messages()
    {
        return [
            'semester.required' => 'Semester wajib diisi.',
            'semester.max' => 'Semester tidak boleh lebih dari 20 karakter.',
            'tahun_pelajaran_id.required' => 'Tahun pelajaran wajib dipilih.',
            'tahun_pelajaran_id.exists' => 'Tahun pelajaran yang dipilih tidak valid.',
            'is_aktif.boolean' => 'Format status aktif tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date' => 'Tanggal selesai harus berupa tanggal yang valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
        ];
    }

    /**
     * Validasi tambahan setelah aturan dasar.
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $semester = strtolower(trim($this->semester)); // normalisasi input
            $tahunPelajaranId = $this->tahun_pelajaran_id;

            // Cek apakah semester yang sama sudah ada untuk tahun pelajaran tersebut
            $exists = Semester::where('semester', $semester)
                ->where('tahun_pelajaran_id', $tahunPelajaranId)
                ->exists();

            if ($exists) {
                $validator->errors()->add('semester', 'Semester ini sudah ada untuk tahun pelajaran yang dipilih.');
            }

            // Cek jika sudah ada 2 semester pada tahun pelajaran ini
            $count = Semester::where('tahun_pelajaran_id', $tahunPelajaranId)->count();

            if ($count >= 2) {
                $validator->errors()->add('tahun_pelajaran_id', 'Tahun pelajaran ini sudah memiliki dua semester.');
            }
        });
    }
}
