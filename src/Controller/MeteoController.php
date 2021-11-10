<?php

namespace App\Controller;

use App\Entity\Meteo;
use App\Service\ApiMeteoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeteoController extends AbstractController
{
    /**
     * @Route("/", name="meteo")
     */
    public function index(ApiMeteoService $apiMeteo, String $terrasse): Response
    {
        $terrasse = $apiMeteo->get($terrasse . '/api')->meteo;

        return $this->render('meteo/index.html.twig', [
            'controller_name' => 'Météo',
            'terrasse' => $terrasse,
        ]);
    }
}
