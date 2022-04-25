<?php

namespace App\Controller;
use App\Entity\Utilisateurs;
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
     * @Route("/create/room", name="app_salle_cinema_room", methods={"GET"})
     */
    public function createRoom(Request $request){
        $share=$request->query->get('share');
        $result=json_decode($this->getRoom($share,'share'),true);
        echo 'https://w2g.tv/rooms/'.$result['streamkey'];
        return $this->json('hallo');
    }
    /**
     * @Route("/list/{event}", name="app_salle_cinema_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Evenement $event,Request $request): Response
    {
        $user=$request->getSession()->get('userdata');
        $salleCinemas = $entityManager
            ->getRepository(SalleCinema::class)
            ->findOneBy([
                'ID_Event'=>$event->getId()
            ]);
           $date=explode('/',$salleCinemas->getIdEvent()->getDateEvent());
        return $this->render('salle_cinema/index.html.twig', [
            'salle_cinemas' =>array($salleCinemas) ,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
            'evenement'=>new \DateTime($date[2].'-'.$date[1].'-'.$date[0]),
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
                     ->setUrlSalle("");
        $form = $this->createForm(SalleCinemaType::class, $salleCinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result=json_decode($this->getRoom($salleCinema->getUrlFilm(),'share'),true);
            $salle='https://w2g.tv/rooms/'.$result['streamkey'];
            $salleCinema->setUrlSalle($salle);
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
    private function getRoom($share,$type)
    {
        $url='https://w2g.tv/rooms/create.json';
        $headers=array(
            'Accept: application/json',
            'Content-Type: application/json',
            'charset: utf-8'
        );
        $key='3fqimojunmdvza30y3ve1numvukr7ivhe2t5pc7j76h29o7xr1aoqi432fus7fgm';
        $data=array(
            "w2g_api_key"=>$key,
            "share"=>$share,
            "bg_color"=> "#008080",
            "bg_opacity"=> "50"
        );
        $data=json_encode($data);
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
