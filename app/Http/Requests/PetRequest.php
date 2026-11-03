<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\PetTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'nullable',
                Rule::in([
                    PetTypeEnum::DOG,
                    PetTypeEnum::CAT,
                ]),
            ],

            'gender' => [
                'nullable',
                Rule::in([
                    GenderEnum::MALE,
                    GenderEnum::FEMALE,
                ]),
            ],

            'age' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'customer_id' => [
                'required',
                'exists:customers,id',
            ],
        ];
    }
}