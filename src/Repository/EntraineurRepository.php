<?php

namespace App\Repository;

use App\Entity\Entraineur;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entraineur>
 *
 * @method Entraineur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entraineur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entraineur[]    findAll()
 * @method Entraineur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntraineurRepository extends ServiceEntityRepository
{
    use ProfilTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entraineur::class);
    }

    public function save(Entraineur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Entraineur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUser(User $user): ?Entraineur
    {
        return $this->__findByUser($user);
    }
  
  
    /**
    * @return Entraineur[] Returns an array of Entraineur objects
    */
   public function findByEquipe($value): array
   {
       return $this->createQueryBuilder('E')
           ->innerJoin('E.equipe','e')
           ->Where('e.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult()
       ;
   }



//    public function findOneBySomeField($value): ?Entraineur
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
