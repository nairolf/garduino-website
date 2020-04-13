<?php

namespace App\Controller;

use App\Repository\TemperatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartController extends AbstractController
{
    /**
     * @Route("/", name="start")
     */
    public function index(TemperatureRepository $temperatureRepository)
    {
        $temperatureRepository->findAll();
        return $this->render('start/index.html.twig', [
            'controller_name' => 'StartController',
        ]);
    }
}
