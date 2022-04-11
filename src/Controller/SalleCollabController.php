<?php

namespace App\Controller;

use App\Entity\SalleCollaboration;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleCollabController extends AbstractController
{
    /**
     * @Route("/sallecollab{collabn}", name="app_salle_collab")
     */
    public function index($collabn): Response
    {
        $collab = new SalleCollaboration(); 
        $collab = $this->getDoctrine()->getRepository(SalleCollaboration::class)->findBy(['nomCollab'=>$collabn])[0];
        return $this->render('salle_collab/index.html.twig', [
            'controller_name' => 'SalleCollabController',
            'collab'=>$collab,
        ]);
    }
}
