<?php

namespace App\Controller;

use App\Entity\SalleCinema;
use App\Entity\Evenement;
use App\Form\SalleCinemaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salle/cinema")
 */
class SalleCinemaController extends AbstractController
{
    /**
     * @Route("/list/{event}", name="app_salle_cinema_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Evenement $event,Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        $salleCinemas = $entityManager
            ->getRepository(SalleCinema::class)
            ->findBy([
                'ID_Event'=>$event->getId()
            ]);

        return $this->render('salle_cinema/index.html.twig', [
            'salle_cinemas' => $salleCinemas,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/new", name="app_salle_cinema_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        $salleCinema = new SalleCinema();
        $event=$entityManager->getRepository(Evenement::class)->find($request->query->get('evenement'));
        $salleCinema->setIdEvent($event)
                     ->setChat("")
                     ->setUrlSalle("")
                     ->setUrlFilm("");
        $form = $this->createForm(SalleCinemaType::class, $salleCinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salleCinema);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', ['user'=> $request->query->get('user')], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salle_cinema/new.html.twig', [
            'salle_cinema' => $salleCinema,
            'form' => $form->createView(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{idSalle}", name="app_salle_cinema_show", methods={"GET"})
     */
    public function show(SalleCinema $salleCinema,Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        return $this->render('salle_cinema/show.html.twig', [
            'salle_cinema' => $salleCinema,
            'event'=>$salleCinema->getIdEvent()->getId(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{idSalle}/edit", name="app_salle_cinema_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SalleCinema $salleCinema, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        $form = $this->createForm(SalleCinemaType::class, $salleCinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', ['user'=>$user->getIdUtilisateur()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salle_cinema/edit.html.twig', [
            'salle_cinema' => $salleCinema,
            'event'=>$salleCinema->getIdEvent()->getId(),
            'form' => $form->createView(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/delete/{idSalle}", name="app_salle_cinema_delete", methods={"POST"})
     */
    public function delete(Request $request, SalleCinema $salleCinema, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        if ($this->isCsrfTokenValid('delete'.$salleCinema->getIdSalle(), $request->request->get('_token'))) {
            $event=$salleCinema->getIdEvent();
            $entityManager->remove($event);
            $entityManager->remove($salleCinema);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', ['user'=>$user->getIdUtilisateur()
        //$this->getUser()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
