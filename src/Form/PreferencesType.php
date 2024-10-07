<?php

namespace App\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreferencesTypeController extends AbstractController
{
    #[Route('/settings/preferences-type', name: 'app_settings_preferences_type')]
    public function index(): Response
    {
        return $this->render('settings/preferences_type.html.twig');
    }
}
