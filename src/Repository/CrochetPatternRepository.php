<?php

namespace App\Repository;

use App\Entity\CrochetPattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Member;

/**
 * @extends ServiceEntityRepository<CrochetPattern>
 */
class CrochetPatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CrochetPattern::class);
    }

    /**
     * @return CrochetPattern[] Returns an array of CrochetPattern objects for a member
     */
    
    public function findMemberCrochetPatterns(Member $member): array
    {
        return $this->createQueryBuilder('cp') // cp pour CrochetPattern
        ->join('cp.patternCollection', 'pc') // Jointure sur patternCollection
        ->andWhere('pc.Designer = :member')   // Condition pour le membre
        ->setParameter('member', $member)  // Définition du paramètre
        ->getQuery()
        ->getResult();
    }
    

    //    public function findOneBySomeField($value): ?CrochetPattern
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
