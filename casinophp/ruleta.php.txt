<?php
include_once("header.php");
$transacciones = $client -> casino -> transacciones;
$usuarios = $client -> casino -> usuarios;

$randomNumber = rand(0,36);
if(isset($_SESSION["user"])){
  $message = "<p>Mucha Suerte!</p>";
  $numero = $_GET["numero"];
  $dinero = $_GET["dinero"];
if( isset($_GET["dinero"]) && isset($_GET["numero"]) && $dinero > 0 ){
  if($dinero != null && $numero != null){
  if($_SESSION["user"]["monto"]>=$dinero){?>
<script>

$(function(){
  function rotate(numero){
    grados=[180,315,122,200,140,-5,443,238,385,277,365,403,219,64,296,160,335,102,258,151,306,132,267,14,345,112,190,73,228,248,33,287,170,326,92,209,53]
    $("#ruleta-img").css({'transform': 'rotate('+parseInt(3420+grados[numero])+'deg)'});
  }

  rotate(<?php print($randomNumber) ?>);

  setTimeout(function(){ 
    $("#message-ruleta").css({'display': 'block'});
  },4000);
  setTimeout(function(){ 
    $(".img-ruleta").css({'display': 'block'});
  },4000);

});

</script>
  <?php
    if($_GET["numero"] == $randomNumber){
      $img = "img/$img_g.gif";
      $transacciones->insertOne([
        'username' => $_SESSION["user"]["name"],
        'tipo' => "Ruleta",
        'monto' => $dinero*6,
      ]);
      $_SESSION["user"]["monto"] += $dinero*6;
      $_SESSION["user"]["wins"]+=1;
      $usuarios->findOneAndUpdate(
        [ 'username' => $_SESSION["user"]["name"]],
        [ '$set' => [ 'monto' => $_SESSION["user"]["monto"], 'wins' => $_SESSION["user"]["wins"] ]]
      );
      $message = "<p id='message-ruleta' style='display:none;'> Has ganado(Bailas) ha salido el numero elegido. Que Suerte!!! Al parecer hoy es tu dia!!! Has ganado ".$_GET["dinero"]*6 ." Coins.</p>";
    }else{
      $img = "img/$img_p.gif";
      $transacciones->insertOne([
        'username' => $_SESSION["user"]["name"],
        'tipo' => "Ruleta",
        'monto' => -$dinero,
      ]);
      $_SESSION["user"]["monto"] -= $dinero;
      $usuarios->findOneAndUpdate(
        [ 'username' => $_SESSION["user"]["name"]],
        [ '$set' => [ 'monto' => $_SESSION["user"]["monto"]]]
      );
      $message = "<p id='message-ruleta' style='display:none;'> Has perdido y has sido golpeado. Salio el número ".$randomNumber." y tu elegiste el ".$_GET["numero"].". Sigue intentandolo, no te rindas... Has perdido ".$_GET["dinero"]." Coins.</p>";
    }
  }else{
    $message = "<p>No tienes tanto dinero, carga tu dinero.</p>";
  }
  }else{
    $message = "<p>Debe ingresar un número y dinero de apuesta.</p>";
  }
}
}else{
  $message ="<p> Debes tener una cuenta de cliente, ve a ingresar, si no tienes una cuenta Registrate.</p>";
}

//Ultimo ganador
$last = $transacciones->find(array(monto=>['$gte'=>0], tipo => "Ruleta"));
foreach($last as $u){
    $ganador=$u["username"];
    $din_ganado = $u["monto"];
}
$usr = $usuarios->find(array(username=>$ganador));
foreach($usr as $u){
    $ganadas = $u["wins"];
}


?>

<html>
    
    <body class="bd-bck text-white">
        <div class="text-center">
        <h3>Ruleta!</h3>
        <p>Elige un numero entre el 0 al 36, se girará la ruleta y caerá en un número, si le aciertas ganas 6 veces lo que has apostado. Vamos intentalo, Mucho Exito!</p>
        </div>
        <div id="ruleta-img-container" class="card mb-4 shadow-sm center">
          <img id="ruleta-img" src="img/ruleta.png" class="rounded mx-auto d-block" alt="..." width="400">
          <div class="flexwrap arrowed arrow-5"></div>
        </div>
        <?php 
        if(isset($_SESSION["user"])) { ?>
        <form class="text-center form-group">
            <h5>Apuesta:</h5>
            <input type="hidden" name="juego" value="ruleta"/>
            <div for="dinero"> <p>Ingrese Monto de Apuesta: <input name="dinero" type="number" placeholder="Ejemplo: $5000"></p></div>
            <div for="numero"> <p>Ingrese Número de Ruleta: <input name="numero" type="number" placeholder="Numero entre 0-36"></p></div>
        <?php }else{ ?>
            <center><div> <?php print ($message); ?> </div></center>
            <br>
        <?php }
        if(isset($_SESSION["user"])){ ?>
            <div> <?php print ($message); ?> </div>
            <div><button type="submit" class="btn btn-outline-warning mb-2" >Apostar</button></div>
            <center  class="img-ruleta" style="display:none;"><img width="300" src=<?php echo $img; ?>></center>

        </form>
        <?php } 
        if(isset($ganador)){
        ?>
        <h4 class="container">Ultimo ganador de la Ruleta</h4>
        <table class="table table-striped table-dark container">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Total Wins</th>
                <th scope="col">Coins ganadas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td><?php echo $ganador; ?></td>
                <td><?php echo $ganadas; ?></td>
                <td><?php echo $din_ganado; ?></td>
              </tr>
            </tbody>
          </table>
        <?php } ?>

    </body>

</html>

<?php
include_once("footer.php");
?>