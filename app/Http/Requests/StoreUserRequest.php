<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Atur sesuai kebutuhan, misalnya hanya super_admin yang bisa membuat user
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:super_admin,manager,ppic,warehouse,produksi',
            'department_id' => 'nullable|exists:departments,id',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->role === 'produksi' && empty($this->department_id)) {
                $validator->errors()->add(
                    'department_id',
                    'Department wajib diisi untuk role Produksi'
                );
            }
        });
    }
}
