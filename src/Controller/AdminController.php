<?php

namespace App\Controller;
use App\Entity\Utilisateurs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        if ($user == null || $user->getTypeUser() == 'User') {
            return $this->redirectToRoute('app_auth');
        }
        return $this->render('UIAdmin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
        ]);
    }
}
