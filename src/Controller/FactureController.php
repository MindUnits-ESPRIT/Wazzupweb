<?php

namespace App\Controller;
use App\Entity\Paiement;
use App\Entity\OffrePublicitaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="app_facture")
     */
    public function index(SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        $OffrePublicitaire = $this->getDoctrine() ->getRepository(OffrePublicitaire::class)->find(29);
        $paiement = $this->getDoctrine()->getRepository(Paiement::class)->findOneBy([],["idPaiement"=>'DESC'],1,0);
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
            'paiement'=>$paiement, 
            'OffrePublicitaire'=>$OffrePublicitaire

        ]);
    }
    
}
