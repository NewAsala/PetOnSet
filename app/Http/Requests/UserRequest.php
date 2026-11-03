<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($this->user?->id),
            ],
            'address' => ['string','nullable', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'role' => ['required','exists:roles,name'],
            'password' => [ $this->user ? 'nullable' : 'required','string','min:8','confirmed'],
        ];
    }
}
