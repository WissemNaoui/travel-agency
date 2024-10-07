<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Destination;
use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TravelController extends AbstractController
{
    private $destinationRepository;

    public function __construct(DestinationRepository $destinationRepository)
    {
        $this->destinationRepository = $destinationRepository;
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request): Response
    {
        $query = $request->query->get('query');
        $destinations = $this->destinationRepository->findByName($query);

        return $this->render('travel/search.html.twig', ['destinations' => $destinations]);
    }

    /**
     * @Route("/recommendations", name="recommendations")
     */
    public function recommendationsAction(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $preferences = $user->getPreferences();
        $destinations = $this->destinationRepository->findRecommendedDestinations($preferences);

        return $this->render('travel/recommendations.html.twig', ['destinations' => $destinations]);
    }

    /**
     * @Route("/destination/{id}", name="destination")
     */
    public function destinationAction(Request $request, Destination $destination): Response
    {
        return $this->render('travel/destination_detail.html.twig', ['destination' => $destination]);
    }
}
