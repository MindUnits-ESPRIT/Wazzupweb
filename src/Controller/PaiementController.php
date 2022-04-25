<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\Utilisateurs;
use App\Form\PaiementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * @Route("/paiement")
 */
class PaiementController extends AbstractController
{
    /**
     * @Route("/", name="app_paiement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        $paiements = $entityManager
            ->getRepository(Paiement::class)
            ->findAll();

        return $this->render('paiement/index.html.twig', [
            'paiements' => $paiements,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="app_paiement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {   
        $user = $session->get('userdata');
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user=$entityManager->getRepository(Utilisateurs::class)->find($user);
            $R=$form->getData();
            $s=$form->get('prix')->getData();
            $paiement->setPrix($s);
            $m=$form->get('methodePaiement')->getData();
            $paiement->setMethodePaiement($m);
            $user = new Utilisateurs();
           
            $entityManager->persist($paiement);
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paiement/new.html.twig', [
            'controller_name' => 'PaiementController',
            'form' => $form->createView(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{idPaiement}", name="app_paiement_show", methods={"GET"})
     */
    public function show(Paiement $paiement,SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{idPaiement}/edit", name="app_paiement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Paiement $paiement, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{idPaiement}", name="app_paiement_delete", methods={"POST"})
     */
    public function delete(Request $request, Paiement $paiement, EntityManagerInterface $entityManager,SessionInterface $session): Response
    { $user = $session->get('userdata');
        if ($this->isCsrfTokenValid('delete'.$paiement->getIdPaiement(), $request->request->get('_token'))) {
            
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paiement_index', [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ], Response::HTTP_SEE_OTHER);
    }

}
