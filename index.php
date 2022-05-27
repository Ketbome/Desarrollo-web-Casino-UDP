<?php
include_once("header.php");
$arr = Array();

$arr[] = Array(     "desc" => "Ruleta UDP: Se tira una pelotita la cual caera en un número, si aciertas a este numero ganaras 6 veces lo apostado!!! No te pierdas la experiencia!",
                    "img" => "img/ruleta.gif", 
                    "ref" => "ruleta.php");

$arr[] = Array(     "desc" => "Dados UDP: La suma de dos dados tirados al azardaran un número el cual si acertas a este, Ganaras 2 veces lo apostado!!! Por tiempo Limitado!",
                    "img" => "img/dados.gif", 
                    "ref" => "dados.php");

$arr[] = Array(     "desc" => "Cara o Sello UDP: Tienes un 50% de probabilidades de ganar!!! En este juego apuestas cara o sello y te llevas el 1.5 de lo apostado.",
                    "img" => "img/cos.gif", 
                    "ref" => "cos.php");

?>


<html>
    <body role="main" class="bd-bck text-white">
      <?php if(isset($_SESSION["user"])){ ?>
        <br>
        <center><h3>Bienvenido(a) <?php echo $_SESSION["user"]["name"]; ?>  </center>
      <center><h4>Tienes $<?php echo $_SESSION["user"]["monto"]; ?> Coins.</h4></center> <?php } ?>
        <div class="album py-5">
          <div class="container">      
            <div class="row">
              <?php
              foreach ($arr as $prod) {
              ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img class="bd-placeholder-img card-img-top" src="<?php echo $prod["img"]; ?> " width="100%" height="225">
                  <div class="card-body text-dark">
                    <p class="card-text"> <?php echo $prod["desc"]; ?> </p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary"> <a href="<?php echo $prod["ref"]; ?> ">Juega YA!</a></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              }
              ?>
            </div>  
        </div>

        <h4 class="text-center">Importante Últimas Noticias UDP.</h4>
        <div id="carouselExampleCaptions" class="carousel slide container" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/covid.jpg" class="d-block w-100" alt="..." height="400px">
              <div class="carousel-caption d-none d-md-block"> 
                <h5>De a poco derrotamos el covid.</h5>
                <p>Para el año 2021 aseguran cientificos que terminará la pandemia, ya que la cura en Chile estara disponibles para todos.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/udp.png" class="d-block w-100" alt="..." height="400px">
              <div class="carousel-caption d-none d-md-block">
                <h5>Universidad Diego Portales abre su biblioteca.</h5>
                <p class="text-light bg-dark">UDP abre sus puertas de la Biblioteca Nicanor Parra para los estudiantes, este es su lugar de libertad, estar tranquilos y sin interrupciones para un estudio dedicado.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/casino.jpg" class="d-block w-100" alt="..." height="400px">
              <div class="carousel-caption d-none d-md-block">
                <h5>Casino UDP abre sus puertas.</h5>
                <p>Unas entretención asegurada para las personas en tiempos de pandemia, casino online para apostar con tus amigos y conocer personas.</p>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>

      <div class="card text-center shadow-lg p-3 mb-5 bg-white rounded container text-dark">
        <div class="card-header ">
          Mantenimiento.
        </div>
        <div class="card-body">
          <h5 class="card-title">Pronto mas juegos.</h5>
          <p class="card-text">Estamos trabajando para que este Casino UDP sea mejor dia a dia. Si le gusta nuestro Casino y quiere hacer un aporte para los servidores, el mantenimiento, y al admin pobre, entonces donenos.</p>
          <a href="#" class="btn btn-secondary">Donar ACA</a>
        </div>
        <div class="card-footer text-muted">
          Ultima actualización 26/09/20.
        </div>
      </div>

    </body>

</html>

<?php
include_once("footer.php");
?>