<?php

namespace App\Repository;

use App\Entity\Utilisateurs;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Utilisateurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateurs[]    findAll()
 * @method Utilisateurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateurs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Utilisateurs $entity, bool $flush = true): void
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
    public function remove(Utilisateurs $entity, bool $flush = true): void
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
    public function showCollabUsers(int $id)
    {
        $q = $this->createQueryBuilder('g')
            ->innerJoin(
                'App\Entity\CollabMembers',
                's',
                Join::WITH,
                'g.idUtilisateur = s.ID_Utlisateur'
            )
            ->where('s.id_collab = :id')
            ->setParameter('id', $id);
        return $q->getQuery()->getResult();
    }
    //SELECT ID_Utilisateur,prenom,nom FROM `utilisateurs` WHERE (ID_Utilisateur,prenom, nom)
    //NOT IN(SELECT ID_Utilisateur,prenom,nom FROM `Utilisateurs`
    //  inner join `collab_members` on utilisateurs.ID_Utilisateur = collab_members.ID_utlisateur
    // where `ID_Collab` =  '$idc' )GROUP BY nom,prenom ORDER BY ID_Utilisateur
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showCollabNotUsers(int $idc)
    {
        $q = $this->createQueryBuilder('g')
            ->innerJoin(
                'App\Entity\CollabMembers',
                's',
                Join::WITH,
                'g.idUtilisateur = s.ID_Utlisateur'
            )
            ->where('s.id_collab = :id');

        // Récupération de tous sauf les lus
        $qb = $this->createQueryBuilder('f')
            ->where('f.idUtilisateur NOT IN (' . $q->getDQL() . ')')
            ->setParameter('id', $idc);
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Utilisateurs[] Returns an array of Utilisateurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utilisateurs
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
