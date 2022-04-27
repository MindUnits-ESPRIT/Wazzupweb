<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Utilisateurs;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(Request $request,SessionInterface $session,EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $user = $session->get('userdata');
        if ($user == null) {
            return $this->redirectToRoute('app_auth');
        } else {
            $commentaire = new Commentaire();
            $form = $this->createForm(CommentaireType::class, $commentaire);
            $publications = $entityManager
                ->getRepository(Publication::class)
                ->findBy(['idUtilisateur'=>$user]);
            $utili=$entityManager->getRepository(Utilisateurs::class)->find($user);
            $commentaire = $entityManager
                ->getRepository(Commentaire::class)
                ->findBy(['idUtilisateur'=>$user]);
            $data = $paginator->paginate($publications,$request->query->getInt('page',1),4);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'publications' => $data,
            'formC'=>$form->createView(),
            'utili'=>$utili,
            'commentaires' => $commentaire,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }
    }

    /**
     * @Route("/profile/{id}", name="app_profile_byid")
     */
    public function showProfile($id,Request $request,SessionInterface $session,EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $user = $session->get('userdata');
        if ($user == null) {
            return $this->redirectToRoute('app_auth');
        } else {
            $commentaire = new Commentaire();
            $form = $this->createForm(CommentaireType::class, $commentaire);
            $publications = $entityManager
                ->getRepository(Publication::class)
                ->findBy(['idUtilisateur'=>$id]);
            $utili=$entityManager->getRepository(Utilisateurs::class)->find($id);
            $commentaire = $entityManager
                ->getRepository(Commentaire::class)
                ->findBy(['idUtilisateur'=>$user]);
            $data = $paginator->paginate($publications,$request->query->getInt('page',1),4);
            return $this->render('profile/index.html.twig', [
                'controller_name' => 'ProfileController',
                'publications' => $data,
                'formC'=>$form->createView(),
                'commentaires' => $commentaire,
                'utili'=>$utili,
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getTypeUser(),
                'picture' => $user->getAvatar(),
                'user' => $user,
            ]);
        }
    }
}
