<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Utilisateurs;
use App\Entity\Message;
use App\Entity\CollabMembers;
use App\Entity\SalleCollaboration;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SalleCollabRepository;
use App\Repository\UtilisateursRepository;
use App\Repository\CollabMembersRepository;
use App\Repository\ProjetRepository;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Endroid\QrCode\Builder\BuilderInterface;
class SalleCollabController extends AbstractController
{
    /**
     * @Route("/sallecollab{collabn}", name="app_salle_collab")
     */
    public function index(
        $collabn,
        SessionInterface $session,
        UtilisateursRepository $s,
        Request $req,
        BuilderInterface $customQrCodeBuilder
    ): Response {
        $client = HttpClient::create();
        $regionName = '';
        $country = '';
        $flag = '';
        //api lkdim
        /*          $response = $client->request(
            'GET',
            'https://ip-geolocation-saifitools.p.rapidapi.com/geo',
            [
                // these values are automatically encoded before including them in the URL
                'headers' => [
                    'X-RapidAPI-Host' =>
                        'ip-geolocation-saifitools.p.rapidapi.com',
                    'X-RapidAPI-Key' =>
                        '219e7ed17cmsh763d3d5b14453f2p146e44jsnb9dcbbef176c',
                ],
            ]
        );
 foreach ($content as $k => $v) {
            if ($k == 'country') {
                $country = $v;
            }
            if ($k == 'regionName') {
                $regionName = $v;
            }
        }
 */

        //api el jdid
        $response = $client->request(
            'GET',
            'https://ip-geo-location.p.rapidapi.com/ip/check',
            [
                // these values are automatically encoded before including them in the URL
                'headers' => [
                    'X-RapidAPI-Host' => 'ip-geo-location.p.rapidapi.com',
                    'X-RapidAPI-Key' =>
                        '9a6b4bf20emshae5bd479784ca42p166566jsn7cc364986d30',
                ],
            ]
        );

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $country = $content['country']['name'];
        $flag = $content['country']['flag']['file'];

        $regionName = $content['area']['name'];

        $user1 = $session->get('userdata');
        if ($user1 == null) {
            return $this->redirectToRoute('app_auth');
        }
        $collab = new SalleCollaboration();
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($user1->getIdUtilisateur());
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->findBy(['nomCollab' => $collabn])[0];
        $Projet = new Projet();

        $Projet = $this->getDoctrine()
            ->getRepository(Projet::class)
            ->findOneBy(['idCollab' => $collab]);
        $idc = $collab->getIdCollab();
        $Notusers = $s->showCollabNotUsers($idc);
        $cunter = 1;
        $users = $s->showCollabUsers($collab->getIdCollab());
        return $this->render('salle_collab/index.html.twig', [
            'controller_name' => 'SalleCollabController',
            'collab' => $collab,
            'users' => $users,
            'projet' => $Projet,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
            'notUsers' => $Notusers,
            'projet' => $Projet,
            'userCunt' => $cunter,
            'regionName' => $regionName,
            'country' => $country,
            'flag' => $flag,
        ]);
    }
    /**
     * @Route("/deleteU/{id},{idu}", name="deleteU")
     */
    public function delete(
        $id,
        $idu,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s
    ) {
        $u = $s->findOneBy([
            'id_collab' => $idu,
            'ID_Utlisateur' => $id,
        ]);
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($id);

        $y = 0;
        //cookies
        $sujet = 'suppression terminée';
        $ssujet =
            'Vous avez retirer ' .
            $user->getPrenom() .
            ' ' .
            $user->getNom() .
            ' du votre collaboration';
        $naame = $sujet . ',' . $ssujet . ',' . $user->getAvatar();
        if (isset($_COOKIE['users'])) {
            $i = count($_COOKIE['users']);
            setcookie('users[' . $i . ']', $naame, time() + 3600, '/');
        } else {
            setcookie('users[' . $y . ']', $naame, time() + 3600, '/');
        }
        //cookies

        if ($u) {
            $entityManager->remove($u);
            $entityManager->flush();
        }
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idu);
        return $this->redirectToRoute('app_salle_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }

    /**
     * @Route("/delP/{id},{cid}", name="delP")
     */
    public function delP(
        $id,
        $cid,
        EntityManagerInterface $entityManager,
        ProjetRepository $s
    ) {
        $u = $s->findOneBy([
            'idProjet' => $id,
        ]);
        $y = 0;
        $sujet = 'Suppression terminée';
        $ssujet = 'Votre Projet ' . $u->getNomProjet() . ' est bien supprimer';
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
        if ($u) {
            $entityManager->remove($u);
            $entityManager->flush();
        }
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($cid);
        return $this->redirectToRoute('app_salle_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }

    /**
     * @Route("/addU{idu},{idc},", name="addU")
     */
    public function addU(
        $idu,
        $idc,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s,
        UtilisateursRepository $u
    ) {
        $y = 0;
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($idu);

        //cookies
        $sujet = 'Ajout terminée';
        $ssujet =
            'Vous avez ajouter ' .
            $user->getPrenom() .
            ' ' .
            $user->getNom() .
            ' a votre collaboration';
        $naame = $sujet . ',' . $ssujet . ',' . $user->getAvatar();
        if (isset($_COOKIE['users'])) {
            $i = count($_COOKIE['users']);
            setcookie('users[' . $i . ']', $naame, time() + 3600, '/');
        } else {
            setcookie('users[' . $y . ']', $naame, time() + 3600, '/');
        }
        //cookies

        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idc);

        $collab_member = new CollabMembers();
        $collab_member->setid_collab($collab->getIdCollab());
        $collab_member->setIdUtilisateur($user->getIdUtilisateur());
        $entityManager->persist($collab_member);
        $entityManager->flush();

        return $this->redirectToRoute('app_salle_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }

    /**
     * @Route("/Quitter/{id},{idu}", name="Quitter")
     */
    public function Quitter(
        $id,
        $idu,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s
    ) {
        $u = $s->findBy([
            'id_collab' => $idu,
            'ID_Utlisateur' => $id,
        ])[0];

        $entityManager->remove($u);
        $entityManager->flush();
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idu);
        return $this->redirectToRoute('app_list_collab', [
            'collabn' => $collab->getnomCollab(),
        ]);
    }

    /**
     * @Route("/createP{nom},{desc},{key},{token},{cid}", name="createP")
     */
    public function createP(
        $nom,
        $desc,
        $key,
        $token,
        $cid,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s,
        UtilisateursRepository $u
    ) {
        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($cid);

        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            'https://api.trello.com/1/boards/',
            [
                // these values are automatically encoded before including them in the URL
                'query' => [
                    'name' => $nom,
                    'key' => $key,
                    'token' => $token,
                ],
            ]
        );
        $statusCode = $response->getStatusCode();
        /*  $content = $response->toArray();
         $content = $response->getContent(); */
        $apierr = '';
        if ($statusCode == 401) {
            $apierr = 'Key ou token est non valid';
        } else {
            $content = $response->toArray();

            foreach ($content as $k => $v) {
                if ($k == 'shortUrl') {
                    $var = $v;
                }
            }
            $y = 0;
            $sujet = 'Creation terminée';
            $ssujet = 'Votre Projet ' . $nom . ' est bien crée';
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
            $Projet = new Projet();
            $Projet->setIdCollab($collab);
            $Projet->setNomProjet($nom);
            $Projet->setDescriptionProjet($desc);
            $Projet->setUrlTrello($var);
            $entityManager->persist($Projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_salle_collab', [
            'collabn' => $collab->getnomCollab(),
            'erreur' => $apierr,
        ]);
    }

    /**
     * @Route("/delall", name="delCookies")
     */
    public function delCookies(
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        if (isset($_COOKIE['users'])) {
            foreach ($_COOKIE['users'] as $name => $_val) {
                setcookie('users[' . $name . ']', '', time() + 3600, '/');
            }
        }

        return $this->redirectToRoute('app_list_collab');
    }

    /**
     * @Route("/msg/{idc}", name="loadmsg")
     */
    public function msg(
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s,
        UtilisateursRepository $u,
        SessionInterface $session,
        $idc
    ) {
        $Message = new Message();
        $Message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findBy([
                'idCollab' => $idc,
            ]);

        $user1 = $session->get('userdata');
        if ($user1 == null) {
            return $this->redirectToRoute('app_auth');
        }
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($user1->getIdUtilisateur());

        return $this->render('salle_collab/LoadM.html.twig', [
            'controller_name' => 'SalleCollabController',

            'userM' => $user,
            'MessageM' => $Message,
        ]);
    }

    /**
     * @Route("/addM{msg},{idc},{idu}", name="addM")
     */
    public function addM(
        $msg,
        $idc,
        $idu,
        EntityManagerInterface $entityManager,
        CollabMembersRepository $s,
        UtilisateursRepository $u
    ) {
        $user = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($idu);

        $collab = $this->getDoctrine()
            ->getRepository(SalleCollaboration::class)
            ->find($idc);
        $Message = new Message();
        $Message->setBody($msg);
        $Message->setIdUitlisateur($user);
        $Message->setIdCollab($collab);
        $entityManager->persist($Message);
        $entityManager->flush();

        return $this->redirectToRoute('loadmsg', ['idc' => $idc]);
    }
}
