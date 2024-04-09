<?php
include_once('../../bd/conex.php');


if (!isset($_SESSION["Usuari"]) || empty($_SESSION["Usuari"])) {
  header("Location: ../../login.php");
  exit();
}

$id = $_GET['id'];

$sql = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
$sql->bind_param("i", $id);
$sql->execute();
$resultado = $sql->get_result();

if ($resultado->num_rows > 0) {
  $row = $resultado->fetch_assoc();

  $id = $row['id_producto'];
  $nombreproducto = $row['Nombre_producto'];
  $precioventa = $row['Precio_Venta'];
  $preciocompra = $row['Precio_Compra'];
  $piezasstock = $row['Piezas_stock'];
  $descripcionproducto = $row['Descripcion'];
  $origenproducto = $row['Origen'];
  $popularproducto = $row['Populares'];
  $categoriaproducto = $row['Categoria'];
  $Usuario = $row['Usuario'];
}

if (isset($_POST["submit"])) {
  $id = $_POST['id_producto'];
  $nombreproducto = $_POST['Nombre_producto'];
  $precioventa = $_POST['Precio_Venta'];
  $preciocompra = $_POST['Precio_Compra'];
  $piezasstock = $_POST['Piezas_stock'];
  $descripcionproducto = $_POST['Descripcion'];
  $origenproducto = $_POST['Origen'];
  $popularproducto = $_POST['Populares'];
  $categoriaproducto = $_POST['Categoria'];
  $Usuario = $_POST['Usuario'];

  // Verificar si se proporciona una nueva imagen
  if (isset($_FILES['Imagen']) && $_FILES['Imagen']['size'] > 0) {
    // Obtener el contenido de la imagen
    $imagen_temp = $_FILES['Imagen']['tmp_name'];
    $imagen_contenido = file_get_contents($imagen_temp);

    // Preparar la consulta SQL para actualizar la imagen
    $query = "UPDATE productos SET Nombre_producto = ?, Precio_Venta = ?, Precio_Compra = ?, Piezas_stock = ?, Descripcion = ?, Origen = ?, Populares = ?, Categoria = ?, Imagen = ?, Usuario = ? WHERE id_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sddissssssi", $nombreproducto, $precioventa, $preciocompra, $piezasstock, $descripcionproducto, $origenproducto, $popularproducto, $categoriaproducto, $imagen_contenido, $Usuario, $id);
  } else {
    // Si no se proporciona una nueva imagen, mantener la imagen existente
    $query = "UPDATE productos SET Nombre_producto = ?, Precio_Venta = ?, Precio_Compra = ?, Piezas_stock = ?, Descripcion = ?, Origen = ?, Populares = ?, Categoria = ?, Usuario = ? WHERE id_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sddisssssi", $nombreproducto, $precioventa, $preciocompra, $piezasstock, $descripcionproducto, $origenproducto, $popularproducto, $categoriaproducto, $Usuario, $id);
  }

  // Ejecutar la consulta
  $stmt->execute();
  // Redirigir después de la actualización
  header("Location: ../../panel-de-control.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editant: <?php echo $nombreproducto; ?></title>
  <link rel="stylesheet" href="../../css/panel-de-control.css">
  <link rel="icon" href="../../picture/Logo.png">
</head>

<body>
  <div class="body">
    <form class="contenedor-formulario-añadirproducto" name="form" action="" method="post" enctype="multipart/form-data">
      <div class="formulario-añadirproducto">
        <h1>Editant el producte</h1>
        <div class="contenido-formulario-añadirproducto">
          <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
          <input type="text" name="Nombre_producto" id="Nombre_producto" value="<?php echo $nombreproducto; ?>" autocomplete="off">
          <input type="text" name="Precio_Venta" id="Precio_Venta" value="<?php echo $precioventa; ?>" autocomplete="off">
          <input type="text" name="Precio_Compra" id="Precio_Compra" value="<?php echo $preciocompra; ?>" autocomplete="off">
          <input type="text" name="Piezas_stock" id="Piezas_stock" value="<?php echo $piezasstock; ?>" autocomplete="off">
          <textarea name="Descripcion" id="Descripcion" autocomplete="off"><?php echo $descripcionproducto; ?></textarea>
          <input type="text" name="Origen" id="Origen" value="<?php echo $origenproducto; ?>" autocomplete="off">
          <input type="text" name="Populares" id="Populares" value="<?php echo $popularproducto; ?>" autocomplete="off">
          <input type="text" name="Categoria" id="Categoria" value="<?php echo $categoriaproducto; ?>" autocomplete="off">
          <input type="file" name="Imagen" id="Imagen" autocomplete="off">
          <input type="text" name="Usuario" id="Usuario" value="<?php echo $Usuario; ?>" autocomplete="off">
          <input type="submit" name="submit" value="CONFIRMAR ELS CANVIS" class="btn-submit">
          <input type="button" value="CANCEL·LAR" onclick="window.location.href='../../panel-de-control.php'" class="btn-cancel">
        </div>
      </div>
    </form>
  </div>
</body>

</html>
