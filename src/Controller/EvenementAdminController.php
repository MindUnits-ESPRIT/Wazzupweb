<?php

namespace App\Controller;
use App\Entity\SalleCinema;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormilzerInterface;

class EvenementAdminController extends AbstractController
{
    /**
     * @Route("/evenement/admin", name="app_evenement_admin")
     */
    public function index(Request $request,EvenementRepository $ev): Response
    {
        $data_salle=array();
        $event = new Evenement();
        $em=$this->getDoctrine()->getManager();
        $events = $ev->findAll();
        $user=$request->getSession()->get('userdata');
//        if ($user == null || $user->getTypeUser() == 'User') {
//            return $this->redirectToRoute('app_auth');
//        }
        return $this->render('evenement_admin/index.html.twig', [
            'controller_name' => 'EvenementAdminController',
            'data_salle'=>$data_salle,
            'evenements' => $events,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }
    /**
     * @Route("/evenement/mobile", name="app_evenement_JSON")
     */
    public function Afficher_mobile(Request $request,EvenementRepository $ev,NormalizerInterface $Normalizer): Response
    {
        $data_salle=array();
        $event = new Evenement();
        $em=$this->getDoctrine()->getManager();
        $events = $ev->findAll();
        $user=$request->getSession()->get('userdata');
//        if ($user == null || $user->getTypeUser() == 'User') {
//            return $this->redirectToRoute('app_auth');
//        }
        $jsonContent = $Normalizer->normalize($events,'json',['groups'=>'post:read']);
//        return $this->render('evenement/Afficher_mobileJSON.html.twig', [
//            'data'=>$jsonContent,
//            'controller_name' => 'EvenementAdminController',
//            'data_salle'=>$data_salle,
//            'evenements' => $events,
//            'nom'=>$user->getNom(),
//            'prenom'=>$user->getPrenom(),
//            'role'=>$user->getTypeUser(),
//            'picture'=>'',
//            'user'=>$user,
//        ]);
        return new Response(json_encode($jsonContent));
    }
}
