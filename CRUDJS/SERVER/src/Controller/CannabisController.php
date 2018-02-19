<?php

namespace App\Controller;

use App\Entity\Variedades;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;



/**
 * @Route("/api")
 */

class CannabisController extends Controller
{
    /**
     * @Route("/cannabis", name="cannabis")
     */
    public function list()
    {
        $request = Request::createFromGlobals();
        $cadena=$request->request->get('buscar');

        $variedades = $this->getDoctrine()
            ->getRepository(Variedades::class)
            ->findAll();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $result =$serializer->serialize($variedades, 'json');


        $response = new Response($result);
        return $response;
    }
}
