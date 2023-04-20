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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" 
    crossorigin="anonymous">

    
    integrity="sha384-18mE4kWBq78iYhFldvKuhfTaU
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" 
    crossorigin="anonymous"></script>

</body>





