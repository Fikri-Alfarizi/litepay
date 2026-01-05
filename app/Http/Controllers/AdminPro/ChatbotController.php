<?php

namespace App\Http\Controllers\AdminPro;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'array',
            'context' => 'nullable|string'
        ]);

        $message = $request->input('message');
        $history = $request->input('history', []);
        $context = $request->input('context', 'general');

        $response = $this->gemini->chat($message, $history, $context);

        if (isset($response['error'])) {
            return response()->json([
                'success' => false,
                'message' => $response['error']
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $response['message']
        ]);
    }
}
