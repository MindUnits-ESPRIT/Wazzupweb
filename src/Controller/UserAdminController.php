<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAdminController extends AbstractController
{
    /**
     * @Route("/user/admin", name="app_user_admin")
     */
    public function index(
        SessionInterface $session,
        UtilisateursRepository $s
    ): Response {
        $users = new Utilisateurs();
        $users = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->findAll();

        $user = $session->get('userdata');
        if ($user == null || $user->getTypeUser() == 'User') {
            return $this->redirectToRoute('app_auth');
        }

        return $this->render('user_admin/index.html.twig', [
            'controller_name' => 'UserAdminController',
            'user' => $user,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'users' => $users,
        ]);
    }
/**
     * @Route("/user/admin/activate/{id}", name="admin_useractivate")
     */
    public function ActiverCompte(     
    $id,
    EntityManagerInterface $em,
    UtilisateursRepository $userrep){
        $u = $userrep->findOneBy([
            'idUtilisateur' => $id,
        ]);
          if ($u) {
            $u->setActivated(true);
            $u->setToken(null);
            $em->persist($u);
            $em->flush();
        }
        $this->addFlash('success', 'Le compte utilisateur a été bien activé !');
        return $this->redirectToRoute('app_user_admin');
    }

    /**
     * @Route("/user/admin/delete/{id}", name="admin_userdelete")
     */
    public function SupprimerUser(
        $id,
        EntityManagerInterface $em,
        UtilisateursRepository $userrep
    ) {
        $u = $userrep->findOneBy([
            'idUtilisateur' => $id,
        ]);
        
    
        if ($u) {
            $em->remove($u);
            $em->flush();
        }
        $this->addFlash('success', 'L\'utilisateur a été bien supprimé !');
        return $this->redirectToRoute('app_user_admin');
    }
}