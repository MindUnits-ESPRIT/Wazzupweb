<?php

namespace App\Repository;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method SalleCollaboration|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalleCollaboration|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalleCollaboration[]    findAll()
 * @method SalleCollaboration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleCollabRepository extends ServiceEntityRepository
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

/**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showUserCollabs(int $id)
    {
        $q = $this->createQueryBuilder('g')
        ->innerJoin('App\Entity\CollabMembers', 's', Join::WITH,  'g.idCollab = s.id_collab')
        ->where('s.ID_Utlisateur = :id')
        ->groupBy('s.id_collab')
        ->setParameter('id', $id);  
    return ($q->getQuery()->getResult());       
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
