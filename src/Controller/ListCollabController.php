<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SalleCollabRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\SuppcollabType;
use App\Entity\CollabMembers;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class ListCollabController extends AbstractController
{
    /**
     * @Route("/listcollab", name="app_list_collab")
     */
    public function listCollab(
        SalleCollabRepository $s,
        Request $req,
        SessionInterface $session
    ): Response {
        $user1 = $session->get('userdata');
        if ($user1 == null) {
            return $this->redirectToRoute('app_auth');
        }

        $cnt = 0;
        $cnt1 = 100;
        $cnt2 = 'A';
        $collab = new SalleCollaboration();
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($user1->getIdUtilisateur());
        $collabs = $s->showUserCollabs($user->getIdUtilisateur());

        $form = $this->createForm(SuppcollabType::class, $collab);

        $form->handleRequest($req);
        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $collab->setNomCollab($form->get('nomCollab')->getData());
            $collab->setnomconfirm($form->get('nomconfirm')->getData());
            $collab1 = $this->getDoctrine()
                ->getRepository(SalleCollaboration::class)
                ->findBy([
                    'nomCollab' => $form->get('nomCollab')->getData(),
                ])[0];

            $this->addFlash('success', 'Collab supprimer !');
        }

        return $this->render('listcollab/index.html.twig', [
            'controller_name' => 'ListCollabController',
            'collab_formC' => $form->createView(),
            'collabs' => $collabs,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
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

    /**
     * @Route("/mod{name},{oldn}", name="modC")
     */
    public function mod($name, $oldn, EntityManagerInterface $entityManager)
    {
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy([
                'nomCollab' => $oldn,
            ])[0];
        $collab->setNomCollab($name);
        $entityManager->flush();

        return $this->redirectToRoute('app_list_collab');
    }
    /**
     * @Route("/listcollabMobile", name="app_list_collabMobile")
     */
    public function listCollabMobile(
        SalleCollabRepository $s,
        Request $req,
        SessionInterface $session,
        NormalizerInterface $Normalizer
    ): Response {
        $collab = new SalleCollaboration();
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($req->get('id'));
        $collabs = $s->showUserCollabs($user->getIdUtilisateur());
        $form = $this->createForm(SuppcollabType::class, $collab);
        $form->handleRequest($req);
        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $collab->setNomCollab($form->get('nomCollab')->getData());
            $collab->setnomconfirm($form->get('nomconfirm')->getData());
            $collab1 = $this->getDoctrine()
                ->getRepository(SalleCollaboration::class)
                ->findBy([
                    'nomCollab' => $form->get('nomCollab')->getData(),
                ])[0];

            $this->addFlash('success', 'Collab supprimer !');
        }
        $jsonContent = $Normalizer->normalize($collabs, 'json', [
            'groups' => 'post:read',
        ]);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/CollabCreer", name="app_creerCollab", methods={"POST"})
     */
    public function CollabCreer(
        Request $request,
        EntityManagerInterface $entityManager,
        NormalizerInterface $normalizable,
        SessionInterface $session
    ): Response {
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($request->get('id'));
        $collab = new SalleCollaboration();
        $collab->setNomCollab($request->get('nom'));
        $usercollab = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($user->getIdUtilisateur());
        $collab->setIdUtilisateur($usercollab);

        $collab->setUrlCollab('www.' . $request->get('nom') . '.com');
        $collab_member = new CollabMembers();

        $entityManager->persist($collab);
        $entityManager->flush();

        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy([
                'nomCollab' => $request->get('nom'),
            ])[0];
        $collab_member->setid_collab($collab->getIdCollab());
        $collab_member->setIdUtilisateur($user->getIdUtilisateur());
        $entityManager->persist($collab_member);
        $entityManager->flush();
        $result = 'creation terminer';
        $jsonContent = $normalizable->normalize($result, 'json', [
            'groups' => 'post:read',
        ]);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/MobileD", name="deleteMobile",methods={"POST"})
     */
    public function deleteMobileC(
        Request $request,
        EntityManagerInterface $entityManager,
        NormalizerInterface $normalizable
    ): Response {
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy([
                'nomCollab' => $request->get('nom'),
            ])[0];

        $entityManager->remove($collab);
        $entityManager->flush();

        $result = 'suppression terminer';
        $jsonContent = $normalizable->normalize($result, 'json', [
            'groups' => 'post:read',
        ]);
        return new Response(json_encode($jsonContent));
    }
}
