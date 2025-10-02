<?php

namespace App\Http\Requests\SocialAssistanceRecipients;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceRecipientUpdateRequest extends FormRequest
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
            'social_assistance_id' => 'sometimes|exists:social_assistances,id',
            'head_of_family_id' => 'sometimes|exists:head_of_families,id',
            'amount' => 'sometimes|numeric|min:0',
            'reason' => 'sometimes|string|max:1000',
            'bank' => 'sometimes|string|max:255',
            'account_number' => 'sometimes|string|max:50',
            'proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|string|in:pending,approved,rejected',
        ];
    }

    public function attributes()
    {
        return [
            'social_assistance_id' => 'Bantuan Sosial',
            'head_of_family_id' => 'Kepala Keluarga',
            'amount' => 'Jumlah',
            'reason' => 'Alasan',
            'bank' => 'Bank',
            'account_number' => 'Nomor Rekening',
            'proof' => 'Bukti',
            'status' => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute tidak ditemukan.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => ':attribute tidak valid.',
            'numeric' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal :min.',
            'image' => ':attribute harus berupa gambar.',
        ];
    }
}
