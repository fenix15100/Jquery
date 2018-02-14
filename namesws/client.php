<?php

require_once('lib/nusoap.php'); //include required class for build nnusoap web service server
$wsdl = "http://localhost/Jquery/namesws/server.php?wsdl";  // SOAP Server

try {
    $client = new soapclient($wsdl) or die("Error");   // Connect the SOAP server
    $response = $client->__call('metodo1', array("hola", 10, true)) or die("Error");
    
    print_r($response);
    
} catch (SoapFault $f) {
    var_dump($f);
}