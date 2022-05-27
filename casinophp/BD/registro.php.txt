<?php
session_start();
require '../vendor/autoload.php';
use MongoDB\Client;
$client = new Client('mongodb://localhost:27017');
$usuarios = $client -> casino -> usuarios;
$reg=true;
$usr = $usuarios->find(array(username => $_POST["nombre"]));
foreach ($usr as $u) {
    $reg=false;
}
if($reg){
$usuarios->insertOne([
    'username' => $_POST["nombre"],
    'email' => $_POST["email"],
    'pass' => $_POST["password"],
    'wins' => 0,
    'monto' => 100000,
]);
$_SESSION["user"] = Array("name" => $_POST["nombre"], "password" => $_POST["password"], "monto" => 100000, "wins"=>0);
header("location:../index.php");
}else{ 
    echo "Ya existe un usuario con ese nombre."; 
} 
?>