<?php
include_once("header.php");
$transacciones = $client -> casino -> transacciones;
$usuarios = $client -> casino -> usuarios;

$ap = "display:none;";
$Dado1 = rand(1,6);
$Dado2 = rand(1,6);
if(isset($_SESSION["user"])){
  $message = "<p>Mucha suerte!</p>";
  if(isset($_GET["dinero"]) && isset($_GET["numero"]) && $_GET["dinero"] > 0){
    if($_GET["dinero"]<$_SESSION["user"]["monto"]){
      $dinero = $_GET["dinero"];
      $numero = $_GET["numero"];
      $sum = $Dado1 + $Dado2;
      
      if( $sum == $numero){
        $img = "img/$img_g.gif";
        $ap = "display:block;";
        $transacciones->insertOne([
          'username' => $_SESSION["user"]["name"],
          'tipo' => "Dados",
          'monto' => $dinero*2,
        ]);
        $_SESSION["user"]["monto"] += $dinero*2;
        $_SESSION["user"]["wins"]+=1;
        $usuarios->findOneAndUpdate(
          [ 'username' => $_SESSION["user"]["name"]],
          [ '$set' => [ 'monto' => $_SESSION["user"]["monto"], 'wins' => $_SESSION["user"]["wins"] ]]
        );
        $message = "<p> Has ganado(Bailas) ha salido la suma de Dados elegido. Que Suerte!!! Al parecer hoy es tu dia!!! Has ganado ".$_GET["dinero"]*2 ." Coins.</p>";
      }else{
        $img = "img/$img_p.gif";
        $ap = "display:block;";
        $transacciones->insertOne([
          'username' => $_SESSION["user"]["name"],
          'tipo' => "Dados",
          'monto' => -$dinero,
        ]);
        $_SESSION["user"]["monto"] -= $dinero;
        $usuarios->findOneAndUpdate(
          [ 'username' => $_SESSION["user"]["name"]],
          [ '$set' => [ 'monto' => $_SESSION["user"]["monto"]]]
        );
        $message = "<p> Has perdido y has sido golpeado. Salio el Dado ".$Dado1." y ".$Dado2." lo cual da una suma de ".$sum." tu elegiste el ".$numero.". Sigue intentandolo, no te rindas... Has perdido ".$dinero." Coins.</p>";
      }
    }else{
      $message = "<p>No te alcanza el dinero.</p>";
    }
  }else{
    $message = "<p>Ingresa bien los datos.</p>";
  }
}else{
  $message = "<p>Debes ingresar con una cuenta.</p>";
}

//Ultimo ganador
$last = $transacciones->find(array(monto=>['$gte'=>0], tipo => "Dados"));
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
    <body class="bd-bck text-white text-center">
        <h3>Dados!</h3>
        <p>Elige un numero entre el 2 al 12, se tiraran dos dados a la suerte, la suma de ellos dara el numero de victoria.</p>
        <img src="img/dados.jpg" class="rounded mx-auto d-block" alt="..." height="400px">
        <?php if(isset($_SESSION["user"])){ ?>
        <div class="text-center">
            <form class="text-center form-group">
            <h5>Apuesta:</h5>
            <input type="hidden" name="juego" value="dados"/>
            <div for="dinero"> <p>Ingrese Monto de Apuesta: <input name="dinero" type="number" placeholder="Ejemplo: $5000"></p></div>
            <div for="numero"> <p>Ingrese Número de Dados: <input name="numero" type="number" placeholder="Numero entre 1-12"></p></div>
        <?php } ?>
            <center><div> <?php print ($message); ?> </div></center>
        <?php if(isset($_SESSION["user"])){ ?>
            <div><button type="submit" class="btn btn-outline-warning mb-2" >Apostar</button></div>
            <center style=<?php echo $ap ?>><img width="300" src=<?php echo $img; ?>></center>

            </form>

        </div>

        <?php }
        if(isset($ganador)){
        ?>
        <h4 class="container">Ultimo ganador de Dados</h4>
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