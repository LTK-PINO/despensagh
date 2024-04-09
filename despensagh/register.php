<?php

require 'bd/conex.php';

// Verificar si hay una sesión de usuario iniciada
if (!empty($_SESSION["Usuari"])) {
    // Si hay una sesión iniciada, redirigir al usuario al index
    header("Location: index.php");
    exit();
}

if(isset($_POST["submit"])){
    $Nom = $_POST["Nom"];
    $Cognoms = $_POST["Cognoms"];
    $Correu = $_POST["Correu"];
    $Usuari = $_POST["Usuari"];
    $Contrasenya = $_POST["Contrasenya"];
    $ConfirmarContrasenya = $_POST["ConfirmarContrasenya"];
    
    if($Contrasenya === $ConfirmarContrasenya){
        // Cifra la contraseña
        $hashed_password = password_hash($Contrasenya, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO usuarios (Nombre, Apellidos, Correo, Usuario, Contraseña) VALUES ('$Nom', '$Cognoms','$Correu', '$Usuari', '$hashed_password')";
        mysqli_query($conn, $query);
        echo "<script> alert('Has estat registrat correctament'); window.location.href = 'login.php'; </script>";
    } else {
        echo "<script> alert('Les contrasenyes no coincideixen'); window.location.href = 'register.php'; </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre | Despensa Garcia Haro</title>
    <link rel="icon" href="picture/Logo.png">
    <link rel="stylesheet" href="css/register-login.css">

</head>
<body>
    <div class="body">
        <form class="contenedor-formulario" name='form' action="" method="post">
            <img src="picture/logo.png" alt="Logo Despensa Garcia Haro">
            <div class="formulario">
                <h1>Donar d'alta un compte</h1>
                <div class="contenido-formulario">
                    <input type="text" name="Nom" id="Nom" required placeholder="Nom" autocomplete="off">
                    <input type="text" name="Cognoms" id="Cognoms" required placeholder="Cognoms" autocomplete="off">
                    <input type="text" name="Correu" id="Correu" required placeholder="Correu electrònic" autocomplete="off">
                    <input type="text" name="Usuari" id="Usuari" required placeholder="Nom usuari" autocomplete="off">
                    <input type="password" id="Contrasenya" name="Contrasenya" required placeholder="Contrasenya">
                    <input type="password" id="ConfirmarContrasenya" name="ConfirmarContrasenya" required placeholder="Confirmar contrasenya">
                    <input type="submit" name="submit" value="Registrar compta" class="btn-submit">
                    <p class="register-login">¿Ja tens compte? <a href="login.php">Inicia sessió</a></p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
