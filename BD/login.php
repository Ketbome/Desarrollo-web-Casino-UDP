<?php
session_start();
require '../vendor/autoload.php';
use MongoDB\Client;
$client = new Client('mongodb://localhost:27017');
$usuarios = $client -> casino -> usuarios;
$usr = $usuarios->find(array(username=>$_POST["nombre"],pass=>$_POST["password"]));
$login = false;
foreach($usr as $u){
    $login = true;
    $dinero = $u['monto'];
    $nombre = $u["username"];
    $ganadas = $u["wins"];
}

if($login){
$_SESSION["user"] = Array("name" => $nombre, "password" => $_POST["password"], "monto" => $dinero, "wins" => $ganadas);
header("location:../index.php");
}else{
die("Constraseña no coincide.");
};
?>