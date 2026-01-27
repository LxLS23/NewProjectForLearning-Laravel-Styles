<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function(){
    return view('Vistas.index');
});

Route::post('/chatbot', [ChatController::class, 'send']);

Route::get('/chatbot', function() {
    return view('Vistas.chatbot');
});

