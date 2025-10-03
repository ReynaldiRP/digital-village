<?php

namespace App\Http\Requests\DevelopmentApplicants;

use Illuminate\Foundation\Http\FormRequest;

class DevelopmentApplicantStoreRequest extends FormRequest
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
            'development_id' => 'required|exists:developments,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,approved,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'development_id.required' => 'Development ID wajib diisi.',
            'development_id.exists'   => 'Development yang dipilih tidak ditemukan.',
            'user_id.required'        => 'User ID wajib diisi.',
            'user_id.exists'          => 'User yang dipilih tidak ditemukan.',
            'status.required'         => 'Status wajib diisi.',
            'status.in'               => 'Status harus salah satu dari berikut: pending, approved, rejected.',
        ];
    }
}
