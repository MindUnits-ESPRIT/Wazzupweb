<?php

namespace App\Controller;
use App\Form\SignupType;
use Cloudinary\Cloudinary;
use App\Entity\Utilisateurs;
use Doctrine\ORM\EntityManagerInterface;
use Cloudinary\Configuration\Configuration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

Configuration::instance([
    'cloud' => [
      'cloud_name' => 'duqo08ysi',
      'api_key' => '655598492747666',
      'api_secret' => 'me7yEUfSm7UEee2jWarnGaBhnY4'],
    'url' => [
      'secure' => true]]);


class SignupController extends AbstractController
{
    /**
     * @Route("/signup", name="app_signup", methods={"GET", "POST"})
     */
    public function signup(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder): Response
    {
        $user=new Utilisateurs();
        $form=$this->createForm(SignupType::class,$user);
        $form->handleRequest($request);
        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
             $hash= $encoder->encodePassword($user,$user->getMdp());
             $user->setmdp($hash);
             // dd($user);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Compte creé !');
            


            return $this->redirectToRoute('app_auth', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
            'signup_form' => $form ->createView(),
        ]);

    }
    public function upload(): Response
    {
        $form=$this->createForm(SignupType::class);
        if ($form->isSubmitted()){
        $cloudinary = new Cloudinary();
        $cloudinary->uploadApi->upload('xdd.jpg');
        return new JsonResponse($cloudinary);
    }

    }
    
}
