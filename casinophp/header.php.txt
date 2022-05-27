<?php
session_start();
require 'vendor/autoload.php';
use MongoDB\Client;
$client = new Client('mongodb://localhost:27017');

$img_g = rand(1,6);
$img_p = rand(7,16);
?>

<meta charset="utf-8" />
<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <head>
        <title>CASINO UDP</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <header class="bg-dark">
      <div class="collapse bg-red" id="navbarHeader">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-7 py-4">
                  <h4 class="text-white">Informate sobre nuestro Casino UDP</h4>
                  <ul class="text-muted">
                      <li>Bienvenido a nuestro Casino UDP, este fue creado por Estudiantes/Graduados/Profesores que querian unir a nuestra comunidad y tener buenos momentos con nuestra comunidad, esperamos que disfrute de su estancia aca, para eso está.</li>
                      <li>En este casino tu te haces respondable de tanto las perdidas o ganancias que tengas. Suerte en tu Jugada amigo!!</li> 
                      <li>Cualquier inconveniente contactese con nosotros.</li>
                      <li>Por razones de estafas no tenemos convenio con el banco Santander, Disculpe las molestias.</li>
                      <li>Si no sabe como jugar a uno de los juegos que tenemos, vaya con un asesor online para que lo guíe.</li>
                      <li>Y por ultimo, aca se viene a disfrutar junto a tu familia, amigos, o enemigos >:D.</li>
                  </ul>
              </div>
              <?php if(isset($_SESSION["user"])){ ?>
              <div class="col-sm-4 offset-md-1 py-4">
                  <h4 class="text-white">Cuenta</h4>
                  <ul class="list-unstyled text-white">
                    <li>Hola <?php echo $_SESSION["user"]["name"]; ?>.</li>
                    <li>Tienes <?php echo $_SESSION["user"]["monto"]; ?> Coins.</li>
                    <br>
                    <br>
                    <br>
                    <br>
                    <li>¿Que deseas hacer?</li>
                    <br>
                    <li><a href="Cargar.php" class="text-white">Cargar Coins</a></li>
                    <li><a href="history.php" class="text-white">Historial de jugadas</a></li>
                    <li><a href="BD/out.php" class="text-white">Cerrar Sesion</a></li>
                  </ul>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="navbar navbar-dark bg-red shadow-sm">
          <div class="container d-flex justify-content-between">
            <ul class="nav nav-pills">
              <li class="navbar nav-pills">
                <a class="navbar-brand" href="index.php">
                  <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                  Casino UDP
                </a>
              </li >
              <li class="navbar dropdown">
                <a class="navbar-brand d-flex align-items-center dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Juegos</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="ruleta.php">Ruleta</a>
                  <a class="dropdown-item" href="dados.php">Dados</a>
                  <a class="dropdown-item" href="cos.php">Cara o Sello</a>
                </div>
              </li>
            </ul>
            <?php
              if(isset($_SESSION["user"])){ ?>
              <div class="d-flex"> 
                <div class="navbar dropdown">
                <a class="navbar-brand d-flex align-items-center dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cuenta</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="Cargar.php">Recargar Coins</a>
                  <a class="dropdown-item" href="history.php">Historial</a>
                  <a class="dropdown-item" href="BD/out.php">Cerrar Sesion</a>
                </div>
                </div>
              <?php }else{ ?> 
                <div>
                <a href="log.php"><button type="button" class="btn btn-right btn-outline-warning"> Ingresar </button></a>
              <?php } ?>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            </div>
          </div>
        </div>
  </header>