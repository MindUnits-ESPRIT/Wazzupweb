<?php

namespace App\Controller;

use App\Entity\SalleCollaboration;
use App\Repository\SalleCollabRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CollabAdminController extends AbstractController
{
    /**
     * @Route("/collab/admin", name="app_collab_admin")
     */
    public function index(
        SessionInterface $session,
        SalleCollabRepository $s
    ): Response {
        $collab = new SalleCollaboration();
        $collabs = $s->findAll();
        $user = $session->get('userdata');
        if ($user == null || $user->getTypeUser() == 'User') {
            return $this->redirectToRoute('app_auth');
        }
        return $this->render('collab_admin/index.html.twig', [
            'controller_name' => 'CollabAdminController',
            'user' => $user,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'collabs' => $collabs,
        ]);
    }
}
