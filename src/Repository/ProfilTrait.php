<?php

namespace App\Repository;

use App\Entity\User;

Trait ProfilTrait
{
    public function _findByUser(User $user)
    {
        return $this->createQueryBuilder('p')
            ->join('p.user', 'u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
