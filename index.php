<?php

require 'config/databae.php';
$db = new Database();
$con = $db->conectar();

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
    <link href="url del bootstrap" rel=
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-base-target="#navbarHeader.....
                    <span class="navbar-toggler-icon"> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <u1 class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class ="nav-link active"> catalogo </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"> Contacto </a>
                        </li>
                    </u1>
                    <a href="carrito.php" class="btn btn-primary"> Carrito </a>
                </div>
            </div>
        </div>
    </header>

    <!--Contenido-->
    <main>
        <div class="container">
            <div class="row row-col-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($resultado as $row){ ?>
                    <div class="col">
                        <div class="card shadow-sm">
                    
                            <?php
                            $id = $row['id'];
                            $image = "images/productos/" . $id "/principal.jpg";

                            if (!file_exists($imagen)){
                                $imagen = "images/no-photo.jpg"
                            }
                            ?>    
                    
                            <img src="<?php echo $imagen; ?>">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo $row['nombre']; ?> </h5>
                                <p class="card-text"> <?php echo number_format($row['precio'], 2, ',', '.'); ?> </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-primary"> Detalles </a>
                                    </div>
                                    <a href="#" class=btn btn-success"> Agregar </a>
                                </div>
                            </div>
                        </div>
                </div>
                ?>
            </div>
        </div>
    </main>

</body>





