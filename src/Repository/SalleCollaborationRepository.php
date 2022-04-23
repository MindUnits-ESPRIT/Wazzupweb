<?php

namespace App\Repository;

use App\Entity\SalleCollaboration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalleCollaboration|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalleCollaboration|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalleCollaboration[]    findAll()
 * @method SalleCollaboration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleCollaborationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalleCollaboration::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SalleCollaboration $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(SalleCollaboration $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return SalleCollaboration[] Returns an array of SalleCollaboration objects
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
    public function findOneBySomeField($value): ?SalleCollaboration
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
