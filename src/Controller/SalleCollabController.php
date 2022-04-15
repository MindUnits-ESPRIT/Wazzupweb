<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\SalleCollaboration;
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
        $u = $s->findBy([
            'id_collab' => $idu,
            'ID_Utlisateur' => $id,
        ])[0];

        $entityManager->remove($u);
        $entityManager->flush();
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idu);
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
