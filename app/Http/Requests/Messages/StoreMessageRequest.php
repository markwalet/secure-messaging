<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'colleague' => [
                'required',
                Rule::exists('colleagues', 'id'),
            ],
            'message'   => [
                'required',
                'string',
            ],
            'password'  => [
                'required',
                'string',
                Password::min(12),
            ],
        ];
    }
}
