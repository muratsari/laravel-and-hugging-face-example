<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ai\ImageRequest;
use App\Http\Requests\Api\Ai\TextToSpeechRequest;
use App\Http\Requests\Api\Ai\TranslateRequest;
use App\Services\HuggingFaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AiController extends Controller
{
    #[OA\Post(
        path: '/api/ai/translate',
        summary: 'Translation between Turkish and English, both ways',
        tags: ['AI'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: ''),
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'source_lang', type: 'string', enum: ['en', 'tr'], example: 'en'),
                new OA\Property(property: 'text', type: 'string', example: 'Çanakkale is where Europe and Asia meet in a graceful embrace, their histories intertwined across millennia. As you stand at the edge of the Dardanelles, watching the turquoise waters flow, you can feel the heartbeat of ancient civilizations. This is the land of Troy, where legendary heroes once walked, and the modern world still marvels at its beauty. Çanakkale isn’t just a city; it’s a timeless passageway between cultures, where every corner tells a story of resilience, exploration, and wonder.'),
            ]
        )
    )]
    public function translate(TranslateRequest $request): JsonResponse
    {
        $translatedText = HuggingFaceService::translate(
            $request->input('source_lang'),
            $request->input('text')
        );

        return response()->json(['text' => $translatedText]);

    }

    #[OA\Post(
        path: '/api/ai/text-to-image',
        summary: 'Generates an image from the provided text input.',
        tags: ['AI'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: ''),
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'text', type: 'string', example: 'A software event taking place in a large convention center, crowded with hundreds of attendees. On stage, a presentation about Laravel and artificial intelligence is being delivered, with engaging visuals projected on a screen. The audience is attentively watching, some taking notes and others discussing among themselves. The atmosphere is vibrant and energetic, reflecting a passion for technology and innovation.'),
            ]
        )
    )]
    public function textToImage(Request $request): StreamedResponse
    {
        $image = HuggingFaceService::textToImage($request->input('text'));

        return response()->streamDownload(function () use ($image) {
            echo $image;
        }, 'text-to-image.jpg', ['Content-Type' => 'image/jpeg']);
    }

    #[OA\Post(
        path: '/api/ai/text-to-speech',
        summary: 'Converts input text into speech and returns the audio in .flac format',
        tags: ['AI'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: ''),
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'text', type: 'string', example: 'In Çanakkale, history isn’t just something you read about—it’s something you walk through, breathe in, and feel in your bones. From the ancient ruins of Troy to the Ottoman-era fortresses guarding the Dardanelles, the past comes alive in every step you take. Yet Çanakkale isn’t stuck in history; it’s a vibrant, modern city with a unique cultural blend, offering travelers the best of both worlds. It’s a place where the echoes of the past meet the energy of the present, making every visit unforgettable.'),
            ]
        )
    )]
    public function textToSpeech(TextToSpeechRequest $request): StreamedResponse
    {
        $audio = HuggingFaceService::textToSpeech($request->input('text'));

        return response()->streamDownload(function () use ($audio) {
            echo $audio;
        }, 'text-to-speech.flac', ['Content-Type' => 'audio/flac']);
    }

    #[OA\Post(
        path: '/api/ai/image-to-text',
        summary: 'Extracts meaningful captions from the provided image.',
        tags: ['AI'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: ''),
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                type: 'object',
                properties: [
                    new OA\Property(property: 'image', type: 'string', format: 'binary'),
                ]
            )
        )
    )]
    public function imageToText(ImageRequest $request): JsonResponse
    {
        $caption = HuggingFaceService::imageToText($request->file('image'));

        return response()->json(['text' => $caption]);
    }
}
