<?php

namespace App\Controller;

use App\Entity\Paises;
use App\Entity\Tipos;
use App\Entity\Variedades;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/cannabis/listpais", name="cannabis_listpais")
     * @Method("GET");
     */
    public function listpais()
    {
        //Obtengo todos los ejemplares de plantas
        $paises = $this->getDoctrine()
            ->getRepository(Paises::class)
            ->findAll();

        //Configuro un Parser a JSON que pueda encodear el array complejo obtenido arriba
        //(No sirve un simple JSONencode);
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        //Serializo los datos en JSON y los devuelvo
        $result =$serializer->serialize($paises, 'json');


        $response = new Response($result);
        return $response;
    }



    /**
     * @Route("/cannabis/listipos", name="cannabis_listtipos")
     * @Method("GET");
     */
    public function listtipos()
    {
        //Obtengo todos los ejemplares de plantas
        $tipos = $this->getDoctrine()
            ->getRepository(Tipos::class)
            ->findAll();

        //Configuro un Parser a JSON que pueda encodear el array complejo obtenido arriba
        //(No sirve un simple JSONencode);
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        //Serializo los datos en JSON y los devuelvo
        $result =$serializer->serialize($tipos, 'json');


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

        return new Response("ok");



    }

    /**
     * @Route("/cannabis/edit/{id}", name="cannabis_edit")
     * @Method("POST");
     */
    public function edit($id){

        $em = $this->getDoctrine()->getManager();

        $variedad = $em->getRepository(Variedades::class)->find($id);

        $variedad->setNombre($_POST['nombre']);
        $variedad->setTiempoFloracion($_POST['floracion']);

        if(isset($_POST['interior'])) {
            $variedad->setInterior(true);
            $variedad->setExterior(false);
        }elseif (isset($_POST['exterior'])){
            $variedad->setExterior(true);
            $variedad->setInterior(false);
        }


        $variedad->setTHC($_POST['thc']);
        $variedad->setCBD($_POST['cbd']);
        $variedad->setGenetica($_POST['genetica']);


        $tipo=$em->getRepository(Tipos::class)->find($_POST['tipo']);
        $pais=$em->getRepository(Paises::class)->find($_POST['pais']);
        $variedad->setIdTipo($tipo);
        $variedad->setIdPais($pais);

        $variedad->setDescription($_POST['descripcion']);

        $em->persist($variedad);
        $em->flush();



        return new Response (new Response('OK'));



    }

    /**
     * @Route("/cannabis/new", name="cannabis_new")
     * @Method("POST");
     */
    public function newitem($id){

        $em = $this->getDoctrine()->getManager();

        $variedad = new Variedades();

        $variedad->setNombre($_POST['nombre']);
        $variedad->setTiempoFloracion($_POST['floracion']);

        if(isset($_POST['interior'])) {
            $variedad->setInterior(true);
            $variedad->setExterior(false);
        }elseif (isset($_POST['exterior'])){
            $variedad->setExterior(true);
            $variedad->setInterior(false);
        }


        $variedad->setTHC($_POST['thc']);
        $variedad->setCBD($_POST['cbd']);
        $variedad->setGenetica($_POST['genetica']);


        $tipo=$em->getRepository(Tipos::class)->find($_POST['tipo']);
        $pais=$em->getRepository(Paises::class)->find($_POST['pais']);
        $variedad->setIdTipo($tipo);
        $variedad->setIdPais($pais);

        $variedad->setDescription($_POST['descripcion']);

        $em->persist($variedad);
        $em->flush();



        return new Response (new Response('OK'));



    }


}
