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
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
        $user = $session->get('userdata');
        if ($user == null) {
            return $this->redirectToRoute('app_auth');
        }
        $collab = new SalleCollaboration();
        $form = $this->createForm(CollabType::class, $collab);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $collab->setNomCollab($form->get('nomCollab')->getData());
            $usercollab = $this->getDoctrine()
                ->getRepository(Utilisateurs::class)
                ->find($user->getIdUtilisateur());
            $collab->setIdUtilisateur($usercollab);

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
            $y = 0;
            $sujet = 'Creation terminée';
            $ssujet =
                'Votre collaboration ' .
                $collab->getNomCollab() .
                ' est bien crée';
            $naame =
                $sujet .
                ',' .
                $ssujet .
                ',' .
                'https://res.cloudinary.com/dnnhnqiym/image/upload/v1650481316/wazzup_we8kld.png';
            if (isset($_COOKIE['system'])) {
                $i = count($_COOKIE['system']);
                setcookie('system[' . $i . ']', $naame, time() + 3600, '/');
            } else {
                setcookie('system[' . $y . ']', $naame, time() + 3600, '/');
            }
            return $this->redirect($request->getUri());
        }
        return $this->render('collab/index.html.twig', [
            'controller_name' => 'CollabController',
            'collab_form' => $form->createView(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
        ]);
    }
}
