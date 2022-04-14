<?php

namespace App\Controller;
use App\Form\CollabType;

use App\Entity\Utilisateurs;
use App\Entity\CollabMembers;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CollabController extends AbstractController
{
    /**
     * @Route("/collab", name="app_collab" , methods={"GET", "POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $user=$session->get('userdata');
        $collab=new SalleCollaboration();
        $form = $this->createForm(CollabType::class,$collab);

        $form->handleRequest($request);
        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $collab->setNomCollab($form->get('nomCollab')->getData());
            $user = $this->getDoctrine()
                ->getRepository(Utilisateurs::class)
                ->find(59);
            $collab->setIdUtilisateur($user);
            $collab->setUrlCollab(
                'www.' . $form->get('nomCollab')->getData() . '.com'
            );
            $collab_member = new CollabMembers();

            $entityManager->persist($collab);
            $entityManager->flush();

            $collab = $this->getDoctrine()
                ->getRepository(SalleCollaboration::class)
                ->findBy([
                    'nomCollab' => $form->get('nomCollab')->getData(),
                ])[0];
            $collab_member->setid_collab($collab->getIdCollab());
            $collab_member->setIdUtilisateur($user->getIdUtilisateur());
            $entityManager->persist($collab_member);
            $entityManager->flush();
            $this->addFlash('success', 'Collab creé !');
        }
        return $this->render('collab/index.html.twig', [
            'controller_name' => 'CollabController',
            'collab_form' => $form ->createView(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'user'=>$user
        ]);
    }
}
