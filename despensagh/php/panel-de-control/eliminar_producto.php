<?php
    require '../../bd/conex.php';


    if (!isset($_SESSION["Usuari"]) || empty($_SESSION["Usuari"])) {
        header("Location: ../../login.php");
        exit();
      }

    $id = $_GET['id'];

    $cnx = mysqli_connect("localhost", "root", "", "bd_despensagh");
    $sql = "DELETE FROM productos WHERE id_producto = $id";
    $rta = mysqli_query($cnx, $sql);
    if (!$rta){
        echo "No se Actualizó!!!";
    }
    else {
        header("Location: ../../panel-de-control.php");
    }
?>