<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipe>
 *
 * @method Equipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipe[]    findAll()
 * @method Equipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipe::class);
    }

    public function save(Equipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Equipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Equipe[] Returns an array of Equipe objects
    */
   public function findByNomGroupeCategorie($n,$c,$g): array
   {
       return $this->createQueryBuilder('e')
           ->Where('e.nom LIKE :n')
           ->andWhere('e.categorie LIKE :c')
           ->andWhere('e.groupe LIKE :g')
           ->setParameter('n', "%{$n}%")
           ->setParameter('c', "%{$c}%")
           ->setParameter('g', "%{$g}%")
           ->orderBy('e.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findByCategorie($c): array
   {
       return $this->createQueryBuilder('e')
           ->Where('e.categorie LIKE :c')
           ->setParameter('c', "%{$c}%")
           ->orderBy('e.nom', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
}
