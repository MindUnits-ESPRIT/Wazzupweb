<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SalleCollabRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListCollabController extends AbstractController
{
    /**
     * @Route("/listcollab", name="app_list_collab")
     */
    public function listCollab(SalleCollabRepository $s,Request $req,SessionInterface $session): Response
    {    
        // $user = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(59);
        $user=$session->get('userdata');
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        else{
        $id=$user->getIdUtilisateur();
        $collabs=$s->showUserCollabs($id);
        return $this->render('listcollab/index.html.twig', [
            'controller_name' => 'ListCollabController',
            'collabs'=>$collabs,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'user'=>$user
        ]);
    }
}
}
