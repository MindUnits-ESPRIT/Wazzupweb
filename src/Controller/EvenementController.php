<?php

namespace App\Controller;
use App\Repository\EvenementRepository;
use App\Entity\Evenement;
use App\Entity\Rencontre;
use App\Entity\SalleCinema;
use App\Entity\Utilisateurs;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/list/json/{user}", name="app_evenement_json", methods={"GET"})
     */
   public function index_json(EntityManagerInterface $entityManager, Utilisateurs $user, PaginatorInterface $paginator,Request $request,NormalizerInterface $Normalizer): Response
   {
       $evenements = $entityManager
        ->getRepository(Evenement::class)
        ->findby([
            'idUtilisateur' => $user->getIdUtilisateur()],
            ['dateEvent' => 'DESC']

        );
       $jsonContent = $Normalizer->normalize($evenements,'json',['groups'=>'post:read']);
       return new Response(json_encode($jsonContent));
   }
    /**
     * @Route("/eventlist/Json/{user}", name="app_evenement_list_calendar_data")
     */
    public function data(EvenementRepository $ev, Utilisateurs $user){
        $events = $ev
            ->findby([
                'idUtilisateur'=> $user->getIdUtilisateur()
            ]);
        $result=array();
        foreach ($events as $event ){
            $date=explode('/',$event->getDateEvent());
            $result[] = array(
//                'id' => $event->getId(),
                'title' => $event->getNomEvent(),
                'start' => $date[2] . '-' . $date[1] . '-' . $date[0],
                'url'=>$this->generateUrl('app_evenement_show',['id'=>$event->getId(),UrlGeneratorInterface::ABSOLUTE_URL])
            );
        }
        return $this->json($result);
    }
    /**
     * @Route("/eventlist/{user}", name="app_evenement_list_calendar")
     */
    public function calendar(Utilisateurs $user)
    {
        return $this->render('evenement/calendar.html.twig',[
            'user'=>$user->getIdUtilisateur()
        ]);
    }
    /**
     * @Route("/list/{user}", name="app_evenement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Utilisateurs $user, PaginatorInterface $paginator,Request $request): Response
    {

        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findby([
                'idUtilisateur'=> $user->getIdUtilisateur()],
                ['dateEvent'=>'DESC']

            );
        $evenements = $paginator->paginate(
            $evenements, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2 // Nombre de résultats par page
        );
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/new", name="app_evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setDateP(new \DateTime())
                      ->setIdUtilisateur(
                          $entityManager->getRepository(Utilisateurs::class)->find($user->getIdUtilisateur())
                      );
            $entityManager->persist($evenement);
            $entityManager->flush(); 
            if($evenement->getTypeEvent()=="Rencontre")
            return $this->redirectToRoute('app_rencontre_new', ['evenement'=>$evenement->getId(),'user'=>$user->getIdUtilisateur()], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_salle_cinema_new', ['evenement'=>$evenement->getId(),'user'=>$user->getIdUtilisateur()
            //$this->getUser()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement,Request $request): Response
    { $user=$request->getSession()->get('userdata');

        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', ['user'=>$user->getIdUtilisateur()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(), // a supprimer in the future
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'role'=>$user->getTypeUser(),
            'picture'=>'',
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{evenement}/delete", name="app_evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $user=$request->getSession()->get('userdata');
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $salles=$entityManager->getRepository(SalleCinema::class)->findBy(['ID_Event'=> $evenement->getId()]);
            $rencontres=$entityManager->getRepository(Rencontre::class)->findBy(['ID_Event'=> $evenement->getId()]);
            foreach ($salles as $salle) {

                $entityManager->remove($salle);
                $entityManager->flush();
            }
            foreach ($rencontres as $rencontre){
                $entityManager->remove($rencontre);
                $entityManager->flush();
            }
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', ['user'=>$user->getIdUtilisateur()
        //$this->getUser()->getId()
        ], Response::HTTP_SEE_OTHER);
    }



}
