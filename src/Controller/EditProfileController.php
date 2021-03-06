<?php

namespace App\Controller;

use App\Entity\Interets;
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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function index(Request $request,SessionInterface $session,EntityManagerInterface $entityManager,InteretsRepository $repo,UtilisateursRepository $userrepo,UserPasswordEncoderInterface $encoder): Response
    {
        $invalid_oldpw=false;
        $user=new Utilisateurs();
        $form=$this->createForm(EditProfileType::class,$user);
        $form2=$this->createForm(EditProfileType2::class,$user);
        $form->handleRequest($request);
        $user=$session->get('userdata');
        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        $user = $userrepo->find($user->getIdUtilisateur());
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // Form generale
         // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if ($form->isSubmitted() && $form->isValid()){
            
            $avatar=$form->get('avatar')->getData();
            // Verification de l'existance d'une image ?? t??l??charger
            if($avatar!==null){
                $image=$this->upload($avatar);
            }
            // Remplissage des champs
            $prenom=$form->get('prenom')->getData();
            $nom=$form->get('nom')->getData();
            $email=$form->get('email')->getData();
             $numtel=$form->get('full_number')->getData();
            // La modification dans la base de donn??es
            $user->setPrenom($prenom);
            $user->setNom($nom);
            $user->setEmail($email);
            $user->setFullNumber($numtel);
            if($avatar!==null){
                $user->setAvatar($image);
            }
            // La mise ?? jour de la session
            $session->set('userdata',$user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre profile a ??t?? bien modifi?? !');

      }
      // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      // Form mot de passes 
      // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $form2->handleRequest($request);
    if ($form2->isSubmitted() && $form2->isValid()){
        // Remplissage des champs
        $oldmdp=$form2->get('oldmdp')->getData();
        $mdp=$form2->get('mdp')->getData();
        $mdpconfirm=$form2->get('mdpconfirm')->getData();
        // La verification du mot de passe actuel
        $PasswordCheck=$encoder->isPasswordValid($user, $oldmdp);
        if ($PasswordCheck){
            $hash= $encoder->encodePassword($user,$mdp);
            $user->setmdp($hash);
            $session->set('userdata',$user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a ??t?? bien modifi?? !');
        }else{
            $invalid_oldpw=true;
        }
        
        // La mise ?? jour de la session
        // $session->set('userdata',$user);
        // $entityManager->flush();
  }
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      // Form des interets
      // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // Resolver les interets de l'utilisateur
        $interets=$repo->findBy(['idUtilisateur' => $user->getIdUtilisateur()]);
        $allinterets=["Sport","Voyage","Musique","Gaming","Animaux","Nature","Camping","Rencontres","Amour","Finance","Cryptomonnaie","Anime","Cartoons","Developpement","Travaille","Science","Astronomie","Clubs sociaux","Coiffure","Photographie","Politique","Fashing","P??che","Histoire","Peinture","Bricolage","Th????tre","Lecture","??criture","Jardinage","Langues ??trang??res","D??coration","Jardinage","Mecanique","Voiture","V??lo","Cuisine","Nourriture","Sant??","Informatique","Art oratoire","Peinture"];
        $myinterets=[];
        // Afficher seulement les interets disponibles 
        foreach($interets as $value){
            array_push($myinterets,$value->getnomInteret());
          }
        //   dd(array_diff($allinterets,$myinterets));
          $interets_dispo=array_diff($allinterets,$myinterets);
        
        


        if($user == null){
            return $this->redirectToRoute('app_auth');
        }
        else{
           
        return $this->render('edit_profile/index.html.twig', [
            'controller_name' => 'EditProfileController',

            'nom'=>$user->getNom(),
            'prenom'=>$user->getPrenom(),
            'email' => $user->getEmail(),
            'numtel' => $user->getFullNumber(),
            'role'=>$user->getTypeUser(),
            'picture'=>$user->getAvatar(),
            'interets' =>$interets,
            'general_form' => $form ->createView(),
            'pwd_form' => $form2 ->createView(),
            // 'img_form'=> $form3 ->createView()
            // 'pwd_form' => $form ->createView()
            'invalid_oldpw'=> $invalid_oldpw,
            'interets_dispo'=>$interets_dispo,
            'user'=>$user
            
        ]);
    }
}
/**
 * @Route("/edit/profile/add-interet/{values}", name="app_add_interet")
 */
public function AddInt($values,Request $request,SessionInterface $session,EntityManagerInterface $entityManager,UtilisateursRepository $userrepo): Response
{
    $selected_int=explode(',',$values);
    $user1 = $session->get('userdata');
    $user = $userrepo->find($user1->getIdUtilisateur());
    for ($i = 0; $i < count($selected_int); $i++) {
        $interet=new Interets();
        $interet->setNomInteret($selected_int[$i]);
        $interet->setIdUtilisateur($user);
        $entityManager->persist($interet);
        $entityManager->flush();
        $this->addFlash('success', 'Vos interets ont ??t?? bien ajout??s !');

    }
    return $this->redirectToRoute('app_edit_profile');

    
// dd();
}

    /**
     * @Route("/edit/profile/delete_interet/{id}", name="delete_interet")
     */
    public function delete_interet(
        $id,
        EntityManagerInterface $em,
        InteretsRepository $inrep
    ) {
        $u = $inrep->findOneBy([
            'idInteret' => $id,
        ]);
        
    
        if ($u) {
            $em->remove($u);
            $em->flush();
        }
        $this->addFlash('success', 'Vos interets ont ??t?? bien supprim?? !');

        return $this->redirectToRoute('app_edit_profile', [
        ]);
    }
    //////////////////////////// MOBILE API /////////////////////////////////////
     /**
     * @Route("api/users/edit", name="app_mobile_edit", methods={"POST","GET"})
     */
    public function MobileEditUser(Request $request, EntityManagerInterface $em,NormalizerInterface $normalizable,UtilisateursRepository $userrepo): Response
    {
    // Remplissage des champs
    $user = $userrepo->findOneBy(['email' => $request->get('email')]);
    $user->setNom($request->get('nom'));
    $user->setPrenom($request->get('prenom'));
    $user->setEmail($request->get('email'));
    $user->setFullNumber($request->get('full_number'));
    $user->setGenre($request->get('genre'));
    $date = $request->get('datenaissance');
    $formatedate = date("m/d/Y", strtotime($date));
    $user->setDB($formatedate);
    // La mise ?? jour de la session
    $em->flush();
    $jsonContent=$normalizable->normalize($edited,'json',['groups'=>'EditMobile']);
    return new Response(json_encode($jsonContent));
}

 /**
     * @Route("api/users/edit/passwordcheck", name="app_mobile_pwcheck", methods={"POST","GET"})
     */
    public function MobileVerifyPassword(Request $request, EntityManagerInterface $em,NormalizerInterface $normalizable,UtilisateursRepository $userrepo,UserPasswordEncoderInterface $encoder): Response
    {
$user = $userrepo->findOneBy(['email' => $request->get('email')]);
$PasswordCheck=$encoder->isPasswordValid($user, $request->get('mdp'));
if ($PasswordCheck){
    $valid=true;
}else{
    $valid=false;
}
$jsonContent=$normalizable->normalize($valid,'json',['groups'=>'EditMobileVerifyPw']);
return new Response(json_encode($jsonContent));
}
}
