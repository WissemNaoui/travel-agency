<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Service\ChatbotService;

class ChatbotController extends AbstractController
{
    private $messageRepository;
    private $chatbotService;

    public function __construct(MessageRepository $messageRepository, ChatbotService $chatbotService)
    {
        $this->messageRepository = $messageRepository;
        $this->chatbotService = $chatbotService;
    }

    public function chatAction(Request $request)
    {
        $userInput = $request->query->get('input');
        $response = $this->chatbotService->getResponse($userInput);

        return new Response($response);
    }
}
/**ChatbotController:

chat: Handles chatbot interactions and responds with relevant information

*/