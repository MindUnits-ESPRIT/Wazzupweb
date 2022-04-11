<?php

namespace App\Repository;

use App\Entity\CollabMembers;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\SalleCollaboration;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method CollabMembers|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollabMembers|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollabMembers[]    findAll()
 * @method CollabMembers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollabMembersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollabMembers::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CollabMembers $entity, bool $flush = true): void
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
    public function remove(CollabMembers $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    




    // /**
    //  * @return CollabMembers[] Returns an array of CollabMembers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CollabMembers
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
