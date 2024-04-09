<?php
    require '../bd/conex.php';
    $_SESSION =[];
    // LIMPIAR LO QUE HAY ALMACENADO EN LA SESIÓN USUARIO
    $_SESSION['Usuari'] = "";
    // LIMPIAR LO QUE HAY ALMACENADO EN LA SESIÓN ROL
    $_SESSION["rol"] = "";
    session_unset();
    session_destroy();
    header("Location: http://localhost/login.php");
?>
