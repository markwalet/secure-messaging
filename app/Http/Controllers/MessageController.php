<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\StoreMessageRequest;
use App\Models\Colleague;
use App\Models\Message;
use App\Notifications\MessageStoredNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use function PDF_pcos_get_stream;

class MessageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
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
        $message->message = $request->input('message');
        $message->available_until = now()->addHours(Message::KEEPALIVE);
        $message->password = bcrypt(Str::random());
        $message->save();

        Notification::route('mail', $message->colleague->email)
            ->notify(new MessageStoredNotification($message));

        return redirect()->route('messages.create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Message $message
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }
}
