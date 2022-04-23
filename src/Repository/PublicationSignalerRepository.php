<?php

namespace App\Repository;

use App\Entity\PublicationSignaler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicationSignaler|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationSignaler|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationSignaler[]    findAll()
 * @method PublicationSignaler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationSignalerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicationSignaler::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PublicationSignaler $entity, bool $flush = true): void
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
    public function remove(PublicationSignaler $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PublicationSignaler[] Returns an array of PublicationSignaler objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublicationSignaler
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
