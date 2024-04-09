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
    <link rel="icon" href="picture/Logo.png">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/proveedores.css">
    <title>Proveïdors | Despensa García Haro</title>

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
    
    <div class="contenedor-proveedor">
        <div class="contenido-proveedor">
            <h1>ELS NOSTRES PROVEïDORS</h1>
            <div class="logos">
            <?php  
                $sql = $conn->prepare("SELECT * FROM proveedor");
                $sql->execute();
                $resultado = $sql->get_result();

                foreach($resultado as $row){

                    $id = $row['Id_Proveedor'];
                    $Nombre_Marca = $row['Nombre_Marca'];
                    $enlace_web = $row['enlace_web'];
                    $Logo_Marca = $row['Logo_Marca'];
                    $encodeImage = base64_encode($Logo_Marca);
                    echo "
                    <div class='logo'>
                        <a href='$enlace_web' target='_blank'>
                            <img src='data:image/png;base64,$encodeImage' alt='$Nombre_Marca'>
                        </a>
                    </div>
                ";}
            ?>
            </div>
        </div>
    </div>
    <footer>
        <div class="contenido-footer">
            <div class="medio-izquierda">
                <h1>CATEGORIES</h1>
                <div class="enlaces-categorias">
                    <a href="cataleg.php">CATÀLEG</a>
                    <a href="aviso.php">PROVEÏDORS</a>
                    <a href="aviso.php">CONTACTE</a>
                </div>
            </div>
            <div class="medio-derecha">
                <h1>POLITIQUES</h1>
                <div class="politicas">
                    <a href="aviso.php">PRIVACITAT</a>
                    <a href="aviso.php">DEVOLUCIONS</a>
                    <a href="aviso.php">COOKIES</a>
                    <a href="aviso.php">PAGAMENT</a>
                </div>
            </div>
            <div class="derecha">
                <h1>AJUDA I CONTACTE</h1>
                <div class="contacto">
                    <p class="titulo-contacto">Correu</p>
                    <p>despensagarciaharo@despensagaha.es</p>
                    <p class="titulo-contacto">Telèfon</p>
                    <p>(+34) 132 645 897</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>