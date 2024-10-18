<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(
        version: '1.0.0',
        title: 'AI-Powered API',
        description: '<p>The Swagger UI provides an interactive interface to explore and test the AI-powered API endpoints created with Laravel and Hugging Face.</p><p>This repository was originally created for demonstration purposes at GDG DevFest in Çanakkale on 20th October 2024. It showcases how to integrate Hugging Face models into a Laravel application, allowing users to interact with machine learning capabilities such as natural language processing and image recognition via simple API calls.</p><p>The Swagger UI enables real-time testing and documentation of each endpoint, making it an invaluable tool for developers exploring AI integration.</p>',
    ),
    OA\Tag(
        name: 'AI',
        description: 'Artificial Intelligence Powered Endpoints'
    ),
]
abstract class Controller
{
    //
}
