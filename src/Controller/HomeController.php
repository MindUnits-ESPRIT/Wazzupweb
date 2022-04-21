<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(SessionInterface $session): Response
    {
        $user=$session->get('userdata');
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        else{
        // dd($user->getNom(),$user->getPrenom());
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>$user->getAvatar(),
            'user'=>$user


        ]);
    }
}
}
