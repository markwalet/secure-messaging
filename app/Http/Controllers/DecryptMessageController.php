<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\DecryptMessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class DecryptMessageController extends Controller
{
    /**
     * Try to decrypt the given message
     *
     * @param DecryptMessageRequest $request
     * @param Message               $message
     *
     * @return Response
     * @throws ValidationException
     */
    public function __invoke(DecryptMessageRequest $request, Message $message): Response
    {
        if (Hash::check($request->input('password'), $message->password) === false) {
            throw ValidationException::withMessages(['password' => 'The password is invalid.']);
        }

        $secureMessage = $message->message;
        $message->delete();

        return Inertia::render('Messages/ShowDecryptedMessage', compact('secureMessage'));
    }
}
