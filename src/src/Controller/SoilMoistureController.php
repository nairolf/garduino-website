<?php

namespace App\Controller;

use App\Repository\SoilMoistureRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/soilmoisture")
 */
class SoilMoistureController
{
    private $soilMoistureRepository;

    public function __construct(SoilMoistureRepository $soilMoistureRepository)
    {
        $this->soilMoistureRepository = $soilMoistureRepository;
    }

    /**
     * @Route("/add", name="add_soilMoisture", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['value']) || !isset($data['sensor'])) {
            return new JsonResponse(
                ['status' => 'Mandatory parameters missing']
                , Response::HTTP_BAD_REQUEST
            );
        }

        $value = $data['value'];
        $sensor = $data['sensor'];

        $this->soilMoistureRepository->saveSoilMoisture($value, $sensor);
        
        return new JsonResponse(['status' => 'SoilMoisture created!'], Response::HTTP_CREATED);
    }
}