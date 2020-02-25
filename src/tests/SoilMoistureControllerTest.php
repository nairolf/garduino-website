<?php

namespace App\Tests;

use App\DataFixtures\SoilMoistureFixtures;
use App\Entity\SoilMoisture;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class SoilMoistureControllerTest extends AbstractControllerTest
{
    // public function testListSoilMoistures()
    // {
    //     $this->loadFixture(new SoilMoistureFixtures());
    //     $this->client->request('GET', '/soilmoisture/');

    //     $response = $this->client->getResponse();
    //     $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    //     $this->assertEquals($response->getContent(), json_encode([
    //         ['id' => 1, 'name' => 'BMW'],
    //         ['id' => 2, 'name' => 'Mercedes'],
    //         ['id' => 3, 'name' => 'Tesla'],
    //     ]));
    // }

    /*public function testSingleSoilMoisture()
    {
        $this->loadFixture(new SoilMoistureFixtures());
        $this->client->request('GET', '/soilmoisture/1');

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($response->getContent(), json_encode(
            ['id' => 1, 'name' => 'BMW']
        ));
    }

    public function testSingleSoilMoistureNotFound()
    {
        $this->client->request('GET', '/soilmoisture/1');

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }*/

    public function testCreateSoilMoisture()
    {
        $this->loadFixture(new SoilMoistureFixtures());
        $SoilMoistureValue = 33.3;
        $soilMoistureSensor = 'drei';
        $this->client->request('POST', '/soilmoisture/add', [], [], [], json_encode([
            'value' => $SoilMoistureValue,
            'sensor' => $soilMoistureSensor
        ])); 
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        /** @var SoilMoisture $SoilMoisture */
        $SoilMoisture = $em->getRepository(SoilMoisture::class)->findOneBy(['sensor' => 'drei']);
        $this->assertEquals($SoilMoistureValue, $SoilMoisture->getValue());
    }

    // public function testDeleteSoilMoisture()
    // {
    //     $this->loadFixture(new SoilMoistureFixtures());
    //     $this->client->request('DELETE', '/soilmoisture/1');

    //     $response = $this->client->getResponse();
    //     $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    //     $this->assertEmpty($response->getContent());

    //     /** @var EntityManager $em */
    //     $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    //     /** @var SoilMoisture $SoilMoisture */
    //     $SoilMoistures = $em->getRepository(SoilMoisture::class)->findAll();
    //     $this->assertCount(2, $SoilMoistures);
    // }

    public function testNoEmptyParamatersAreAllowed()
    {
        $this->loadFixture(new SoilMoistureFixtures());
        $SoilMoistureValue = 33.3;
        $soilMoistureSensor = 'drei';
        $this->client->request('POST', '/soilmoisture/add', [], [], [], json_encode([
            'value' => $SoilMoistureValue
        ])); 
        $response = $this->client->getResponse();

        $this->assertEquals($response->getStatusCode(), '400');
    }
}