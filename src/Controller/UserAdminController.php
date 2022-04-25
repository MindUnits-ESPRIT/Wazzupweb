<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Utilisateurs;
use App\Repository\UtilisateursRepository;
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
}
