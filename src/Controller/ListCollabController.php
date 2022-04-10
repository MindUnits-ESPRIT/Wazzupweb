<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateurs;
class ListCollabController extends AbstractController
{
    /**
     * @Route("/list/collab", name="app_list_collab"  , methods={"GET", "POST"})
     */
    public function index(): Response
    {
        return $this->render('list_collab/index.html.twig', [
            'controller_name' => 'ListCollabController',
        ]);
    }
}
