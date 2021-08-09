<?php

namespace App\Http\Requests\Messages;

use App\Models\Message;
use App\Rules\ValidPasswordForMessageRule;
use Illuminate\Foundation\Http\FormRequest;

class DecryptMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /** @var Message $message */
        $message = $this->route('message');

        return [
            'password' => [
                'required',
                new ValidPasswordForMessageRule($message),
            ],
        ];
    }
}
