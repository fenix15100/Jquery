<?php

require_once('../lib/nusoap.php'); // nusoap library
require_once('ModelPDO.php');   // ModelPDO class to access to DB
// SOAP Server creation
$server = new soap_server();

// WSDL Configuration
$server->configureWSDL('Names WS', 'urn:namesws');

// Register getGenderNames method
$server->register('getGenderNames',                                     // method
        array('gender' => 'xsd:string'),                                // input parameters
        array('return' => 'xsd:Array'),                                 // output parameters
        'urn:namesws',                                                  // namespace
        'urn:namesws#getGenderNames',                                   // soapaction
        'rpc',                                                          // style
        'encoded',                                                      // use
        'Method that returns all names of a gender orderd by likes.'
        . ' \'gender\' input parameter has to be'
        . ' \'hombre\' or \'mujer\' (male or female).'                  // documentation
);

// Register getGenderNames method
$server->register('getNamesStartingBy',                                 // method
        array('gender' => 'xsd:string', 'string' => 'xsd:string'),      // input parameters
        array('return' => 'xsd:Array'),                                 // output parameters
        'urn:namesws',                                                  // namespace
        'urn:namesws#getNamesStartingBy',                               // soapaction
        'rpc',                                                          // style
        'encoded',                                                      // use
        'Method that returns names of a gender that starts'
        . 'with the string we pass as a parameter.'                     // documentation
);

// Register addLike method
$server->register('addLike',                                            // method
        array('name' => 'xsd:string'),                                  // input parameters
        array('return' => 'xsd:int'),                                   // output parameters
        'urn:namesws',                                                  // namespace
        'urn:namesws#addLike',                                          // soapaction
        'rpc',                                                          // style
        'encoded',                                                      // use
        'Method that inserts a like'                                    // documentation
);

// Register addDislike method
$server->register('addDislike',                                         // method
        array('name' => 'xsd:string'),                                  // input parameters
        array('return' => 'xsd:int'),                                   // output parameters
        'urn:namesws',                                                  // namespace
        'urn:namesws#addDislike',                                       // soapaction
        'rpc',                                                          // style
        'encoded',                                                      // use
        'Method that inserts a dislike'                                 // documentation
);

// Function that returns all names of gender ordered by likes
function getGenderNames($gender) {
    $pdo = new ModelPDO();
    $bdd = $pdo->getDBO();
    $result = $bdd->query("SELECT nombre, gusta, nogusta FROM nombres WHERE genero = '$gender' ORDER BY gusta - nogusta DESC , nombre ASC");
    $return = $result->fetchAll();
    $array = array();
    foreach ($return as $value) {
        array_push($array, array($value['nombre'], $value['gusta'], $value['nogusta']));
    }

    return $array;
}

// Function that returns names of a gender that starts with the string we pass as a parameter.
function getNamesStartingBy($gender, $string) {
    $pdo = new ModelPDO();
    $bdd = $pdo->getDBO();
    $result = $bdd->query("SELECT nombre FROM nombres WHERE genero = '$gender' AND nombre LIKE '$string%' ORDER BY nombre ASC");
    $return = $result->fetchAll();
    $array = array();
    foreach ($return as $value) {
        array_push($array, $value['nombre']);
    }

    return $array;
}

// Function that inserts a like.
function addLike($name) {
    $pdo = new ModelPDO();
    $bdd = $pdo->getDBO();
    $result = $bdd->query("SELECT gusta FROM nombres WHERE nombre='$name'");
    $return = $result->fetchAll();
    $array = array();
    foreach ($return as $value) {
        array_push($array, array($value[0]));
    }
    $bdd->query("UPDATE nombres SET gusta=" . ($return[0][0] + 1) . " WHERE nombre='$name'");

    return 1;
}

// Function that inserts a dislike.
function addDislike($name) {
    $pdo = new ModelPDO();
    $bdd = $pdo->getDBO();
    $result = $bdd->query("SELECT nogusta FROM nombres WHERE nombre='$name'");
    $return = $result->fetchAll();
    $array = array();
    foreach ($return as $value) {
        array_push($array, array($value[0]));
    }
    $bdd->query("UPDATE nombres SET nogusta=" . ($return[0][0] + 1) . " WHERE nombre='$name'");

    return 1;
}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
