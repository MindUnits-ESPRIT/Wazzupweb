<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorpageController extends AbstractController
{
    /**
     * @Route("/404", name="app_error")
     */
    public function index(): Response
    {
        return $this->render('error-pages/404.html.twig', [
            'controller_name' => 'ErrorpageController',
        ]);
    }
}
