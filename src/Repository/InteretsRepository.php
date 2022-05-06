<?php

namespace App\Repository;

use App\Entity\Interets;
use App\Entity\Utilisateurs;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Interets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interets[]    findAll()
 * @method Interets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteretsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interets::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Interets $entity, bool $flush = true): void
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
    public function remove(Interets $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function ListInterets(int $id)
    {
        $q = $this->createQueryBuilder('i')
        ->innerJoin('App\Entity\Utilisateurs', 'u', Join::WITH,  'i.ID_Utilisateur	 = u.ID_Utilisateur	')
        ->where('i.ID_Utlisateur = :id')
        ->groupBy('u.ID_Utilisateur')
        ->setParameter('id', $id);  
    return ($q->getQuery()->getResult());       
    }
}


    // /**
    //  * @return Interets[] Returns an array of Interets objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interets
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

