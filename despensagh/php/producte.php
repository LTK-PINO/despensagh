<?php

include_once('../bd/conex.php');


// Verificar si hay una sesión de usuario iniciada
if (!isset($_SESSION["Usuari"]) || $_SESSION["Usuari"] == "") {
    header("Location: ../login.php");
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

if(isset($_POST['boton_añadir_carrito'])){
    if(isset($_POST['nombre_producto'], $_POST['precio_producto'], $_POST['imagen_producto'], $_GET['id'])) {
        $nombreproducto = $_POST['nombre_producto'];
        $ImagenProducto = $_POST['imagen_producto'];
        $precioproducto = $_POST['precio_producto'];
        $cantidad = 1;
        $id = $_GET['id'];
        
        // Preparar la consulta
        $stmt = $conn->prepare("SELECT * FROM carrito WHERE Nombre_Producto = ? AND Usuario = ?");
        $stmt->bind_param("ss", $nombreproducto, $Usuari);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $message[] = 'El producto ya está agregado al carrito de compras';
        } else {
            // Preparar la consulta de inserción
            $stmt = $conn->prepare("INSERT INTO carrito (Usuario, Id_Producto, Nombre_Producto, Imagen, Precio_Venta, Cantidad) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissdi", $Usuari, $id, $nombreproducto, $ImagenProducto, $precioproducto, $cantidad);
            
            if($stmt->execute()) {
                $message[] = 'Producto agregado al carrito de compras';
            } else {
                $message[] = 'Error al agregar el producto al carrito de compras';
            }
        }
    } else {
        $message[] = 'Faltan datos del formulario';
    }
}




    echo '<!DOCTYPE html>
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
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/productes.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Veient producte</title>
    </head>';

?>
    <body>
    <header>
        <div class="publicidad">
            <p>Envios gratuits superiors a 90€</p>
        </div>
        <nav class="navegacion">
            <div class="option-nav">
                <a href="../index.php">
                    <img src="../picture/Logo.png" alt="logo fgh.inc">
                </a>
            </div>
            <div class="option-nav">
                <a href="../cataleg.php">CATÀLEG</a>
                <ul class="submenu">
                    <li><a href="pernil.php">PERNILL</a></li>
                    <li><a href="embotit.php">EMBOTIT</a></li>
                    <li><a href="formatge.php">FORMATGE</a></li>
                </ul>
            </div>                   
            <div class="option-nav">
                <a href="../aviso.php">PROVEÏDORS</a>
            </div>
            <div class="option-nav">
                <a href="../aviso.php">CONTACTE</a>
            </div>       
            <div class="search">
                <form action="../resultado.php" method="POST">
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
                    <a href="../aviso.php"><span class="material-symbols-outlined google-icon">favorite</span></a>
                </div>
                <div class="option-derecha-nav">
                    <a href="../aviso.php"><span class="material-symbols-outlined google-icon">person</span></a>
                    <ul class="submenu">
                        <?php 
                       
                        if(isset($_SESSION["rol"])){
                            if($_SESSION["rol"]== "Admin"){
                                echo '
                                <li><a href="../aviso.php">Perfil</a></li>
                                <li><a href="panel-de-control.php">Panel de Control</a></li>
                                <li><a href="logout.php">Tancar Sessió <span class="material-symbols-outlined">logout</span></a></li>';
                            }else{
                                echo '
                                <li><a href="../aviso.php">Perfil</a></li>
                                <li><a href="logout.php">Tancar Sessió <span class="material-symbols-outlined">logout</span></a></li>';
                            }
                            
                        }
                        ?>
                    </ul>
                </div>
                <div class="option-derecha-nav">
                    <a href="../aviso.php"><span class="material-symbols-outlined google-icon">shopping_bag</span></a>
                </div>
            </div>
        </nav>
    </header>
    <?php  
            $id = $_GET['id'];

            $sql = $conn->prepare("SELECT * FROM productos WHERE id_producto = $id");
            $sql->execute();
            $resultado = $sql->get_result();

            foreach($resultado as $row){

                $id = $row['id_producto'];
                $nombreproducto = $row['Nombre_producto'];
                $precioproducto = $row['Precio_Venta'];
                $categoriaproducto = $row['Categoria'];
                $descripcionproducto = $row['Descripcion'];
                $origenproducto = $row['Origen'];
                $imagen_decodificada = $row['Imagen'];
                $encodeImage = base64_encode($imagen_decodificada);



                echo "
                    <div class='contenedor-producto'>
                        <div class='contenido-izquierda-imagen'>
                            <img src='data:image/png;base64,$encodeImage'/>
                        </div>
                        <div class='contenido-derecha'>
                            <div class='contenido-texto-h1'>
                                <h1>$nombreproducto</h1>
                            </div>
                            <div class='contenido-texto-categoria'>
                                <p>- $categoriaproducto</p>
                            </div>
                            <div class='contenido-texto-origen'>
                                <p>Origen: $origenproducto</p>
                            </div>
                            <div class='contenido-texto-precio'>
                                <p>Preu: $precioproducto €</p>
                            </div>
                            <div class='contenido-texto-descripcion'>
                                <p class='titulo-descripcion'>DESCRIPCIÓ</p>
                                <p>$descripcionproducto</p>
                            </div>
                            <form method='post' enctype='multipart/form-data' action=''>
                                <input type='hidden' name='id' value='<?php echo $id; ?>'>
                                <input type='hidden' name='nombre_producto' value='$nombreproducto'>
                                <input type='hidden' name='precio_producto' value='$precioproducto'>
                                <input type='hidden' name='imagen_producto' value='$encodeImage'>
                                <div class='contenido-botones'>
                                    <div class='boton-cesta-favorito'>
                                        <button onclick=\"location.href='#'\" type=\"button\">Afegir a favorits <span class='material-symbols-outlined'>favorite</span></button>
                                    </div>
                                    <div class='boton-cesta'>
                                        <button name='boton_añadir_carrito' type='submit'>Afegir a la cistella <span class='material-symbols-outlined'>shopping_bag</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                ";}
            
        ?>
    <footer>
        <div class="contenido-footer">
            <div class="medio-izquierda">
                <h1>CATEGORIES</h1>
                <div class="enlaces-categorias">
                    <a href="../cataleg.php">CATÀLEG</a>
                    <a href="../aviso.php">PROVEÏDORS</a>
                    <a href="../aviso.php">CONTACTE</a>
                </div>
            </div>
            <div class="medio-derecha">
                <h1>POLITIQUES</h1>
                <div class="politicas">
                    <a href="../aviso.php">PRIVACITAT</a>
                    <a href="../aviso.php">DEVOLUCIONS</a>
                    <a href="../aviso.php">COOKIES</a>
                    <a href="../aviso.php">PAGAMENT</a>
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