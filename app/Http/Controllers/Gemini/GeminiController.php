<?php

namespace App\Http\Controllers\Gemini;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Gemini\StoreRequest;
use App\Http\Controllers\Controller;
use App\Models\GeminiAi;
use Illuminate\Http\RedirectResponse;

class GeminiController extends Controller
{
    /**
     * Summary of index
     * @param string $id
     */
    public function index(string $id = null): Response
    {
        return Inertia::render('Gemini/index', [
            'chat'      => fn() => $id ? GeminiAi::findOrFail($id) : null,
            'messages'  => GeminiAi::latest()->where('user_id', '=', Auth::id())->get(),
        ]);
    }

    public function store(StoreRequest $request, string $id = null): RedirectResponse
    {
        $messages = [];
        if ($id) {
            $chat = GeminiAi::findOrFail($id);
            $messages = $chat->context;
        }

        $messages['infromation'] = [
            'role'      => 'user',
            'prompt'     => Str::squish($request->prompt)
        ];
        $messages['result'] = [
            'role' => 'assistant',
            'messages' => GeminiAi::Gemini(data_get($messages, 'infromation.prompt'), true)[0],
        ];

        // TODO: Origanize data and try store it in en and ar if it can
        $chat = GeminiAi::updateOrCreate(
            [
                'id'       => $id,
            ],
            [
                'context'  => $messages
            ]
        );
        return redirect()->route('gemini', $id);
    }
}
