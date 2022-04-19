<?php

namespace App\Controller;

use Cloudinary\Cloudinary;
use App\Entity\Utilisateurs;
use App\Form\EditProfileType;
use App\Form\EditProfileType2;
use App\Repository\InteretsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProfileController extends AbstractController
{
    /**
     * @Route("/edit/profile/upload", name="upload_img")
     */
    public function upload(Request $request)
    {
        $imageurl= $request->request->get('imageurl');
        dd($imageurl);

        // dd(str_replace("&U+002347;","/",$url));
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
            $imageurl
        );
        dd($res);
       
            return $this->redirectToRoute('app_edit_profile');
  

}
       /**
     * @Route("/edit/profile/", name="app_edit_profile")
     */
    public function index(Request $request,SessionInterface $session,InteretsRepository $repo): Response
    {
        $user=new Utilisateurs();
        $form=$this->createForm(EditProfileType::class,$user);
        $form2=$this->createForm(EditProfileType2::class,$user);
        $form->handleRequest($request);
        $user=$session->get('userdata');
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
            'role'=>$user->getTypeUser(),
            'picture'=>$user->getAvatar(),
            'interets' =>$interets,
            'general_form' => $form ->createView(),
            'pwd_form' => $form2 ->createView(),
            // 'pwd_form' => $form ->createView()
            
            
        ]);
    }
}
}
