<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Message; // Assuming you have a Message entity

class MessageTypeController extends AbstractController
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/admin/message-type', name: 'admin_message_type')]
    public function index(Request $request): Response
    {
        // Replace this with your logic to retrieve the message
        $message = 'Placeholder message';

        return $this->render('admin/message_type/index.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/admin/message-type/send', name: 'admin_message_type_send')]
    public function sendMessage(Request $request): Response
    {
        // Retrieve the message from the request
        $message = $request->get('message');

        // Assuming you have a Message entity
        $messageEntity = new Message();
        $messageEntity->setContent($message);
        
        // Save the message to the database
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($messageEntity);
        $entityManager->flush();

        return new Response('Message sent successfully!');
    }
}
