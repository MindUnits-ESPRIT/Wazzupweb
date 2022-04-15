<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\SalleCollaboration;
use App\Entity\CollabMembers;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SalleCollabRepository;
use App\Repository\CollabMembersRepository;
use App\Repository\UtilisateursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleCollabController extends AbstractController
{
    /**
     * @Route("/sallecollab{collabn}", name="app_salle_collab")
     */
    public function index(
        $collabn,
        SessionInterface $session,
        UtilisateursRepository $s,
        Request $req
    ): Response {
        $user1 = $session->get('userdata');
        $collab = new SalleCollaboration();
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($user1->getIdUtilisateur());
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy(['nomCollab' => $collabn])[0];
        $Projet = new Projet();

        $Projet = $this->getDoctrine()
            ->getRepository(Projet::class)
            ->findOneBy(['idCollab' => $collab]);
        $idc = $collab->getIdCollab();
        $Notusers = $s->showCollabNotUsers($idc);
        $cunter = 1;
        $users = $s->showCollabUsers($collab->getIdCollab());
        return $this->render('salle_collab/index.html.twig', [
            'controller_name' => 'SalleCollabController',
            'collab' => $collab,
            'users' => $users,
            'projet' => $Projet,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
            'notUsers' => $Notusers,
            'projet' => $Projet,
            'userCunt' => $cunter,
        ]);
    }
    /**
     * @Route("/deleteU/{id},{idu}", name="deleteU")
     */
    public function delete(
        $id,
        $idu,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s
    ) {
        $u = $s->findOneBy([
            'id_collab' => $idu,
            'ID_Utlisateur' => $id,
        ]);
        if ($u) {
            $entityManager->remove($u);
            $entityManager->flush();
        }
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idu);
        return $this->redirectToRoute('app_salle_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }

    /**
     * @Route("/addU{idu},{idc},", name="addU")
     */
    public function addU(
        $idu,
        $idc,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s,
        UtilisateursRepository $u
    ) {
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idc);
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($idu);
        $collab_member = new CollabMembers();
        $collab_member->setid_collab($collab->getIdCollab());
        $collab_member->setIdUtilisateur($user->getIdUtilisateur());
        $entityManager->persist($collab_member);
        $entityManager->flush();

        return $this->redirectToRoute('app_salle_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }

    /**
     * @Route("/Quitter/{id},{idu}", name="Quitter")
     */
    public function Quitter(
        $id,
        $idu,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s
    ) {
        $u = $s->findBy([
            'id_collab' => $idu,
            'ID_Utlisateur' => $id,
        ])[0];

        $entityManager->remove($u);
        $entityManager->flush();
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idu);
        return $this->redirectToRoute('app_list_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }
}
