<?php

namespace App\Controller;
use App\Entity\Utilisateurs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsocketController extends AbstractController
{
    /**
     * @Route("/chat", name="app_websocket")
     */
    public function index(Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        return $this->render('websocket/index.html.twig', [
            'controller_name' => 'WebsocketController',
            'user'=>$user,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
        ]);
    }
}
