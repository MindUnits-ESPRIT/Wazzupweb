<?php

namespace App\Controller;
use App\Form\SignupType;

use Cloudinary\Cloudinary;
use App\Entity\Utilisateurs;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateursRepository;
use Cloudinary\Configuration\Configuration;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class SignupController extends AbstractController
{

    /**
     * @Route("/signup", name="app_signup", methods={"GET", "POST"})
     */
    public function signup(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder, MailerInterface $mailer): Response
    {
        //api el jdid
        $client = HttpClient::create();
          $response = $client->request(
            'GET',
            'https://ipinfo.io/json?token=8b5522417ef455'
        );

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();
        $country = $content['country'];
        $user=new Utilisateurs();
        $datevalide=false;
        $form=$this->createForm(SignupType::class,$user);
        $form->handleRequest($request);
        
        

        // dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $db=$form->get('datenaissance')->getData();
            // $num=$form->get('full_number')->getData();
            // dd($num);
            $dbyear=$db->format('Y');
            $datevalide=$this->VerifierDatenaissance($dbyear);
            // dd($datevalide);
            if($datevalide==false){
                return $this->redirectToRoute('app_signup',['dbvalid' =>$datevalide]);
            } 
            
            else{
             $hash= $encoder->encodePassword($user,$user->getMdp());
             $user->setmdp($hash);
             // Generation du token 
             $user->setToken(sha1(uniqid()));
             $user->setActivated(false);
             
             dd($user);
            $entityManager->persist($user);
            $entityManager->flush();
            // L'envoi de token
            $email = (new TemplatedEmail())
            ->from(new Address('wazzupverif@gmail.com','Wazzup'))
            ->to($user->getEmail())
            ->subject("Activation du compte Wazzup")
           ->htmlTemplate('Mail_templates/token.html.twig')
            ->context([
            'nom' => $user->getNom(),
            'type' => 'Votre token d\'activation',
            'token'=> $user->getToken(),
            'code' =>$user->getToken(),
            'content'=>'Nous sommes heureux que vous ayez rejoint notre communauté . Il vous suffit de confirmer votre inscription à l\'aide du code ci-dessous.'
        ])
;
      $mailer->send($email);
            return $this->redirectToRoute('registration-success',
            ['email' => $user->getEmail()]
            
        );  
        }
    }
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
            'signup_form' => $form ->createView(),
            'datevalide'=>$datevalide,
            'country'=>$country,
            
        ]);
    
    }
public function VerifierDatenaissance($db){
    $dbvalid=false;
   if($db >'2004'){
    $dbvalid=false;
   }
   else $dbvalid=true;
   return  $dbvalid;
}

/**
 * @Route("/activation/{token}",name="activation")
 */
public function activation($token , UtilisateursRepository $userrepo,EntityManagerInterface $em,MailerInterface $mailer){
  //Verification de la possession du token
  $user=$userrepo->findOneBy(['token'=>$token]);
  
  if(!$user){
      // 404
      return $this->redirectToRoute('app_error');
    }
  //Succés d'activation
        // L'envoi d'un mail de confirmation
        $email = (new TemplatedEmail())
        ->from(new Address('wazzupverif@gmail.com','Wazzup'))
        ->to($user->getEmail())
        ->subject("Votre compte a été activé")
        ->htmlTemplate('Mail_templates/verified.html.twig')
        ->context([
        'nom' => $user->getNom(),
    ])
  ;
        $mailer->send($email);
  // si le token trouvé on supprime le token
  $user->setToken(null);
  $user->setActivated(true);
  $em->persist($user);
  $em->flush();
  // Notification
   $this->addFlash(
      'message',
      'Vous avez bien activé votre compte !'
    );
    

  return $this->redirectToRoute('activation-success',['user' => $user->getEmail()]);

}
/**
 * @Route("/thanks/{email}",name="registration-success")
 */
public function thanksforRegistration(){
    return $this->render('signup/thanks.html.twig', [
        'controller_name' => 'SignupController',
    ]);
}
 // ACTIVATION ROUTES 
/**
 * @Route("/activated",name="activation-success")
 */
public function activationSuccess(){
    return $this->render('activation/activated.html.twig', [
        'controller_name' => 'SignupController',
    ]);
}



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// Mobile API /////////////////////////////////////////////
    /// Registration // 
    /**
     * @Route("api/users/signup", name="app_mobilereg", methods={"POST"})
     */
    public function MobileSignup(Request $request, EntityManagerInterface $em,NormalizerInterface $normalizable,UserPasswordEncoderInterface $encoder, MailerInterface $mailer): Response
    {
        $user=new Utilisateurs();
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setEmail($request->get('email'));
        $user->setGenre($request->get('genre'));

        $date = $request->get('datenaissance');
        $formatedate = date("m/d/Y", strtotime($date));
        $user->setDB($formatedate);
         
        $user->setFullNumber($request->get('full_number'));
        $hash= $encoder->encodePassword($user,$request->get('mdp'));
        $user->setPassword($hash);
        // Generation du token 
        $user->setToken(sha1(uniqid()));
        $user->setActivated(false);
        $em->persist($user);
        $em->flush();
          
            // L'envoi de token
            $email = (new TemplatedEmail())
            ->from(new Address('wazzupverif@gmail.com','Wazzup'))
            ->to($user->getEmail())
            ->subject("Activation du compte Wazzup")
           ->htmlTemplate('Mail_templates/token.html.twig')
            ->context([
            'nom' => $user->getNom(),
            'type' => 'Votre token d\'activation',
            'token'=> $user->getToken(),
            'code' =>$user->getToken(),
            'content'=>'Nous sommes heureux que vous ayez rejoint notre communauté . Il vous suffit de confirmer votre inscription à l\'aide du code ci-dessous.'
        ])
;
      $mailer->send($email);
      $result=1;
      $jsonContent=$normalizable->normalize($result,'json',['groups'=>'registermobile']);
      return new Response(json_encode($jsonContent));
  }
 /**
     * @Route("api/users/verifymail", name="app_mobilemailverif", methods={"POST","GET"})
     */
    public function MobileSignupVerification(Request $request, EntityManagerInterface $em,NormalizerInterface $normalizable,UtilisateursRepository $userrepo): Response
    {
        $mailexists=false;
        $user = $userrepo->findOneBy(['email' => $request->query->get('email')]);
        if($user){
           $mailexists=true;    
        }
        $jsonContent=$normalizable->normalize($mailexists,'json',['groups'=>'mobileregverif']);
       
        return new Response(json_encode($jsonContent));
    }

 /**
     * @Route("api/users/verifynaissance", name="app_mobiledbverif", methods={"POST","GET"})
     */
 function MobileVerifierDatenaissance(Request $request, EntityManagerInterface $em,NormalizerInterface $normalizable){
    
    $db=$request->query->get('datenaissance');
    $dbyear=date("Y",strtotime($db)); 
    $dbvalid=false;
   if($dbyear >'2004'){
    $dbvalid=false;
   }
   else $dbvalid=true;
   $jsonContent=$normalizable->normalize($dbvalid,'json',['groups'=>'mobileregverifdb']);
   return new Response(json_encode($jsonContent));
}
}
