<?php
require 'bd/conex.php';

// Verificar si hay una sesión de usuario iniciada
if (isset($_SESSION["Usuari"])) {
    // Si hay una sesión iniciada, redirigir al usuario al index
    header("Location: index.php");
    exit();
}

if(isset($_POST["submit"])){
    $UsuariCorreu = $_POST["usuaricorreu"];
    $Contrasenya = $_POST["contrasenya"];
    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE Usuario = '$UsuariCorreu' OR Correo = '$UsuariCorreu'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)> 0){
        if(password_verify($Contrasenya, $row["Contraseña"])){
            $_SESSION['Usuari'] = $row["Usuario"];

            if($row["Usuario"] == "Admin"){
                $_SESSION["rol"] = "Admin";
            }else{
                $_SESSION["rol"] = "User";
            }
            echo "<script> alert('Has iniciat sessió correctament'); window.location.href = 'index.php'; </script>";
        }
        else{
            echo "<script> alert('La contrasenya està malament'); </script>";
        }
    }
    else{
        echo "<script> alert('Aquest usuari no existeix'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici de Sessió | Despensa Garcia Haro</title>
    <link rel="icon" href="picture/Logo.png">
    <link rel="stylesheet" href="css/register-login.css">

</head>
<body>
    <div class="body">
        <form class="contenedor-formulario" name='form' action="" method="post">
        <img src="picture/logo.png" alt="Logo Despensa Garcia Haro">
            <div class="formulario">
            <h1>Iniciar Sessió</h1>
                <div class="contenido-formulario">
                    <input type="text" name="usuaricorreu" id="usuaricorreu" required placeholder="Usuari o Correu" value="" autocomplete="off"><br>
                    <input type="password" name="contrasenya" id="contrasenya" required value="" placeholder="Contrasenya"><br>
                    <input type="submit" name="submit" value="Iniciar Sesion" class="btn-submit">
                    <p class="register-login"><a href="register.php">¿No hi tens compte?</a></p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>