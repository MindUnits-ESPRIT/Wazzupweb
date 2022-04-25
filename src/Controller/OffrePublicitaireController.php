<?php

namespace App\Controller;

use App\Entity\OffrePublicitaire;
use App\Entity\Utilisateurs;
use App\Form\OffrePublicitaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * @Route("/Offre")
 */

class OffrePublicitaireController extends AbstractController
{
    /**
     * @Route("/", name="app_offre_publicitaire_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    { 
        
        $user = $session->get('userdata');
        $offrePublicitaires = $entityManager
            ->getRepository(OffrePublicitaire::class)
            ->findAll();

        return $this->render('offre_publicitaire/index.html.twig', [
            'offre_publicitaires' => $offrePublicitaires,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="app_offre_publicitaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    { $user = $session->get('userdata');
        $offrePublicitaire = new OffrePublicitaire();
        $form = $this->createForm(OffrePublicitaireType::class, $offrePublicitaire);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user=$entityManager->getRepository(Utilisateurs::class)->find($user);
            $R=$request->request->get('offre_publicitaire');
            $offrePublicitaire->setnomOffre("Offre Premium");//BECH ITBADEL EL NAME LI 7ACHTEK BIHHHH
            $offrePublicitaire->setcontenuOffre($R['contenuOffre']);
            $offrePublicitaire->setnbrMaxOffre($R['nbrMaxOffre']) ;
            $offrePublicitaire->setIdUtilisateur($user);
            $entityManager->persist($offrePublicitaire);
     
            $entityManager->flush();

//            return $this->redirectToRoute('app_offre_publicitaire_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_paiement_new', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('offre_publicitaire/new.html.twig', [
            'offre_publicitaire' => $offrePublicitaire,
            'form' => $form->createView(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{idOffre}", name="app_offre_publicitaire_show", methods={"GET"})
     */
    public function show(OffrePublicitaire $offrePublicitaire,SessionInterface $session): Response
    { $user = $session->get('userdata');
        return $this->render('offre_publicitaire/show.html.twig', [
            'offre_publicitaire' => $offrePublicitaire,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{idOffre}/edit", name="app_offre_publicitaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OffrePublicitaire $offrePublicitaire, EntityManagerInterface $entityManager,SessionInterface $session): Response
    { $user = $session->get('userdata');
        $form = $this->createForm(OffrePublicitaireType::class, $offrePublicitaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_publicitaire_index', [
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getTypeUser(),
                'picture' => $user->getAvatar(),
                'user' => $user,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre_publicitaire/edit.html.twig', [
            'offre_publicitaire' => $offrePublicitaire,
            'form' => $form->createView(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{idOffre}", name="app_offre_publicitaire_delete", methods={"POST"})
     */
    public function delete(Request $request, OffrePublicitaire $offrePublicitaire, EntityManagerInterface $entityManager,SessionInterface $session): Response
    { $user = $session->get('userdata');
        if ($this->isCsrfTokenValid('delete'.$offrePublicitaire->getIdOffre(), $request->request->get('_token'))) {
            $entityManager->remove($offrePublicitaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offre_publicitaire_index', [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ], Response::HTTP_SEE_OTHER);
    }
}
