<?php

namespace App\Controller;

use Cloudinary\Cloudinary;
use App\Entity\Utilisateurs;
use App\Form\EditProfileType;
use App\Form\EditProfileType2;
use App\Repository\InteretsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProfileController extends AbstractController
{
    /**
     * @Route("/edit/profile/upload", name="upload_img")
     */
    public function upload($url)
    {
      
        // // dd(str_replace("&U+002347;","/",$url));
        //  $url=str_replace("&U+002347;","/",$url);
                  $cld = new Cloudinary([
                    'cloud' => [
                        'cloud_name'    => 'dpebiizpe',
                        'api_key'       => '663388437531215',
                        'api_secret'    => 't9H2L_TCWMy-oqPxSKLtnIjxuL4'
                    ],  
                    'url' => [
                        'secure' => true 
                    ]   
                ]);
        $res = $cld->uploadApi()->upload(
            $url
        );
        // dd(gettype($res['secure_url']));
            return $res['secure_url'];

}
       /**
     * @Route("/edit/profile/", name="app_edit_profile")
     */
    public function index(ValidatorInterface $validator,Request $request,SessionInterface $session,EntityManagerInterface $entityManager,InteretsRepository $repo,UtilisateursRepository $userrepo): Response
    {
        $user=new Utilisateurs();
        $errors = $validator->validate($user);
        $form=$this->createForm(EditProfileType::class,$user);
        $form2=$this->createForm(EditProfileType2::class,$user);
        $form->handleRequest($request);
        $user=$session->get('userdata');
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        $user = $userrepo->find($user->getIdUtilisateur());
        
        if ($form->isSubmitted() && $form->isValid()){
            
            $avatar=$form->get('avatar')->getData();
            // Verification de l'existance d'une image à télécharger
            if($avatar!==null){
                $image=$this->upload($avatar);
            }
            // Remplissage des champs
            $prenom=$form->get('prenom')->getData();
            $nom=$form->get('nom')->getData();
            $email=$form->get('email')->getData();
            $numtel=$form->get('numTel')->getData();
            // La modification dans la base de données
            $user->setPrenom($prenom);
            $user->setNom($nom);
            $user->setEmail($email);
            $user->setNumTel($numtel);
            if($avatar!==null){
                $user->setAvatar($image);
            }
            // La mise à jour de la session
            $session->set('userdata',$user);
            $entityManager->flush();
      }
    $form2->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
            
        $pwd=$form->get('avatar')->getData();
        // Remplissage des champs
        $oldmdp=$form->get('oldmdp')->getData();
        $mdp=$form->get('mdp')->getData();
        $mdpconfirm=$form->get('mdpconfirm')->getData();
        // La verification du mot de passe actuel
        

        // La modification dans la base de données
        $user->setPrenom($prenom);
        $user->setNom($nom);
        $user->setEmail($email);
        $user->setNumTel($numtel);
        if($avatar!==null){
            $user->setAvatar($image);
        }
        // La mise à jour de la session
        $session->set('userdata',$user);
        $entityManager->flush();
  }
        
        $interets=$repo->findBy(['idUtilisateur' => 58]);
        // dd($interets);
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        else{
           
        return $this->render('edit_profile/index.html.twig', [
            'controller_name' => 'EditProfileController',
            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'email' => $user->getEmail(),
            'numtel' => $user->getNumTel(),
            'role'=>$user->getTypeUser(),
            'picture'=>$user->getAvatar(),
            'interets' =>$interets,
            'general_form' => $form ->createView(),
            'pwd_form' => $form2 ->createView(),
            'errors' => $errors,
            // 'img_form'=> $form3 ->createView()
            // 'pwd_form' => $form ->createView()
            
            
        ]);
    }
}
}
