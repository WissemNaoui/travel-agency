<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class ChatbotService
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.dialogflow.api_key');
    }

    public function sendQuery(string $query): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://dialogflow.googleapis.com/v2/projects/your-project-id/agent/sessions/your-session-id:detectIntent', [
            'queryInput' => [
                'text' => [
                    'text' => $query,
                    'languageCode' => 'en-US',
                ],
            ],
        ]);

        $data = $response->json();
        return $data['queryResult'];
    }
}
