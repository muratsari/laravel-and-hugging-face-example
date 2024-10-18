<?php

use App\Http\Controllers\Api\AiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ai/translate', [AiController::class, 'translate']);
Route::post('/ai/text-to-image', [AiController::class, 'textToImage']);
Route::post('/ai/text-to-speech', [AiController::class, 'textToSpeech']);
Route::post('/ai/image-to-text', [AiController::class, 'imageToText']);
