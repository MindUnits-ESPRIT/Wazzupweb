<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Entity\Publication;
use App\Entity\Utilisateurs;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="app_publication_index", methods={"GET"})
     */
    public function index(Request $request,SessionInterface $session,EntityManagerInterface $entityManager, PaginatorInterface $paginator,NormalizerInterface $Normalizer): Response
    {
        $user = $session->get('userdata');
        if ($user == null) {
            return $this->redirectToRoute('app_auth');
        } else {
            //EDITED HERE
//            $commentaire = new Commentaire();
//            $form = $this->createForm(CommentaireType::class, $commentaire);
            $publications = $entityManager
                ->getRepository(Publication::class)
                ->findBy(['visibilite'=>'True'],['datePublication'=>'DESC']);
            $users = $entityManager
                ->getRepository(Utilisateurs::class)
                ->findBy(array(), null, 5);
            $commentaire = $entityManager
                ->getRepository(Commentaire::class)
                ->findAll();
            $eventFace2Face=$this->getDoctrine()->getRepository(Evenement::class)
                ->findBy(['typeEvent'=>'Rencontre','eventVisibilite'=>'Salle_publique'],['dateP'=>'DESC'],5);
            $eventCinema=$this->getDoctrine()->getRepository(Evenement::class)
                ->findBy(['typeEvent'=>'SalleCinema','eventVisibilite'=>'Salle_publique'],['dateP'=>'DESC'],5);
            $data = $paginator->paginate($publications,$request->query->getInt('page',1),
                4);
            $jsonContent = $Normalizer->normalize($publications,'json',['groups'=>'post:read']);
            return $this->render('publication/index.html.twig', [
                'publications' => $data,
                'commentaires' => $commentaire,
                'utilisateurs' => $users,
//                'formC'=>$form->createView(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getTypeUser(),
                'picture' => $user->getAvatar(),
                'user' => $user,
                'eventFace2Face'=>$eventFace2Face,
                'eventCinema'=>$eventCinema
            ]);
        }
    }
    /**
     * @Route("/new", name="app_publication_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setDatePublication((new \DateTime('now')));
            $publication->setVisibilite("True");
            $publication->setPriority(1);
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newpost", name="app_publication_newpost", methods={"GET", "POST"})
     */
    public function newpost(Request $request, EntityManagerInterface $entityManager,SessionInterface $session ): Response
    {
        $user = $session->get('userdata');
        $publication = new Publication();
        $publication->setDatePublication((new \DateTime('now')));
        $publication->setVisibilite("True");
        $publication->setPriority(1);
        $userr = $entityManager
            ->getRepository(Utilisateurs::class)
            ->find($user);

        $publication->setIdUtilisateur($userr);

        $desc=$request->request->get("description");
        $img=$request->files->get("publication")['imageFile'];
        //  dd($img);
        if (strlen($desc)>0)
            $publication->setDescription($desc);
        else
            $publication->setDescription("ERROR FILLED BADLY");
        if($img != null)
            $publication->setImageFile($request->files->get("publication")['imageFile']);
        else if (str_contains($request->request->get("publication")['fichier'],'.gif'))
            $publication->setFichier($request->request->get("publication")['fichier']);
        else
            $publication->setFichier("NULL");
        $entityManager->persist($publication);
        $entityManager->flush();

        return $this->redirectToRoute('app_publication_index');

    }
//    /**
//     * @Route("/{idPublication}", name="app_publication_show", methods={"GET"})
//     */
//    public function show(Publication $publication): Response
//    {
//        return $this->render('publication/show.html.twig', [
//            'publication' => $publication,
//        ]);
//    }

    /**
     * @Route("/{idPublication}/edit", name="app_publication_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{idPublication}/editL", name="app_publication_editL", methods={"GET"})
     */
    public function LoadForm(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        //$form->handleRequest($request);
        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{idPublication}/editLE", name="app_publication_editLE", methods={"POST"})
     */
    public function LoadForme(Request $request, Publication $publication,SessionInterface $session ,EntityManagerInterface $entityManager): Response
    {
        $user = $session->get('userdata');
        $pub=new Publication();
        $publication->setDescription($request->request->get("publication")['description']);
        $publication->setImageFile($request->files->get("publication")['imageFile']);
//        $pub->setVisibilite("True");
        $userr = $entityManager
            ->getRepository(Utilisateurs::class)
            ->find($user);
        $publication->setIdUtilisateur($userr);
        $publication->setDatePublication((new \DateTime('now')));
        $entityManager->flush();
        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }
//    /**
//     * @Route("/{idPublication}", name="app_publication_delete", methods={"POST"})
//     */
//    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$publication->getIdPublication(), $request->request->get('_token'))) {
//            $entityManager->remove($publication);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
//    }

    /**
     * @Route("/delete/{id}", name="app_publication_delete")
     */
    public function delete($id,EntityManagerInterface $em,PublicationRepository $rep){
        $em->remove($rep->find($id));
        $em->flush();
        return $this->redirectToRoute('app_publication_index');
    }

    /**
     * @Route("/listContent", name="app_publication_listContent")
     */
    public function listContent(Request $request,SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        $user = $session->get('userdata');
        if ($user == null) {
            return $this->redirectToRoute('app_auth');
        } else {
//            $commentaire = new Commentaire();
//            $form = $this->createForm(CommentaireType::class, $commentaire);
            $publications = $entityManager
                ->getRepository(Publication::class)
                ->findBy(['visibilite'=>'True'],['datePublication'=>'DESC']);

            return $this->render('publication/showContent.html.twig', [
//                'formC'=>$form->createView(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getTypeUser(),
                'picture' => $user->getAvatar(),
                'user' => $user,
                'publication'=>$publications,
            ]);
        }
    }

    /**
     * @Route("/searchby", name="searchby")
     */
    public function users( Request $request,EntityManagerInterface $entityManager): Response
    {
        $str=$request->query->get('SearchField');
        $utilisateurs = $entityManager
            ->createQuery(
                'SELECT p
                FROM App\Entity\Utilisateurs p
                WHERE p.nom LIKE :str 
                OR p.prenom LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
        return $this->render('publication/searchby.html.twig', [
            'utilisateurs'=>$utilisateurs
        ]);
    }
    /**
     * @Route("/Mob", name="app_publication_indexMob", methods={"GET", "POST"})
     */
    public function indexMob(Request $request,SessionInterface $session,EntityManagerInterface $entityManager, PaginatorInterface $paginator,NormalizerInterface $Normalizer): Response
    {

//            $commentaire = new Commentaire();
//            $form = $this->createForm(CommentaireType::class, $commentaire);
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findBy(['visibilite'=>'True'],['datePublication'=>'DESC']);
        $users = $entityManager
            ->getRepository(Utilisateurs::class)
            ->findBy(array(), null, 5);
        $commentaire = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();
        $eventFace2Face=$this->getDoctrine()->getRepository(Evenement::class)
            ->findBy(['typeEvent'=>'Rencontre','eventVisibilite'=>'Salle_publique'],['dateP'=>'DESC'],5);
        $eventCinema=$this->getDoctrine()->getRepository(Evenement::class)
            ->findBy(['typeEvent'=>'SalleCinema','eventVisibilite'=>'Salle_publique'],['dateP'=>'DESC'],5);
        $data = $paginator->paginate($publications,$request->query->getInt('page',1),
            4);
        $jsonContent = $Normalizer->normalize($publications,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
        // }
    }

    /**
     * @Route("/deleteMob/{id}", name="app_publication_deletee" , methods={"GET", "POST"})
     */
    public function deletee($id,EntityManagerInterface $em,PublicationRepository $rep,NormalizerInterface $Normalizer):Response{
        $pub=$rep->find($id);

        $em->remove($pub);
        $em->flush();
        $jsonContent=$Normalizer->normalize($pub,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/LoadPub/{id}", name="MobPubLoad", methods={"GET", "POST"})
     */
    public function LoadPub($id,Request $request, Publication $publication, EntityManagerInterface $entityManager,NormalizerInterface $Normalizer): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findBy(['idPublication'=>$id]);
        $jsonContent = $Normalizer->normalize($publications,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/{idPublication}/editLEMob/{userid}", name="app_publication_editLEMob", methods={"POST","GET"})
     */
    public function LoadFormeMob(Request $request,$userid, Publication $publication,SessionInterface $session ,EntityManagerInterface $entityManager,NormalizerInterface $Normalizer): Response
    {
        //   $user = $session->get('userdata');
        $pub=new Publication();

        $publication->setDescription($request->query->get("description"));
        $publication->setFichier($request->query->get("imageFile"));
        $pub->setVisibilite("True");
        $userr = $entityManager
            ->getRepository(Utilisateurs::class)
            ->find($userid);
        $publication->setIdUtilisateur($userr);
        $publication->setDatePublication((new \DateTime('now')));
        //    dd($publication);
        $entityManager->flush();
        $jsonContent = $Normalizer->normalize($publication,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/AddMob/{userid}", name="app_publication_AddMob", methods={"POST","GET"})
     */
    public function AddMobb(Request $request,$userid,SessionInterface $session ,EntityManagerInterface $entityManager,NormalizerInterface $Normalizer): Response
    {
        $user = $session->get('userdata');
        $publication = new Publication();
        $publication->setDatePublication((new \DateTime('now')));
        $publication->setVisibilite("True");
        $publication->setPriority(1);
        $userr = $entityManager
            ->getRepository(Utilisateurs::class)
            ->find($userid);
        $publication->setIdUtilisateur($userr);

        $publication->setDescription($request->query->get("description"));
        $publication->setFichier($request->query->get("imageFile"));
        $entityManager->persist($publication);
        $entityManager->flush();

        $jsonContent = $Normalizer->normalize($publication,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
}
