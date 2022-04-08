<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="app_auth")
     */
    public function auth(): Response
    {   
        $user=new Utilisateurs();
        $form = $this->createForm(LoginType::class);
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
            'auth_form' => $form ->createView()
        ]);
    }
}
