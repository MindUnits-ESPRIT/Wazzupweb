<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\SalleCollaboration;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SalleCollabRepository;
use App\Repository\UtilisateursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleCollabController extends AbstractController
{
    /**
     * @Route("/sallecollab{collabn}", name="app_salle_collab")
     */
    public function index(
        $collabn,
        UtilisateursRepository $s,
        Request $req
    ): Response {
        $collab = new SalleCollaboration();
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find(60);
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy(['nomCollab' => $collabn])[0];
        $Projet = new Projet();

        $Projet = $this->getDoctrine()
            ->getRepository(Projet::class)
            ->findOneBy(['idCollab' => $collab]);

        $users = $s->showCollabUsers($collab->getIdCollab());
        return $this->render('salle_collab/index.html.twig', [
            'controller_name' => 'SalleCollabController',
            'collab' => $collab,
            'users' => $users,
            'user' => $user,
            'projet' => $Projet,
        ]);
    }
}
