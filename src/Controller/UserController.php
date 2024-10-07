<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user);
            return new Response('User registered successfully!');
        }

        return new Response($this->render('user/register.html.twig', ['form' => $form->createView()]));
    }

    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user);
            return new Response('User profile updated successfully!');
        }

        return new Response($this->render('user/profile.html.twig', ['form' => $form->createView()]));
    }
}
/**UserController:

register: Handles user registration
profile: Displays user profile information and allows editing of preferences

*/