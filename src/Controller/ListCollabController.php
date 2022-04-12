<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SalleCollabRepository;
use App\Entity\Utilisateurs;
class ListCollabController extends AbstractController
{
    /**
     * @Route("/listcollab", name="app_list_collab")
     */
    public function listCollab(SalleCollabRepository $s,Request $req): Response
    {    
        $user = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(59);
        $collabs=$s->showUserCollabs(59);
        return $this->render('listcollab/index.html.twig', [
            'controller_name' => 'ListCollabController',
            'collabs'=>$collabs,
            'user'=>$user
        ]);
    }
}
