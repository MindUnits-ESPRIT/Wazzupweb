<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProfileController extends AbstractController
{
    /**
     * @Route("/edit/profile", name="app_edit_profile")
     */
    public function index(SessionInterface $session): Response
    {
        $user=$session->get('userdata');
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        else{
        return $this->render('edit_profile/index.html.twig', [
            'controller_name' => 'EditProfileController',
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
        ]);
    }
}
}
