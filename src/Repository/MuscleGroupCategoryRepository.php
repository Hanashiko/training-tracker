<?php

namespace App\Repository;

use App\Entity\MuscleGroupCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MuscleGroupCategory>
 */
class MuscleGroupCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MuscleGroupCategory::class);
    }
}
