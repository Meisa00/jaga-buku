<?php

namespace App\Http\Controllers;

use App\Services\JagaBukuChatbot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __invoke(Request $request, JagaBukuChatbot $chatbot): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        return response()->json([
            'reply' => $chatbot->reply($validated['message']),
        ]);
    }
}
