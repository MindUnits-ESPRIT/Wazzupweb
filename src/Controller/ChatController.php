<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="app_chat")
     */
    public function index(Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getRoles()[0],
            'picture'=>'',
            'user'=>$user,
        ]);
    }
    /**
     * @Route("/chat/listener", name="app_chat_listener")
     */
    public function chatL()
    {
        return $this->json('hello');
    }
}