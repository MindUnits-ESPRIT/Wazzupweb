<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListCollabController extends AbstractController
{
    /**
     * @Route("/listcollab", name="app_list_collab")
     */
    public function index(): Response
    {
        return $this->render('listcollab/index.html.twig', [
            'controller_name' => 'ListCollabController',
        ]);
    }
}
