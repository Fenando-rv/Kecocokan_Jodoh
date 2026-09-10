<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchmakingRequest extends FormRequest
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
            'person1_name' => ['required', 'string', 'min:2', 'max:100'],
            'person1_birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'person2_name' => ['required', 'string', 'min:2', 'max:100'],
            'person2_birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'person1_name' => 'Nama Pasangan 1',
            'person1_birthdate' => 'Tanggal Lahir Pasangan 1',
            'person2_name' => 'Nama Pasangan 2',
            'person2_birthdate' => 'Tanggal Lahir Pasangan 2',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'min' => ':attribute minimal terdiri dari :min karakter.',
            'max' => ':attribute maksimal terdiri dari :max karakter.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'date_format' => 'Format :attribute harus sesuai dengan TTTT-BB-HH (contoh: 1998-05-20).',
            'before_or_equal' => ':attribute tidak boleh melebihi hari ini.',
        ];
    }
}
