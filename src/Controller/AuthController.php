<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\ForgotpwType;
use App\Entity\Utilisateurs;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateursRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
     /**
     * @var bool
     */
    /**
     * @Route("/auth", name="app_auth", methods={"GET","POST"})
     */
    public function auth(Request $request,UtilisateursRepository $userrepo,UserPasswordEncoderInterface $encoder,SessionInterface $session): Response
    {   
        $user=new Utilisateurs();
        $login=false;
        $emailexist=true;
        $wrongpw=false;
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
        $email=$form->get('email')->getData();
        $password=$form->get('mdp')->getData();
        if($this->EmailExists($email,$request,$userrepo)){
          $emailexist=true;
          $user=$userrepo->findOneBy(['email'=>$email]);
          $PasswordCheck=$encoder->isPasswordValid($user, $password);
        //   dd($encoder->isPasswordValid($user, $password));
          if ($PasswordCheck){
              $login=true;
              $session->set('userdata',$user);
              if ($user->getTypeUser()=="User"){
                return $this->redirectToRoute('app_home');
              } else if ($user->getTypeUser()=="Admin"){
                return $this->redirectToRoute('app_admin');
              }

          }
          else{
              $wrongpw=true;
          }
        }
        else{
            $login=false;
            $emailexist=false;
        }
    }
     // login error handler 
    //    $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
            'auth_form' => $form ->createView(),
            'login'=> $login,
            'emailexist'=> $emailexist,
            'wrongpw'=>$wrongpw

        ]);
    }
    public function EmailExists($email,Request $request,UtilisateursRepository $userrepo){
        $form = $this->createForm(ForgotpwType::class);
        $form->handleRequest($request);
        $exist=false;
        $user=$userrepo->findOneBy(['email'=>$email]);
        if (!$user){
            $exist=false;
        }else 
            $exist=true;
            return $exist;
    }
        /**
     * @Route("/forgotpassword", name="forgotpassword")
     */
    public function forgotpw(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer,UtilisateursRepository $userrepo,UserPasswordEncoderInterface $encoder):Response{
        $form = $this->createForm(ForgotpwType::class);
        $form->handleRequest($request);
        $user=new Utilisateurs();
        $email_recuperation=$form->get('email')->getData();;
        
        if ($form->isSubmitted() && !$form->isValid() && $this->EmailExists($email_recuperation,$request,$userrepo)) {

           $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
           $newpass= substr(str_shuffle($permitted_chars), 0, 7);
           $hashedpw= $encoder->encodePassword($user,$newpass);
           $user=$userrepo->findOneBy(['email'=>$email_recuperation]);
           $user->setMdp($hashedpw);
           $entityManager->persist($user);
           $entityManager->flush();
           $email = (new TemplatedEmail())
           ->from(new Address('wazzupverif@gmail.com','Wazzup'))
           ->to($email_recuperation)
           ->subject("Recupération mot de passe")
          ->htmlTemplate('Mail_templates/newpass.html.twig')
           ->context([
           'nom' => $user->getNom(),
           'type' => 'Votre nouveau mot de passe',
           'code' =>$newpass,
       ])
;
     $mailer->send($email);
        }
        return $this->render('forgotpassword/index.html.twig', [
            'controller_name' => 'AuthController',
            'forgotpw_form' => $form ->createView()
        ]);
    }
     /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(Request $request,SessionInterface $session){
        $session->clear();
        return $this->redirectToRoute('app_auth');
    }
}
