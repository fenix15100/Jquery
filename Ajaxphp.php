<?php
header('Content-type: application/json');
$data[0] = array("nombre" => "Albert", "apellido" => "Camus");
$data[1] = array("nombre" => "Ernesto", "apellido" => "Sabato");
echo json_encode($data);
?>