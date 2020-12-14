<?php

namespace App\Repository;

use App\Entity\Record;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Record|null find($id, $lockMode = null, $lockVersion = null)
 * @method Record|null findOneBy(array $criteria, array $orderBy = null)
 * @method Record[]    findAll()
 * @method Record[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordRepository extends ServiceEntityRepository
{
    /**
     * RecordRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    /**
     * @param array $idents
     * @return array
     */
    public function getNotExistingRecords(array $idents = []): array
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r.ident');

        $recordsIdents =  array_map(function($el) {
            return $el['ident'];
        }, $qb->getQuery()->getScalarResult());

        return array_diff($idents, $recordsIdents);
    }


    /**
     * @param array $idents
     * @param array $versions
     * @return int|mixed|string
     */
    public function getUpdatedRecords(array $idents = [], array $versions = [])
    {
        $qb = $this->createQueryBuilder('r');
        $expr = $qb->expr();

        foreach ($idents as $index => $ident) {
            $qb
                ->andWhere('r.ident = :ident')
                ->setParameter('ident', $ident)
                ->andWhere($expr->gt('r.version', $versions[$index]));
        }

        return $qb->getQuery()->getResult();
    }


    /**
     * @param array $idents
     * @return int|mixed|string
     */
    public function getNotFilledRecords(array $idents = [])
    {
        $qb = $this->createQueryBuilder('r');
        $qb->andWhere($qb->expr()->notIn('r.ident', $idents));
        
        return $qb->getQuery()->getResult();
    }
}
