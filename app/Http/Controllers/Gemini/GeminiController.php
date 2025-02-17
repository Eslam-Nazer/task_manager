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
        $prompt = Str::squish($request->prompt);
        if ($id) {
            $chat = GeminiAi::findOrFail($id);
            $messages = $chat->context;
        } else {
            $messages = [];
        }

        $messages[] = [
            'role'      => 'user',
            'prompt'     => $prompt
        ];

        $messages[] = [
            'role' => 'assistant',
            'messages' => str_replace('*', '', GeminiAi::Gemini($prompt, true, true)),
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

    /**
     * Summary of destroy
     * @param \App\Models\GeminiAi $chat
     * @return RedirectResponse
     */
    public function destroy(GeminiAi $chat): RedirectResponse
    {
        $chat->delete();
        return to_route('gemini');
    }
}
