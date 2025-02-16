<?php

namespace App\Http\Controllers\Gemini;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\Gemini\StoreRequest;
use App\Http\Controllers\Controller;

class GeminiController extends Controller
{
    /**
     * Summary of index
     * @param string $id
     */
    public function index(string $id = null): Response
    {
        return Inertia::render('Gemini/index');
    }

    public function store(StoreRequest $request)
    {
        $message = [
            'role'      => 'user',
            'promt'     => Str::squish($request->promt)
        ];
        dd($message);

        // TODO: Origanize data and try store it in en and ar if it can
    }
}
