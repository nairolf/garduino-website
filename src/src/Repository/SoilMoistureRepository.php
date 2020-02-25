<?php

namespace App\Repository;

use App\Entity\SoilMoisture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method SoilMoisture|null find($id, $lockMode = null, $lockVersion = null)
 * @method SoilMoisture|null findOneBy(array $criteria, array $orderBy = null)
 * @method SoilMoisture[]    findAll()
 * @method SoilMoisture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoilMoistureRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
    EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, SoilMoisture::class);
        $this->manager = $manager;
    }

    public function saveSoilMoisture($value, $sensor)
    {
        $newSoilMoisture = new SoilMoisture();
        $newSoilMoisture
            ->setValue($value)
            ->setSensor($sensor)
            ->setTimestamp(new \DateTime);

        $this->manager->persist($newSoilMoisture);
        $this->manager->flush();
    }

    // /**
    //  * @return SoilMoisture[] Returns an array of SoilMoisture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SoilMoisture
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
