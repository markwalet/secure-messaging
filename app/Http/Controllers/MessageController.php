<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\StoreMessageRequest;
use App\Models\Colleague;
use App\Models\Message;
use App\Notifications\MessageStoredNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $colleagues = Colleague::all()->map(function (Colleague $colleague) {
            return [
                'id'    => $colleague->id,
                'label' => $colleague->name . "$colleague->name <$colleague->email>",
            ];
        });

        return Inertia::render('Messages/CreateMessage', compact('colleagues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessageRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $message = new Message();

        $message->colleague()->associate($request->input('colleague'));
        $message->user()->associate($request->user());
        $message->message = $request->input('message');
        $message->password = bcrypt($request->input('password'));
        $message->available_until = now()->addHours(Message::KEEPALIVE);
        $message->save();

        Notification::route('mail', $message->colleague->email)
            ->notify(new MessageStoredNotification($message));

        return redirect()->route('messages.create');
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     *
     * @return Response
     */
    public function show(Message $message): Response
    {
        $signedRoute = URL::signedRoute('decrypt-message', compact('message'));

        return Inertia::render('Messages/ShowMessage', compact('signedRoute'));
    }
}
