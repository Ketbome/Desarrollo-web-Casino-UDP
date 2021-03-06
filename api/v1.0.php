<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require '../vendor/autoload.php';
use MongoDB\Client;
$client = new Client('mongodb://localhost:27017');
$ruta = (explode("v1.0.php/", $_SERVER['REQUEST_URI'])[1]);
$ruta = explode("/", $ruta);


switch($ruta[0]){
    case "history":
        if($_SESSION["user"]["name"]){
            $transacciones = $client -> casino -> transacciones;
            $arr = $transacciones->find(array(username => $_SESSION["user"]["name"]));
            echo json_encode(iterator_to_array($arr));
        }else{
            echo json_encode(false);
        }
    break;

    case "login":
        if(!isset($_POST["name"])){
            echo json_encode(array('messsage'=>'No hay usuario'));
            die();
        }
        if(!isset($_POST["password"])){
            echo json_encode(array('messsage'=>'No hay contraseña'));
            die();
        }
        $client = new Client('mongodb://localhost:27017');
        $usuarios = $client -> casino -> usuarios;
        $usr = $usuarios->find(array(username=>$_POST["name"],pass=>$_POST["password"]));
        $login = false;
        foreach($usr as $u){
            $login = true;
            $dinero = $u['monto'];
            $nombre = $u["username"];
            $ganadas = $u["wins"];
        }

        if($login){
            $_SESSION["user"] = Array("name" => $nombre, "password" => $_POST["password"], "monto" => $dinero, "wins" => $ganadas);
            echo json_encode(Array("monto" => $dinero, "wins" => $ganadas));
        }else{
            echo json_encode(false);
        };
    break;

    case "logout":
        session_destroy();
        echo json_encode(true);
    break;

    case "register":
        $usuarios = $client -> casino -> usuarios;
        $reg=true;
        $usr = $usuarios->find(array(username => $_POST["name"]));
        foreach ($usr as $u) {
            $reg=false;
        }
        if($reg){
            $usuarios->insertOne([
                'username' => $_POST["name"],
                'email' => $_POST["email"],
                'pass' => $_POST["password"],
                'wins' => 0,
                'monto' => 100000,
            ]);
            $_SESSION["user"] = Array("name" => $_POST["name"], "password" => $_POST["password"], "monto" => 100000, "wins"=>0);
            echo json_encode(Array("message" => "Listo!", 'tipo' => 1));
        }else{
            echo json_encode(array('message'=>'Ya existe un usuario con ese nombre.', 'tipo' => 0));
        } 
    break;

    case "ruleta":
        $transacciones = $client -> casino -> transacciones;
        $usuarios = $client -> casino -> usuarios;
        $randomNumber = rand(0,36);
        if($_SESSION["user"]["name"]){
            $numero = $_POST["numero"];
            $dinero = $_POST["dinero"];
            if( isset($dinero) && isset($numero) && $dinero > 0 ){
                if($_SESSION["user"]["monto"]>=$dinero){
                    if($_POST["numero"] == $randomNumber){
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
                        echo json_encode(array('message'=>'Has ganado(Bailas) ha salido el numero elegido. Que Suerte!!! Al parecer hoy es tu dia!!! Has ganado '.$_POST["dinero"]*6 .' Coins.', 'randomNumber' => $randomNumber, 'tipo'=> 2));
                    }else{
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
                        echo json_encode(array('message'=>'Has perdido. Salio el número '.$randomNumber.' y tu elegiste el '.$_POST["numero"].'. Sigue intentandolo, no te rindas... Has perdido '.$_POST["dinero"].' Coins.', 'randomNumber' => $randomNumber, 'tipo'=> 1));
                    }
                }else{
                    echo json_encode(array('message'=>'No tienes tanto dinero, carga tu dinero.'));
                }
            }else{
                echo json_encode(array('message'=>'Debe ingresar un número y dinero de apuesta.'));
            }
        }else{
            echo json_encode(false);
        }
    break;

    case "dados":
        $transacciones = $client -> casino -> transacciones;
        $usuarios = $client -> casino -> usuarios;
        $Dado1 = rand(1,6);
        $Dado2 = rand(1,6);
        if($_SESSION["user"]["name"]){
            if(isset($_POST["dinero"]) && isset($_POST["numero"]) && $_POST["dinero"] > 0){
                if($_POST["dinero"]<$_SESSION["user"]["monto"]){
                    $dinero = $_POST["dinero"];
                    $numero = $_POST["numero"];
                    $sum = $Dado1 + $Dado2;
                    
                    if( $sum == $numero){
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
                    echo json_encode(array('messsage'=>'Has ganado(Bailas) ha salido la suma de Dados elegido. Que Suerte!!! Al parecer hoy es tu dia!!! Has ganado '.$_POST["dinero"]*2 .' Coins.'));
                    }else{
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
                    echo json_encode(array('messsage'=>'Has perdido y has sido golpeado. Salio el Dado '.$Dado1.' y '.$Dado2.' lo cual da una suma de '.$sum.' tu elegiste el '.$numero.'. Sigue intentandolo, no te rindas... Has perdido '.$dinero.' Coins.'));
                    }
                }else{
                    echo json_encode(array('message'=>'No te alcanza el dinero.'));
                }
              }else{
                echo json_encode(array('messsage'=>'Ingresa bien los datos.'));
              }
        }else{
            echo json_encode(false);
        }
    break;

    case "cos"://cara o sello
        $transacciones = $client -> casino -> transacciones;
        $usuarios = $client -> casino -> usuarios;
        $cos = rand(1,2);
        if($_SESSION["user"]["name"]){
            if(isset($_POST["dinero"]) && isset($_POST["numero"]) && $_POST["dinero"] > 0){
                if($_POST["dinero"]<$_SESSION["user"]["monto"]){
                    $dinero = $_POST["dinero"];
                    $numero = $_POST["numero"];
                    if( $cos == $numero){
                    $transacciones->insertOne([
                        'username' => $_SESSION["user"]["name"],
                        'tipo' => "Cara o Sello",
                        'monto' => $dinero/2,
                    ]);
                    $_SESSION["user"]["monto"] += $dinero/2;
                    $_SESSION["user"]["wins"]+=1;
                    $usuarios->findOneAndUpdate(
                        [ 'username' => $_SESSION["user"]["name"]],
                        [ '$set' => [ 'monto' => $_SESSION["user"]["monto"], 'wins' => $_SESSION["user"]["wins"] ]]
                    );
                    echo json_encode(array('messsage'=>'Has ganado ha salido el lado elegido. Que Suerte!!! Al parecer hoy es tu dia!!! Has ganado '.$_POST["dinero"]*1.5 .' Coins.'));
                    }else{
                    $transacciones->insertOne([
                        'username' => $_SESSION["user"]["name"],
                        'tipo' => "Cara o Sello",
                        'monto' => -$dinero,
                    ]);
                    $_SESSION["user"]["monto"] -= $dinero;
                    $usuarios->findOneAndUpdate(
                        [ 'username' => $_SESSION["user"]["name"]],
                        [ '$set' => [ 'monto' => $_SESSION["user"]["monto"]]]
                    );
                    echo json_encode(array('messsage'=>'Has perdido. Salio el otro lado. Sigue intentandolo, no te rindas... Has perdido '.$dinero.' Coins.'));
                    }
                }else{
                    echo json_encode(array('message'=>'No te alcanza el dinero.'));
                }
              }else{
                echo json_encode(array('message'=>'Ingresa bien los datos.'));
              }
        }else{
            echo json_encode(false);
        }
    break;

    case "dinero":
        if($_SESSION["user"]["name"]){
            echo json_encode(Array("monto" => $_SESSION["user"]["monto"]));
        }else{
            echo json_encode(false);
        }
    break;

    case "recargar":
        if($_SESSION["user"]["name"]){
            $usuarios = $client -> casino -> usuarios;
            $transacciones = $client -> casino -> transacciones;

            if(isset($_POST["recarga"])){
                $suma = $_POST["recarga"];
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
                    echo json_encode(Array("message" => "Listo!"));
                }else{
                    echo json_encode(array('messsage'=>'Para que la recarga sea exitosa debe ser entre 1 - 100000 Coins. Si tienes mas de 1m no puedes recargar mas.'));
                }
            }else{
                echo json_encode(array('messsage'=>'Ingrese su recarga. Nota: No puedes tener mas de 1m de Coins.'));
            }
        }else{
            echo json_encode(false);
        }
    break;

    default:
        echo "API v 1.0";

}
?>