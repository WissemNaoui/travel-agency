<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Destination;
use App\Repository\DestinationRepository;

class AdminController extends AbstractController
{
    private $destinationRepository;

    public function __construct(DestinationRepository $destinationRepository)
    {
        $this->destinationRepository = $destinationRepository;
    }

    public function destinationsAction(Request $request)
    {
        $destinations = $this->destinationRepository->findAll();

        return new Response($this->render('admin/destinations.html.twig', ['destinations' => $destinations]));
    }

    public function destinationFormAction(Request $request, $id)
    {
        $destination = $this->destinationRepository->find($id);
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->destinationRepository->save($destination);
            return new Response('Destination updated successfully!');
        }

        return new Response($this->render('admin/destination_form.html.twig', ['form' => $form->createView()]));
    }
}
/**AdminController:

destinations: Displays a list of destinations and allows adding, editing, and deleting
destination_form: Displays a form to add or edit a destination

*/
