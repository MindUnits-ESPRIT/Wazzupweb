<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Utilisateurs;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }



    /**
     * @Route("/{idCommentaire}", name="app_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{idCommentaire}/edit", name="app_commentaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->add($commentaire);
            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommentaire}", name="app_commentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $commentaireRepository->remove($commentaire);
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/new/{Pid}", name="app_commentaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CommentaireRepository $commentaireRepository,SessionInterface $session,EntityManagerInterface $entityManager,$Pid): Response
    {
        $user = $session->get('userdata');
        $commentaire = new Commentaire();
//        $form = $this->createForm(CommentaireType::class, $commentaire);
//        $form->handleRequest($request);

        $userr = $entityManager
            ->getRepository(Utilisateurs::class)
            ->find($user);
        $pub=$entityManager->getRepository(Publication::class)->find($Pid);
        $commentaire->setIdUtilisateur($userr);
        $commentaire->setIdPublication($pub);
        $stC="commentaire".$Pid;
        $comment=$request->request->get($stC);
        $commentaire->setMessage($comment);
        $commentaire->setDate((new \DateTime('now')));
        $commentaireRepository->add($commentaire);
        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/delete/{idCommentaire}", name="Remove_Commentaire")
     */
    public function Remove($idCommentaire,EntityManagerInterface $em, CommentaireRepository $commentaireRepository): Response
    {
        $em->remove($commentaireRepository->findOneBy(['idCommentaire'=>$idCommentaire]));
        $em->flush();
        return $this->redirectToRoute('app_publication_index');
    }
}
