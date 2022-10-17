<?php

namespace App\Repository;

use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Joueur>
 *
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }

    public function save(Joueur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Joueur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Joueur[] Returns an array of Joueur objects
    */
   public function findByEquipe($value): array
   {
       return $this->createQueryBuilder('j')
           ->innerJoin('j.equipe' ,'e')
           ->Where('e.id = :val')
           ->setParameter('val', $value)
        //    ->orderBy('j.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   public function findBySectionGroupeName($s,$g, $n)
   {
      return $this->createQueryBuilder('j')
      ->innerJoin('j.categorie', 'g')
      ->Where('g.section LIKE :section')
      ->andWhere('g.groupe LIKE :groupe')
      ->andWhere('g.nom LIKE :nom')
      ->setParameter('groupe', "%{$g}%")
      ->setParameter('section', "%{$s}%")
      ->setParameter('nom', "%{$n}%")
      // ->orderBy('s.firstname', 'ASC')
      // ->orderBy('s.lastname', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
  ;

   }

//    public function findOneBySomeField($value): ?Joueur
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
