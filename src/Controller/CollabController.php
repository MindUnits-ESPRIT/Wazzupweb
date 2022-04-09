<?php

namespace App\Controller;
use App\Entity\SalleCollaboration;
use App\Form\CollabType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateurs;


class CollabController extends AbstractController
{
    /**
     * @Route("/collab", name="app_collab" , methods={"GET", "POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $collab=new SalleCollaboration();
        $form = $this->createForm(CollabType::class);

        $form->handleRequest($request);
        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $collab->setNomCollab($form->get('nomCollab')->getData());     
            $user = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(59);
            $collab->setIdUtilisateur($user); 
            $collab->setUrlCollab('www.'.$form->get('nomCollab')->getData().'.com');  
            $entityManager->persist($collab);
            $entityManager->flush();
            $this->addFlash('success', 'Collab creé !');

        }
        return $this->render('collab/index.html.twig', [
            'controller_name' => 'CollabController',
            'collab_form' => $form ->createView()
        ]);
    }
}
