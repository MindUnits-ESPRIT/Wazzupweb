<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\OffrePublicitaire;
use App\Form\OffrePublicitaireType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementAdminController  extends AbstractController
{
    /**
     * @Route("/paiement/admin", name="app_paiement_admin")
     */
    public function index(
        SessionInterface $session,EntityManagerInterface $entityManager): Response 
        {

            $offrePublicitaires = $entityManager
            ->getRepository(OffrePublicitaire::class)
            ->findAll();
         
         $user = $session->get('userdata');
        if ($user == null || $user->getTypeUser() == 'User') {
            return $this->redirectToRoute('app_auth');
        }
        return $this->render('paiement_admin/index.html.twig', [
            'controller_name' => 'PaiementAdminController',
            'offre_publicitaire' => $offrePublicitaires,
        
            'user' => $user,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
        ]);
    }
}
