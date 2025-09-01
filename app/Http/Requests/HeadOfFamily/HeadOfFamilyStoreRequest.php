<?php

namespace App\Http\Requests\HeadOfFamily;

use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'profile_picture' => 'nullable|image|max:2048',
            'identify_number' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'occupation' => 'required|string|max:255',
            'marital_status' => 'required|in:single,married',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'ID Pengguna',
            'profile_picture' => 'Foto Profil',
            'identify_number' => 'Nomor Identitas',
            'gender' => 'Jenis Kelamin',
            'birth_date' => 'Tanggal Lahir',
            'phone_number' => 'Nomor Telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status Pernikahan',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa string.',
            'max'      => ':attribute maksimal :max karakter.',
            'date'     => ':attribute harus berupa tanggal yang valid.',
            'image'    => ':attribute harus berupa gambar.',

            'user_id.exists'       => 'ID Pengguna tidak ditemukan.',
            'profile_picture.max'  => 'Foto Profil maksimal berukuran 2MB.',
            'gender.in'            => ':attribute tidak valid.',
            'marital_status.in'    => ':attribute tidak valid.',
        ];
    }
}
