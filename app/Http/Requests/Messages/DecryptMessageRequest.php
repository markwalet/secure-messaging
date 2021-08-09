<?php

namespace App\Http\Requests\Messages;

use App\Rules\ValidPasswordForMessageRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class DecryptMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                new ValidPasswordForMessageRule($this->route('message')),
            ],
        ];
    }
}
