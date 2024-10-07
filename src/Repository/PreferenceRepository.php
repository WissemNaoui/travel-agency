<?php

namespace App\Repository;

use App\Entity\Preference;
use Doctrine\ORM\EntityRepository;

class PreferenceRepository extends EntityRepository
{
    public function findPreferencesForUser($userId)
    {
        return $this->createQueryBuilder('p')
            ->where('p.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}