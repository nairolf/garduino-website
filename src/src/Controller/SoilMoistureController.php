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
     * @param  Request $request
     * @return JsonResponse
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

    /**
     * @Route("/get/{id}", name="get_sensor_value", methods={"GET"})
     * @param  int $id
     * @return JsonResponse
     */
    public function getOne(int $id): JsonResponse
    {
        $repo = $this->soilMoistureRepository->findOneBy([
            'id' => $id
        ]);

        if ($repo) {
            $data = [
                'value' => $repo->getValue(),
                'sensor' => $repo->getSensor(),
                'timestamp' => $repo->getTimestamp()
            ];

            return new JsonResponse($data, Response::HTTP_OK);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/getAll/{sensor}", name="get_all_from_sensor", methods={"GET"})
     * @param string $sensor
     * @return JsonResponse
     */
    public function getAllBySensor(string $sensor): JsonResponse
    {
        $values = $this->soilMoistureRepository->findBy(['sensor' => $sensor]);

        if ($values) {
            $data = [];
            foreach ($values as $value) {
                $data[] = [
                    'id' => $value->getId(),
                    'value' => $value->getValue(),
                    'timestamp' => $value->getTimestamp()
                ];
            }

            return new JsonResponse($data, Response::HTTP_OK);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}