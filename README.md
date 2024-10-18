# Laravel and Hugging Face Example

This repository provides a blueprint for building AI-powered APIs using Laravel and Hugging Face. It was originally created for demonstration at GDG DevFest in Çanakkale on 20th October 2024. The project integrates Hugging Face models into a Laravel application, enabling developers to easily create intelligent applications using machine learning models for tasks like natural language processing, computer vision, and more.

## Features

- AI-powered API endpoints using Hugging Face models
- Integration with Laravel for scalable and maintainable API development
- Example API routes for interacting with different machine learning models
- Swagger UI for easy testing and exploring API endpoints

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- A valid Hugging Face access token

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/muratsari/laravel-and-hugging-face-example.git
   cd laravel-and-hugging-face-example
   ```

2. **Install dependencies:**

   Run Composer to install Laravel and other necessary dependencies:

   ```bash
   composer install
   ```
3. **Set up your environment variables:**

   Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

4. **Generate the application key:**

   ```bash
   php artisan key:generate
   ```

5. **Set up Hugging Face access token:**

In your `.env` file, update the `HUGGING_FACE_ACCESS_TOKEN` variable with your Hugging Face API access token.

   ```bash
   HUGGING_FACE_ACCESS_TOKEN=your-access-token
   ```


6. **Serve the application:**

Start the Laravel development server:

   ```bash
   php artisan serve
   ```

The application will be running at `http://localhost:8000`
