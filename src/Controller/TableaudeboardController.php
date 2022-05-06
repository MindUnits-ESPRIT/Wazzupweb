<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\OffrePublicitaire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\AreaChart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\AnnotationChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TableaudeboardController extends AbstractController
{
    /**
     * @Route("/tableaudeboard", name="app_tableaudeboard")
     */
    public function index(SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        $OffrePublicitaire = $this->getDoctrine()
            ->getRepository(OffrePublicitaire::class)
            ->findBy([
                'idUtilisateur' => $user,
            ])[0];
            $paiement = $this->getDoctrine()
            ->getRepository(Paiement::class)
            ->findAll();

             $tab=[];
             for ($x = 0; $x < count($paiement); $x++) {
                $tab[$x]=date_format($paiement[$x]->getDatePaiement(),'Y-m-d');;
              }
              $tab2=[];
              for ($x = 0; $x < count($paiement); $x++) {
                 $tab2[$x]=$paiement[$x]->getPrix();
               }

            $area = new AreaChart();
            
         
            $data=[];

            $Header=['DatePaiement', 'Prix'];
            array_push($data,$Header);
            
            for ($i = 0; $i < count($paiement); $i++) {
            
                  $temp=[];
                  array_push($temp,$tab[$i]);
                  array_push($temp,$tab2[$i]);
                  array_push($data,$temp);
              }

            $area->getData()->setArrayToDataTable($data);


        $area->getOptions()->setTitle('Company Performance');
        $area->getOptions()->getHAxis()->setTitle('Year');
        $area->getOptions()->getHAxis()->getTitleTextStyle()->setColor('#333');
        $area->getOptions()->getVAxis()->setMinValue(0);
        return $this->render('tableaudeboard/index.html.twig', [
            'controller_name' => 'TableaudeboardController',
            'area' => $area,
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
            'paiement' => $paiement,
            'OffrePublicitaire' => $OffrePublicitaire,
        ]);
    }
}
