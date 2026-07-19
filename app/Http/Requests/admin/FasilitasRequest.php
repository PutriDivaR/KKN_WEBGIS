<?php

namespace App\Http\Requests\Admin;

use App\Models\FasilitasWisata;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FasilitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'        => ['required', 'string', 'max:255'],
            'id_jorong'   => ['nullable', 'integer', 'exists:jorong,id_jorong'],
            'kategori'    => ['nullable', Rule::in(FasilitasWisata::KATEGORI_OPTIONS)],
            'longitude'   => ['nullable', 'numeric', 'between:-180,180'],
            'latitude'    => ['nullable', 'numeric', 'between:-90,90'],
            'deskripsi'   => ['nullable', 'string'],
            // Dibatasi 1 foto per fasilitas. Kalau sudah ada foto & upload
            // baru dikirim, foto lama otomatis diganti (lihat controller).
            'foto'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'     => 'Nama fasilitas wajib diisi.',
            'kategori.in'       => 'Kategori yang dipilih tidak valid.',
            'id_jorong.exists'  => 'Jorong yang dipilih tidak valid.',
            'foto.image'        => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'        => 'Format gambar harus JPG, PNG, atau WEBP.',
            'foto.max'          => 'Ukuran gambar maksimal 5MB.',
        ];
    }
}
