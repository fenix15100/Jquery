<?php

require_once('lib/nusoap.php'); //include required class for build nnusoap web service server
require_once('ModelPDO.php');

  // Create server object
   $server = new soap_server();

   // configure  WSDL
   $server->configureWSDL('Names WS', 'urn:namesws');

   // Register the method to expose
    $server->register('metodo1',                                 // method
        array('charcters' => 'xsd:string','integ' => 'xsd:int','bool' => 'xsd:boolean'),    // input parameters
        array('return' => 'xsd:Array'),                             // output parameters
        'urn:namesws',                                            // namespace
        'urn:namesws#metodo1',                                // soapaction
        'rpc',                                                       // style
        'encoded',                                                   // use
        'Este metodo es una prueba.'                                // documentation
    );

    // Define the method as a PHP function

    function metodo1($string,$int,$bool) {
        $pdo = new ModelPDO();
        $bdd = $pdo->getDBO();
        $result = $bdd->query("SELECT nombre FROM nombres");
        $return = $result->fetchAll();
        
        $array = array();
        foreach ($return as $value) {
            array_push($array, $value['nombre']);
        }
        
        return $array;
    }

    // Use the request to (try to) invoke the service
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA); 