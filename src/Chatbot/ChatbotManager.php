<?php

namespace App\Services;

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;
use Psr\Log\LoggerInterface;

class ChatbotManager
{
    private $projectId;
    private $sessionId;
    private $logger;

    public function __construct(string $projectId, string $sessionId, LoggerInterface $logger)
    {
        $this->projectId = $projectId;
        $this->sessionId = $sessionId;
        $this->logger = $logger;
    }

    public function getResponse(string $message): string
    {
        $sessionPath = sprintf('projects/%s/agent/sessions/%s', $this->projectId, $this->sessionId);

        try {
            $sessionsClient = new SessionsClient();
            $textInput = new TextInput();
            $textInput->setText($message);
            $queryInput = new QueryInput();
            $queryInput->setText($textInput);
            $detectIntentRequest = new DetectIntentRequest();
            $detectIntentRequest->setSession($sessionPath);
            $detectIntentRequest->setQueryInput($queryInput);
            $response = $sessionsClient->detectIntent($detectIntentRequest);
            $fulfillmentText = $response->getQueryResult()->getFulfillmentText();
            return $fulfillmentText;

        } catch (\Exception $e) {
            Log::error('Error getting chatbot response:', ['error' => $e->getMessage()]);
            $this->logger->error('Error getting chatbot response:', ['error' => $e->getMessage()]);
        }
    }
}
