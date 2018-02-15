<?php

class Bootstrap {

    function __construct() {
        include 'Controller.php';
        
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            $url = rtrim($url, '/');
            $url = explode('/', $url);

            $controller = new Controller($url[0]);
        }
        else
            $controller = new Controller();
    }
}
