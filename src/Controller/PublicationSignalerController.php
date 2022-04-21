<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\PublicationSignaler;
use App\Entity\Utilisateurs;
use App\Form\PublicationSignalerType;
use App\Repository\PublicationSignalerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publication/signaler")
 */
class PublicationSignalerController extends AbstractController
{
    /**
     * @Route("/", name="app_publication_signaler_index", methods={"GET"})
     */
    public function index(PublicationSignalerRepository $publicationSignalerRepository): Response
    {
        return $this->render('publication_signaler/index.html.twig', [
            'publication_signalers' => $publicationSignalerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{idP}/{typeS}", name="app_publication_signaler_new", methods={"GET", "POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager,$idP,$typeS): Response
    {
        $publicationSignaler = new PublicationSignaler();
//        $form = $this->createForm(PublicationSignalerType::class, $publicationSignaler);
//        $form->handleRequest($request);
        $user=$this->getDoctrine()->getRepository(Utilisateurs::class)->find(58);
        $pub=$this->getDoctrine()->getRepository(Publication::class)->find($idP);
//        if ($form->isSubmitted() && $form->isValid()) {
            $publicationSignaler->setIdUtilisateur($user);
            $publicationSignaler->setIdPublication($pub);
            $publicationSignaler->setType("$typeS");
            $publicationSignaler->setDate((new \DateTime('now')));
            $entityManager->persist($publicationSignaler);
            $entityManager->flush();
            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
//        }
//        return $this->render('publication_signaler/new.html.twig', [
//            'publication_signaler' => $publicationSignaler,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{idSignaler}", name="app_publication_signaler_show", methods={"GET"})
     */
    public function show(PublicationSignaler $publicationSignaler): Response
    {
        return $this->render('publication_signaler/show.html.twig', [
            'publication_signaler' => $publicationSignaler,
        ]);
    }

    /**
     * @Route("/{idSignaler}/edit", name="app_publication_signaler_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PublicationSignaler $publicationSignaler, PublicationSignalerRepository $publicationSignalerRepository): Response
    {
        $form = $this->createForm(PublicationSignalerType::class, $publicationSignaler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationSignalerRepository->add($publicationSignaler);
            return $this->redirectToRoute('app_publication_signaler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication_signaler/edit.html.twig', [
            'publication_signaler' => $publicationSignaler,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSignaler}", name="app_publication_signaler_delete", methods={"POST"})
     */
    public function delete(Request $request, PublicationSignaler $publicationSignaler, PublicationSignalerRepository $publicationSignalerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicationSignaler->getIdSignaler(), $request->request->get('_token'))) {
            $publicationSignalerRepository->remove($publicationSignaler);
        }

        return $this->redirectToRoute('app_publication_signaler_index', [], Response::HTTP_SEE_OTHER);
    }
}
