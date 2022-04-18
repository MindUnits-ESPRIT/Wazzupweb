<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\EditProfileType;
use App\Repository\InteretsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProfileController extends AbstractController
{
    /**
     * @Route("/edit/profile", name="app_edit_profile")
     */
    public function index(Request $request,SessionInterface $session,InteretsRepository $repo): Response
    {
        $user=new Utilisateurs();
        $form=$this->createForm(EditProfileType::class,$user);
        $form->handleRequest($request);
        $user=$session->get('userdata');
        $interets=$repo->findBy(['idUtilisateur' => 58]);
        // dd($interets);
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        else{
           
        return $this->render('edit_profile/index.html.twig', [
            'controller_name' => 'EditProfileController',
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>$user->getAvatar(),
            'interets' =>$interets,
            'edit_form' => $form ->createView(),
            
            
        ]);
    }
}
}
