<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SalleCollabRepository;
use App\Form\SuppcollabType;
use App\Entity\Utilisateurs;
class ListCollabController extends AbstractController
{
    /**
     * @Route("/listcollab", name="app_list_collab")
     */
    public function listCollab(SalleCollabRepository $s, Request $req): Response
    {
        $cnt = 0;
        $cnt1 = 100;
        $cnt2 = 'A';
        $collab = new SalleCollaboration();
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find(60);
        $collabs = $s->showUserCollabs(60);
        return $this->render('listcollab/index.html.twig', [
            'controller_name' => 'ListCollabController',
            'collabs' => $collabs,
            'user' => $user,
            'cunt' => $cnt,
            'cunt1' => $cnt1,
            'cunt2' => $cnt2,
        ]);
    }

    /**
     * @Route("/delete{name}", name="deleteC")
     */
    public function delete($name, EntityManagerInterface $entityManager)
    {
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy([
                'nomCollab' => $name,
            ])[0];

        $entityManager->remove($collab);
        $entityManager->flush();

        return $this->redirectToRoute('app_list_collab');
    }
}
