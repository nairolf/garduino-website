<?php

namespace App\Tests\Controller;

use App\Controller\StartController;
use App\Entity\Temperature;
use App\Repository\TemperatureRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StartControllerTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIndex()
    {
        $product = $this->entityManager
            ->getRepository(Temperature::class)
            ->findAll();
        $this->assertTrue(1 == 1, 'Funzt');
    }
}
