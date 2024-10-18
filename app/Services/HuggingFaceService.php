<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class HuggingFaceService
{
    const API_BASE_URL = 'https://api-inference.huggingface.co';

    private static function getHttpClient(): PendingRequest
    {
        return Http::baseUrl(self::API_BASE_URL)
            ->withToken(config('services.hugging_face.access_token'));
    }

    public static function translate(string $sourceLang, string $text): string
    {
        $model = match ($sourceLang) {
            'en' => 'Helsinki-NLP/opus-mt-tc-big-en-tr',
            'tr' => 'Helsinki-NLP/opus-mt-tr-en',
        };

        $response = self::getHttpClient()->post('models/'.$model, [
            'inputs' => $text,
        ]);

        if ($response->failed()) {
            abort($response->status(), $response->json()['error']);
        }

        return $response->json()[0]['translation_text'];
    }

    public static function textToImage(string $text): string
    {
        $response = self::getHttpClient()->post('models/stabilityai/stable-diffusion-2', [
            'inputs' => $text,
        ]);

        if ($response->failed()) {
            abort($response->status(), $response->json()['error']);
        }

        return $response->body();
    }

    public static function textToSpeech(string $text): string
    {
        $response = self::getHttpClient()->post('models/facebook/mms-tts-eng', [
            'inputs' => $text,
        ]);

        if ($response->failed()) {
            abort($response->status(), $response->json()['error']);
        }

        return $response->body();
    }

    public static function imageToText($image)
    {
        $response = self::getHttpClient()->post('models/Salesforce/blip-image-captioning-large', [
            'inputs' => base64_encode($image->get()),
        ]);

        if ($response->failed()) {
            abort($response->status(), $response->json()['error']);
        }

        return $response->json()[0]['generated_text'];
    }
}
