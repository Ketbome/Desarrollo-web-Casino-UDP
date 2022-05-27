<?php
include_once("header.php");
$transacciones = $client -> casino -> transacciones;
$arr = $transacciones->find(array(username => $_SESSION["user"]["name"]));
$i=0;
?>
<body class="bd-bck">
    <br>
    <center><h3 class="text-white">Transacciones</h3></center>
<table class="table container">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Tipo</th>
      <th scope="col">Coins</th>
    </tr>
  </thead>
  <tbody class="table-info">
        <?php
        foreach ($arr as $prod) {
            $i += 1;
        ?>
        <tr>
        <th scope="row"><?php echo $i; ?></th>
        <td><?php echo $prod["username"]; ?></td>
        <td><?php echo $prod["tipo"]; ?></td>
        <td><?php echo $prod["monto"]; ?></td>
        </tr>
        <?php } ?>
  </tbody>
</table>

</body>
<?php
include_once("footer.php");
?>