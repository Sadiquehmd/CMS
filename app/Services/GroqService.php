<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GroqService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
    }

   public function generateSlug(string $title, string $content): string
{
    $prompt = "Generate only the URL slug for this article title. Output ONLY the slug in lowercase words separated by hyphens. Do NOT include any explanation, punctuation, or extra text.\n\nTitle: $title\n\nTitle: $content";

    $response = Http::withToken($this->apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
        'model' => 'llama3-8b-8192',
        'messages' => [
            ['role' => 'user', 'content' => $prompt],
        ],
        'max_tokens' => 10,
        'temperature' => 0.0,
    ]);

    $rawSlug = trim($response['choices'][0]['message']['content'] ?? '');

    return !empty($rawSlug) ? Str::slug($rawSlug) : Str::slug($title);
}

public function generateSummary(string $content): string
{
    $prompt = "Summarize this article content in exactly 2-3 sentences. Output ONLY the summary with no introduction or trailing text.It should be half of the content.\n\n$content";

    $response = Http::withToken($this->apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
        'model' => 'llama3-8b-8192',
        'messages' => [
            ['role' => 'user', 'content' => $prompt],
        ],
        'max_tokens' => 150,
        'temperature' => 0.0,
    ]);

    return trim($response['choices'][0]['message']['content'] ?? '');
}

}
