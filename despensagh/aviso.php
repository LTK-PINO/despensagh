<?php
include_once('bd/conex.php');


// Verificar si hay una sesión de usuario iniciada
if (!isset($_SESSION["Usuari"]) || $_SESSION["Usuari"] == "") {
    header("Location: login.php");
    exit();
} else {
    $Usuari = $_SESSION["Usuari"];

    // Realizar la consulta para obtener los datos del usuario
    $query = "SELECT * FROM usuarios WHERE Usuario = '$Usuari'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }
    }
}

?>


<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"/>
    <link rel="icon" href="../picture/Logo.png">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/aviso.css">
    <title>PAGINA EN MANTENIMIENTO</title>
</head>
<body>
<header>
        <div class="publicidad">
            <p>Envios gratuits superiors a 90€</p>
        </div>
        <nav class="navegacion">
            <div class="option-nav">
                <a href="index.php">
                    <img src="picture/Logo.png" alt="logo fgh.inc">
                </a>
            </div>
            <div class="option-nav">
                <a href="cataleg.php">CATÀLEG</a>
                <ul class="submenu">
                    <li><a href="php/pernil.php">PERNILL</a></li>
                    <li><a href="php/embotit.php">EMBOTIT</a></li>
                    <li><a href="php/formatge.php">FORMATGE</a></li>
                </ul>
            </div>                   
            <div class="option-nav">
                <a href="aviso.php">PROVEÏDORS</a>
            </div>
            <div class="option-nav">
                <a href="aviso.php">CONTACTE</a>
            </div>       
            <div class="search">
                <form action="resultado.php" method="POST">
                    <div class="contenedor-search">
                        <div class="icono-search">
                            <button type="submit" class="button-icono-search">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                        </div>
                        <div>
                            <input name="buscar" class="buscar" type="search" value="" placeholder="BUSCAR">
                        </div>
                    </div>
                </form>
            </div>
            <div class="option-nav-derecha">
                <div class="option-derecha-nav">
                    <a href="aviso.php"><span class="material-symbols-outlined google-icon">favorite</span></a>
                </div>
                <div class="option-derecha-nav">
                    <a href="aviso.php"><span class="material-symbols-outlined google-icon">person</span></a>
                    <ul class="submenu">
                        <?php 
                       
                        if(isset($_SESSION["rol"])){
                            if($_SESSION["rol"]== "Admin"){
                                echo '
                                <li><a href="aviso.php">Perfil</a></li>
                                <li><a href="panel-de-control.php">Panel de Control</a></li>
                                <li><a href="php/logout.php">Tancar Sessió <span class="material-symbols-outlined">logout</span></a></li>';
                            }else{
                                echo '
                                <li><a href="aviso.php">Perfil</a></li>
                                <li><a href="php/logout.php">Tancar Sessió <span class="material-symbols-outlined">logout</span></a></li>';
                            }
                            
                        }
                        ?>
                    </ul>
                </div>
                <div class="option-derecha-nav">
                    <a href="aviso.php"><span class="material-symbols-outlined google-icon">shopping_bag</span></a>
                </div>
            </div>
        </nav>
    </header>
    <div class="maintenance-notice">
    <h1>Avís de Manteniment</h1>
    <p>Aquesta pàgina estarà disponible, una vegada s'hagin fet les millores del 3r Trimestre.</p>
    <button class="boton-home" onclick="location.href='index.php'" type="button">Anar al inici <span class="material-symbols-outlined">home</span></button></a>
    </div>
                   


</body>
</html>