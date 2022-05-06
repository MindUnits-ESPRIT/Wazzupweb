<?php

namespace App\Controller;

use App\Form\LoginType;
use Twilio\Rest\Client;
use App\Form\ForgotpwType;
use App\Entity\Utilisateurs;
use Cloudinary\Transformation\Loop;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateursRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function auth(
        Request $request,
        UtilisateursRepository $userrepo,
        UserPasswordEncoderInterface $encoder,
        SessionInterface $session
    ): Response {
        $user = new Utilisateurs();
        $login = false;
        $emailexist = true;
        $wrongpw = false;
        $activated = false;
        $otp = false;
        $code = '';
        $valid_otp = false;

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $password = $form->get('mdp')->getData();
            if ($this->EmailExists($email, $request, $userrepo)) {
                $emailexist = true;
                $user = $userrepo->findOneBy(['email' => $email]);
                $isActivated = $user->getActivated();
                $PasswordCheck = $encoder->isPasswordValid($user, $password);
                //   dd($encoder->isPasswordValid($user, $password));

                if ($isActivated) {
                    if ($PasswordCheck) {
                        $login = true;
                        $session->set('userdata', $user);

                        if ($user->getTypeUser() == 'User') {
                            $login = true;

                            return $this->redirectToRoute('app_home');
                        } elseif ($user->getTypeUser() == 'Admin') {
                            $otp = true;
                            $code = rand(10000, 99999);
                            if ($session->get('validotp')) {
                                sleep(3000 / 1000);
                                return $this->redirectToRoute('app_admin');
                           }
                            
                            // $this->SendSMS("+21624664880",$code);

                            $this->SendSMS('+21624664880', $code);
                        }
                    } else {
                        $wrongpw = true;
                    }
                } else {
                    $activated = true;
                }
            } else {
                $login = false;
                $emailexist = false;
            }
        }
        // login error handler
        //    $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
            'auth_form' => $form->createView(),
            'login' => $login,
            'emailexist' => $emailexist,
            'wrongpw' => $wrongpw,
            'activated' => $activated,
            'otp' => $otp,
            'code' => $code,
            'valid_otp' => $valid_otp,
        ]);
    }

    /**
     * @Route("check-otp/{otp}/{code}", name="app_otpcheck", methods={"GET","POST"})
     */
    public function CheckOTP(
        $otp,
        $code,
        Request $request,
        SessionInterface $session
    ) {
        $valid_otp = false;
        if ($otp == $code) {
            $valid_otp = true;
            $this->addFlash(
                'success',
                'Votre OTP a été bien validé ! , Vous pouvez maintenant s\'authentifier'
            );
            $session->set('validotp', $valid_otp);
            return $this->redirectToRoute('app_auth', [
                'validotp' => $valid_otp,
            ]);
        } else {
            $valid_otp = false;
        }
        // dd($otp==$code);
    }

    /**
     * @Route("check/{email}", name="app_emailcheck", methods={"GET","POST"})
     */
    public function EmailExists(
        $email,
        Request $request,
        UtilisateursRepository $userrepo
    ) {
        $form = $this->createForm(ForgotpwType::class);
        $form->handleRequest($request);
        $exist = false;
        $user = $userrepo->findOneBy(['email' => $email]);
        if (!$user) {
            $exist = false;
        } else {
            $exist = true;
        }
        return $exist;
    }

    public function SendSMS($tel, $code)
    {
        $sid = 'ACa1c3f6d59e0c9f3d76e39dfec69e7c91'; // Your Account SID from www.twilio.com/console
        $token = '5507d1f2963c865769e5181c60d81781'; // Your Auth Token from www.twilio.com/console
        $client = new Client($sid, $token);
        $body = 'Votre code OTP admin est : ' . $code;
        $message = $client->messages->create(
            $tel, // Text this number
            [
                'from' => '+16814914823', // From a valid Twilio number
                'body' => $body,
            ]
        );
    }
    /**
     * @Route("/forgotpassword", name="forgotpassword")
     */
    public function forgotpw(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        UtilisateursRepository $userrepo,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $form = $this->createForm(ForgotpwType::class);
        $form->handleRequest($request);
        $user = new Utilisateurs();
        $email_recuperation = $form->get('email')->getData();

        if (
            $form->isSubmitted() &&
            !$form->isValid() &&
            $this->EmailExists($email_recuperation, $request, $userrepo)
        ) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $newpass = substr(str_shuffle($permitted_chars), 0, 7);
            $hashedpw = $encoder->encodePassword($user, $newpass);
            $user = $userrepo->findOneBy(['email' => $email_recuperation]);
            $user->setMdp($hashedpw);
            $entityManager->persist($user);
            $entityManager->flush();
            $email = (new TemplatedEmail())
                ->from(new Address('wazzupverif@gmail.com', 'Wazzup'))
                ->to($email_recuperation)
                ->subject('Recupération mot de passe')
                ->htmlTemplate('Mail_templates/newpass.html.twig')
                ->context([
                    'nom' => $user->getNom(),
                    'type' => 'Votre nouveau mot de passe',
                    'code' => $newpass,
                ]);
            $mailer->send($email);
        }
        return $this->render('forgotpassword/index.html.twig', [
            'controller_name' => 'AuthController',
            'forgotpw_form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(Request $request, SessionInterface $session)
    {
        $session->clear();
        $this->addFlash('success', 'Vous avez été déconnecté avec succès. !');
        return $this->redirectToRoute('app_auth');
    }
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// Mobile API /////////////////////////////////////////////
    /// Authentification // 
    /**
     * @Route("api/mobile-auth", name="app_mobileauth", methods={"GET","POST"})
     */
    public function authMobile(
        Request $request,
        NormalizerInterface $normalizable,
        UtilisateursRepository $userrepo,
        UserPasswordEncoderInterface $encoder
        
    ): Response //mail
    {    
        $result=-1;
        $email = $request->query->get('email');
        $password = $request->query->get('mdp');
        
        if ($this->EmailExists($email, $request, $userrepo)) {
            $emailexist = true;
           
            $user = $userrepo->findOneBy(['email' => $email]);
            $isActivated = $user->getActivated();
            $PasswordCheck = $encoder->isPasswordValid($user, $password);
            //   dd($encoder->isPasswordValid($user, $password));

            if ($isActivated) {
                if ($PasswordCheck) {
                    if ($user->getTypeUser() == 'User') {
                    $result=1;
                    new Response("User identified");
                    } elseif ($user->getTypeUser() == 'Admin') {
                        $result=2;
                    new Response("Admin identified");
                    }
                } else {
                    $result=0;
                }
            } else {
                $activated = true;
                $result=-2;
            }
        } else {
            $login = false;
            $emailexist = false;
            $result=-3;
        }
    

        $jsonContent=$normalizable->normalize($result,'json',['groups'=>'authmobile']);
        return new Response(json_encode($jsonContent));
    }
////////////////////////////////////////
    /// GET CONNECTED USER DATA // 
    /**
     * @Route("api/getuser", name="app_getconuser", methods={"GET","POST"})
     */
    public function ShowConnUser(
        Request $request,
        NormalizerInterface $normalizable,
        UtilisateursRepository $userrepo,
    ): Response //mail
    {    
        $user = $userrepo->findOneBy(['email' => $request->query->get('email')]);

        $jsonContent=$normalizable->normalize($user,'json',['groups'=>'getusergrp']);
       
        return new Response(json_encode($jsonContent));
    }






}

