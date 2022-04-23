<?php

namespace App\Controller;

use App\Entity\Rencontre;
use App\Entity\Evenement;
use App\Form\RencontreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rencontre")
 */
class RencontreController extends AbstractController
{
    /**
     * @Route("/list/{event}", name="app_rencontre_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Evenement $event,Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        $rencontres = $entityManager
            ->getRepository(Rencontre::class)
            ->findBy(['ID_Event'=>$event
            ]);
         return $this->render('rencontre/index.html.twig', [
            'rencontres' => $rencontres,
             'event' => $event->getId(),
             'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]); 
    }

    /**
     * @Route("/new", name="app_rencontre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        $rencontre = new Rencontre();

        $event=$entityManager->getRepository(Evenement::class)->find($request->query->get('evenement'));
        $rencontre->setEvenement($event);
        $rencontre->setUrlInvitation("");

        $form = $this->createForm(RencontreType::class, $rencontre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rencontre);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', ['user'=>$user->getIdUtilisateur()
            //$this->getUser()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rencontre/new.html.twig', [
            'rencontre' => $rencontre,
            'form' => $form->createView(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rencontre_show", methods={"GET"})
     */
    public function show(Rencontre $rencontre,Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        return $this->render('rencontre/show.html.twig', [
            'rencontre' => $rencontre,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_rencontre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Rencontre $rencontre, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        $form = $this->createForm(RencontreType::class, $rencontre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', ['user'=>$user->getIdUtilisateur()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rencontre/edit.html.twig', [
            'rencontre' => $rencontre,
            'form' => $form->createView(),
            'event'=>$rencontre->getEvenement()->getId(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rencontre_delete", methods={"POST"})
     */
    public function delete(Request $request, Rencontre $rencontre, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        if ($this->isCsrfTokenValid('delete'.$rencontre->getId(), $request->request->get('_token'))) {
            $event=$rencontre->getEvenement();
            $entityManager->remove($rencontre);
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', ['user'=> $user->getIdUtilisateur()
        //$this->getUser()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
