<?php

namespace App\Controller;

use App\Entity\Variedades;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;



/**
 * @Route("/api")
 */

class CannabisController extends Controller
{
    /**
     * @Route("/cannabis/list", name="cannabis_list")
     * @Method("GET");
     */
    public function list()
    {
        //Obtengo todos los ejemplares de plantas
        $variedades = $this->getDoctrine()
            ->getRepository(Variedades::class)
            ->findAll();

        //Configuro un Parser a JSON que pueda encodear el array complejo obtenido arriba
        //(No sirve un simple JSONencode);
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        //Serializo los datos en JSON y los devuelvo
        $result =$serializer->serialize($variedades, 'json');


        $response = new Response($result);
        return $response;
    }


    /**
     * @Route("/cannabis/erase/{id}", name="cannabis_erase")
     * @Method("DELETE");
     */
    public function erase($id){

        $em = $this->getDoctrine()->getManager();

        $variedad = $em->getRepository(Variedades::class)->find($id);

        $em->remove($variedad);
        $em->flush();

        return $this->list();



    }
}
