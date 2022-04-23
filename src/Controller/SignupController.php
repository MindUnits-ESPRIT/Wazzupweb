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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class SignupController extends AbstractController
{

    /**
     * @Route("/signup", name="app_signup", methods={"GET", "POST"})
     */
    public function signup(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder, MailerInterface $mailer): Response
    {
        $user=new Utilisateurs();
        $form=$this->createForm(SignupType::class,$user);
        $form->handleRequest($request);
        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
        
             $hash= $encoder->encodePassword($user,$user->getMdp());
             $user->setmdp($hash);
             // Generation du token 
             $user->setToken(sha1(uniqid()));
             $user->setActivated(false);
             $this->upload(__DIR__.'\xdd.jpg');
             // dd($user);
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
            ['email' => $user->getEmail()],
        );  
        }
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
            'signup_form' => $form ->createView(),
        ]);
    }

    public function upload()
    {
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
        $res = $cld->uploadApi()->upload(__DIR__.'\xdd.jpg');
        // dd($res);
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



    
    
}
