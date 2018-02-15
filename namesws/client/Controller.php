<?php

session_start();
require_once('../lib/nusoap.php'); //include required class for build nnusoap web service server

        const _SERVER_WSDL = "http://localhost/namesws/server/index.php?wsdl";  // SOAP Server

class Controller {

    function __construct($view = "genderNames") {
        if (!isset($_SESSION['likes']) || !isset($_SESSION['dislikes'])) {
            $_SESSION['likes'] = Array();
            $_SESSION['dislikes'] = Array();
        }
        if (!$this->checkPost()) {
            $this->checkGet($view);
        }
        return;
    }

    function checkPost() {
        if (isset($_POST['hidden'])) {
            print(json_encode(array($_SESSION['likes'], $_SESSION['dislikes'])));
            return true;
        } elseif (isset($_POST['likes'])) {
            array_push($_SESSION['likes'], $_POST['likes']);
            return true;
        } elseif (isset($_POST['dislikes'])) {
            array_push($_SESSION['dislikes'], $_POST['dislikes']);
            return true;
        } elseif (isset($_POST['gender'])) {
            if (isset($_POST['string']))
                $this->getNamesStartingBy($_POST['gender'], $_POST['string']);
            elseif (isset($_POST['like']))
                $this->addLike($_POST['like']);
            elseif (isset($_POST['dislike']))
                $this->addDislike($_POST['dislike']);
            else
                $this->getGenderNames($_POST['gender']);
            return true;
        }
        return false;
    }

    function checkGet($view) {
        switch ($view) {
            case 'searcher':
                $this->createViews('namesStartingBy');
                break;
            case 'genderNames':
                $this->createViews('genderNames');
                break;
            default :
                $this->createViews('error');
        }
    }

    function createViews($view) {
        switch ($view) {
            case 'namesStartingBy':
                require_once('view/namesStartingBy.php');
                break;
            case 'genderNames':
                require_once('view/genderNames.php');
                break;
            case 'error':
            default:
                require_once('view/error.php');
        }
    }

    function getGenderNames($gender) {
        $client = new soapclient(_SERVER_WSDL) or die("Error");
        $response = $client->__call('getGenderNames', array($gender)) or die("Error");
        print(json_encode($response));
    }

    function getNamesStartingBy($gender, $string) {
        $client = new soapclient(_SERVER_WSDL) or die("Error");
        $response = $client->__call('getNamesStartingBy', array($gender, $string)) or die("Error");
        print(json_encode($response));
    }

    function addLike($name) {
        $client = new soapclient(_SERVER_WSDL) or die("Error");
        $response = $client->__call('addLike', array($name)) or die("Error");
    }

    function addDislike($name) {
        $client = new soapclient(_SERVER_WSDL) or die("Error");
        $response = $client->__call('addDislike', array($name)) or die("Error");
    }

}
