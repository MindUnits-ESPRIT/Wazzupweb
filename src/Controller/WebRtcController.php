<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class WebRtcController extends AbstractController
{
    /**
     * @Route("/web/rtc/get", name="app_web_rtc_get")
     */
    public function indexGet(Request  $request): Response
    {
        if (!$request->query->has('unique')) {
            die('no identifier');
        }
        $unique=$request->query->get('unique');
        if (strlen($unique)==0 || ctype_digit($unique)===false) {
            die('not a correct identifier');
        }
        $response=new Response();
        $response->headers->set('Content-Type','text/event-stream');
        header('Cache-Control: no-cache'); // recommended
        $all = array ();
        $handle = opendir ( '../'.basename ( dirname ( __FILE__ ) ) );
        if ($handle !== false) {
            while ( false !== ($filename = readdir ( $handle )) ) {
                if ($this->startsWith($filename,'_file_' /* .$room */)  && !($this->startsWith($filename,'_file_' /*.$room*/ .$unique) )) {
                    $all [] .= $filename;
                }
            }
            closedir( $handle );
        }

        if (count($all)!=0) {

            // A main lock to ensure save safe writing/reading
            $mainlock = fopen('serverGet.php','r');
            if ($mainlock===false) {
                die('could not create main lock');
            }
            flock($mainlock, LOCK_EX);

            // show and empty the first file that is not empty
            for ($x=0; $x<count($all); $x++) {
                $filename=$all[$x];

                // prevent sending empty files
                if (filesize($filename)==0) {
                    unlink($filename);
                    continue;
                }

                $file = fopen($filename, 'c+b');
                flock($file, LOCK_SH);

                $r= 'data: '.fread($file, filesize($filename)). PHP_EOL;
                fclose($file);
                unlink($filename);
                break;
            }

            // Unlock main lock
            flock($mainlock, LOCK_UN);
            fclose($mainlock);
        }


        $r= 'retry: 1000'. PHP_EOL. PHP_EOL; // shorten the 3 seconds to 1 sec
         $response->setContent($r);
        return $response;
    }
    /**
     * @Route("/web/rtc/post", name="app_web_rtc_post")
     */
    public function indexPost(Request $request): Response
    {
        if (!$request->query->has('unique')) {
            die('no identifier');
        }
        $unique=$_GET['unique'];
        if (strlen($unique)==0 || ctype_digit($unique)===false) {
            die('not a correct identifier');
        }


// A main lock to ensure save safe writing/reading
        $mainlock = fopen('serverGet.php','r');
        if ($mainlock===false) {
            die('could not create main lock');
        }
        flock($mainlock, LOCK_EX);

// Add the new message to file
        $filename = '_file_' /*.$room*/ . $unique;
        $file = fopen($filename,'ab');
        if (filesize($filename)!=0) {
            fwrite($file,'_MULTIPLEVENTS_');
        }
        $posted = file_get_contents('php://input');
        fwrite($file,$posted);
        fclose($file);

// Unlock main lock
        flock($mainlock,LOCK_UN);
        fclose($mainlock);
        return $this->json('');
    }
    public function startsWith($haystack, $needle): string
    {
        return (substr($haystack, 0, strlen($needle) ) === $needle);
    }
    /**
     * @Route("/web/rtc", name="app_wep_rtc")
     */
    public function hamatayzon()
    {
        return $this->render('web_rtc/index.html.twig', [
            'controller_name' => 'WebRtcController',
        ]);
    }

}
