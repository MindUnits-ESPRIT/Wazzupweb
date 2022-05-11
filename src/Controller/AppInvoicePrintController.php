<?php

namespace App\Controller;
use App\Entity\Paiement;
use App\Entity\OffrePublicitaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class AppInvoicePrintController extends AbstractController
{
    /**
     * @Route("/app/invoice/print", name="app_invoice_print")
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
            ->findOneBy([], ['' => 'DESC'], 1, 0);

        return $this->render('app_invoice_pidPaiementrint/index.html.twig', [
            'controller_name' => 'AppInvoicePrintController',
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
            'paiement' => $paiement,
            'OffrePublicitaire' => $OffrePublicitaire,
        ]);
    }

    /**
     * @Route("/GeneratePDF", name="GeneratePDF" )
     */
    public function GeneratePDF(SessionInterface $session): Response
    {
        $user = $session->get('userdata');
        $OffrePublicitaire = $this->getDoctrine()
            ->getRepository(OffrePublicitaire::class)
            ->findBy([
                'idUtilisateur' => $user,
            ])[0];
        $paiement = $this->getDoctrine()
            ->getRepository(Paiement::class)
            ->findOneBy([], ['idPaiement' => 'DESC'], 1, 0);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Courier');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('app_invoice_print/index.html.twig', [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getTypeUser(),
            'picture' => $user->getAvatar(),
            'user' => $user,
            'paiement' => $paiement,
            'OffrePublicitaire' => $OffrePublicitaire,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html, 'UTF-8');
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->set_option('defaultMediaType', 'all');
        $dompdf->set_option('isFontSubsettingEnabled', true);
        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = '../public';
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath = $publicDirectory . '/Facturewazzupmypdf.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);
        // Send some text response
        return $this->redirectToRoute('app_invoice_print');
    }
}
