<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatbot;

    public function __construct(ChatService $chatbot) {
        $this -> chatbot = $chatbot;
    }

    public function send(Request $request) {
        $request -> validate([  
            'message' => 'required|string|max:150'
        ]);

        $response = $this -> chatbot->getResponse($request->message);

        return response()->json([
            'reply' => $response
        ]);
    }
}
