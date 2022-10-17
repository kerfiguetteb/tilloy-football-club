<?php

namespace App\Repository;

use App\Entity\Convocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Convocation>
 *
 * @method Convocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Convocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Convocation[]    findAll()
 * @method Convocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConvocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Convocation::class);
    }

    public function save(Convocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Convocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Convocation[] Returns an array of Convocation objects
    */
    public function findByGame($value): array
    {
        return $this->createQueryBuilder('c')
         ->Where('c.game = :val')
         // ->Where('c.nom = :val')
         ->setParameter('val', $value)
         ->orderBy('c.id', 'ASC')
         // ->setMaxResults(10)
         ->getQuery()
         ->getResult()
        ;
    }
    // public function findByJoueurInGame(): array
    // {
    //     return $this->createQueryBuilder('c')
    //      ->Where('c.game = :val')
    //      ->Where('c.nom = :val')
    //      ->setParameter('val', $value)
    //      ->orderBy('c.id', 'ASC')
    //      // ->setMaxResults(10)
    //      ->getQuery()
    //      ->getResult()
    //     ;
    // }
  
//    public function findOneBySomeField($value): ?Convocation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
