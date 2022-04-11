<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleCollabController extends AbstractController
{
    /**
     * @Route("/sallecollab", name="app_salle_collab")
     */
    public function index(): Response
    {
        return $this->render('salle_collab/index.html.twig', [
            'controller_name' => 'SalleCollabController',
        ]);
    }
}
