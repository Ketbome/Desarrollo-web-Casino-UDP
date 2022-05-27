<?php
include_once("header.php");
$usuarios = $client -> casino -> usuarios;
$transacciones = $client -> casino -> transacciones;

if(isset($_GET["recarga"])){
    $suma = $_GET["recarga"];
    if($suma > 0 && $suma <= 100000 && $_SESSION["user"]["monto"]+$suma <= 1000000){
        $_SESSION["user"]["monto"] += $suma;
        $usuarios->findOneAndUpdate(
            [ 'username' => $_SESSION["user"]["name"]],
            [ '$set' => [ 'monto' => $_SESSION["user"]["monto"]]]
        );
        $transacciones->insertOne([
            'username' => $_SESSION["user"]["name"],
            'tipo' => "Recarga",
            'monto' => $suma,
        ]);
        $message = "<p>Listo!</p>";
    }else{
        $message = "<p>Para que la recarga sea exitosa debe ser entre 1 - 100000 Coins.</p>";
    }
}else{
    $message = "<p>Ingrese su recarga. Nota: No puedes tener mas de 1m de Coins.</p>";
}
?>
<body class="bd-bck text-white">
    <br>
    <br>
    <center><h3>Recargar</h3></center>
    <br>
    <br>

    <center><form>
        <input type="number" name="recarga" placeholder="Cuanto cargaras?">
        <button>Recargar</button>
    </form></center>
    <center><div> <?php print ($message); ?> </div></center>
</body>
<?php
include_once("footer.php");
?>