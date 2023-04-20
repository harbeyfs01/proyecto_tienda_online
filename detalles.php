<?php

require 'config/config.php';
require 'config/databae.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id']: '';
$token = isset($_GET['id']) ? $_GET['token']: '';

if ($id == '' || $token == ''){
    echo 'Error al procesar la peticion';
    exit;
} else {
    $token_tmp =has_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        #--consultas
        $sql = $con->prepare("SELECT count(id) FROM produtos WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM produtos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetchAll(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_descuento = $precio - (($precio * $descuento) / 100);
            $dir_images = "images/productos/" . $id.'/';
            
            $rutaImg = $dir_images . 'principal.jpg';

            if (!file_exists($rutaImg)) {
                $rutaImg = 'images/no-photo.jpg';
            }

            $images = array();
            if (file_exists($die_images)){
                $dir = dir($dir_images);

                while(($archivo = $dir->read()) != false) {
                    if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                        $imagenes[] =$dir_images . $archivo;
                    }
                }
                $dir->close();
            } 
        } else {
        echo 'Error al procesar la peticion';
        exit;
        }
    } else {
        echo 'Error al procesar la peticion';
        exit;
    }
}

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=evice-width, initial-scale=1.0">
    <title> Tienda Online </title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" 
    crossorigin="anonymous">

    <link href=css/estilos.css rel="stylesheet">
</head>

<body>
    <!--Barra de navegacion-->
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <strong> Tienda Online </strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-base-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <u1 class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class ="nav-link active"> Catalogo </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"> Contacto </a>
                        </li>
                    </u1>
                    <a href="carrito.php" class="btn btn-primary"> 
                    Carrito <span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
                     </a>
                </div>
            </div>
        </div>
    </header>

    <!--Contenido-->
    <main>
        <div class="container">
            <div>
                <img src="images/products/1/principal.jpg">
            </div>
            <div>
                <h2> <?php echo $nombre; ?> </h2>
                <?php if ($descuento > 0) { ?>
                    <p><del> <?php echo MONEDA . number_format($precio, 2, ',', '.'); ?> </del></p>
                    <h2> 
                        <?php echo MONEDA . number_format($precio_desc, 2, ',', '.'); ?> 
                        <small class="text-success"> <?php echo $descuento; ?> % descuento </small>
                    </h2>
                <?php
                } else { ?>

                <h2> <?php echo MONEDA . number_format($precio, 2, ',', '.'); ?> </h2>
                <?php } ?>

                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>
                <div class="d-grid gap-3 col-10 mx-auto">
                    <button class="btn btn-primary" type="button"> Comprar ahora </button>
                    <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo
                    $id; ?>, '<?php echo $token_tmp; ?>')"> Agregar al carrito </button>
                </div>
            </div> 
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" 
    crossorigin="anonymous"></script>
    
    <script>
        function addProducto(id, token){
            let url ='clases/carrito.php'
            let formData =new formData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url,{
                method: 'POST',
                body: formData,
                mode:'cors'
            }).then(response => response.jason())
            .then(data =>{
                if(data.ok){
                    let elemento = document.getElementById("num_cart") 
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>
</body>