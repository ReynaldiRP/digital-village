<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'time' => 'required',
            'is_active' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'thumbnail',
            'name' => 'nama',
            'description' => 'deskripsi',
            'price' => 'harga',
            'date' => 'tanggal',
            'time' => 'waktu',
            'is_active' => 'status aktif',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute maksimal :max karakter.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berupa file dengan tipe: :values.',
            'numeric' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal :min.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'boolean' => ':attribute harus berupa true atau false.',
        ];
    }
}
