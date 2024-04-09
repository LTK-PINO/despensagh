<?php

require '../../bd/conex.php';

if (!isset($_SESSION["Usuari"]) || empty($_SESSION["Usuari"])) {
    header("Location: ../../login.php");
    exit();
}

if(isset($_POST["submit"])) {
    // Obtener los datos del formulario
    $ID_Producto = $_POST["ID_Producto"];
    $Nombre_Producto = $_POST["Nombre_Producto"];
    $Precio_Venta = $_POST["Precio_Venta"];
    $Precio_Compra = $_POST["Precio_Compra"];
    $Piezas_stock = $_POST["Piezas_stock"];
    $Descripcion = $_POST["Descripcion"];
    $Origen = $_POST["Origen"];
    $Populares = $_POST["Populares"];
    $Categoria = $_POST["Categoria"];
    $ImagenProducto = addslashes(file_get_contents($_FILES['Imagen']['tmp_name']));
    $Usuario = $_POST["Usuario"];


    // Insertar en la base de datos
    $query = "INSERT INTO productos (id_producto, Nombre_Producto, Precio_Venta, Precio_Compra, Piezas_stock, Descripcion, Origen, Populares, Categoria, Imagen, Usuario)
    VALUES ($ID_Producto, '$Nombre_Producto', $Precio_Venta, $Precio_Compra, $Piezas_stock, '$Descripcion', '$Origen', '$Populares', '$Categoria', '$ImagenProducto', '$Usuario')";
    
    if(mysqli_query($conn, $query)) {
        echo "<script> alert('Has afegit correctament el producte'); window.location.href = '../../panel-de-control.php'; </script>";
        exit();
    } else {
        echo "<script> alert('Error al insertar en la base de datos');</script>";
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
    <link rel="icon" href="../../picture/Logo.png">
    <link rel="stylesheet" href="../../css/panel-de-control.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <title>Afegin Producte</title>
</head>
<body>
    <div class="body">
        <form class="contenedor-formulario-añadirproducto" name='form' action="" method="post" enctype="multipart/form-data">
            <div class="formulario-añadirproducto">
                <h1>Afegir nou producte</h1>
                <div class="contenido-formulario-añadirproducto">
                    <input type="text" name="ID_Producto" id="ID_Producto" required placeholder="ID del Producte" autocomplete="off">
                    <input type="text" name="Nombre_Producto" id="Nombre_Producto" required placeholder="Nom del Producte" autocomplete="off">
                    <input type="text" name="Precio_Venta" id="Precio_Venta" required placeholder="Preu Venta" autocomplete="off">
                    <input type="text" name="Precio_Compra" id="Precio_Compra" required placeholder="Preu Compra" autocomplete="off">
                    <input type="text" name="Piezas_stock" id="Piezas_stock" required placeholder="Peces stock" autocomplete="off">
                    <textarea name="Descripcion" id="Descripcion" autocomplete="off"></textarea>
                    <input type="text" name="Origen" id="Origen" required placeholder="Origen" autocomplete="off">  
                    <input type="text" name="Populares" id="Populares" required placeholder="Populars" autocomplete="off">  
                    <input type="text" name="Categoria" id="Categoria" required placeholder="Categories" autocomplete="off">  
                    <input type="file" name="Imagen" id="Imagen" required autocomplete="off">  
                    <input type="text" name="Usuario" id="Usuario" required placeholder="Usuari" autocomplete="off">
                    <input type="submit" name="submit" value="AFEGIR PRODUCTE" class="btn-submit">
                    <input type="button" value="CANCEL·LAR" onclick="window.location.href='../../panel-de-control.php'" class="btn-cancel">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
