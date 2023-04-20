<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();
if($productos != null){
    foreach ($productos as $clave => $cantidad){
        #--consulta
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id = ? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th> Producto </th>
                            <th> Precio </th>
                            <th> Cantidad </th>
                            <th> Subtotal </th>
                            <th>  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_carrito == null) {
                            echo '<tr><td colspan="5" class="text-center"><b> Lista vacia </b> </td> </tr>';
                        } 
                        else {
                            $total = 0;
                            foreach($lista_carrito as $producto){
                                $_id = $producto['id'];
                                $nombre = $producto['nombre'];
                                $precio = $producto['precio'];
                                $descuento = $producto['descuento'];
                                $precio_desc = $precio - (($precio * $descuento) / 100);
                                $subtotal = $cantidad * $precio_desc;
                                $total += $subtotal;
                            ?>
                            
                        <tr>
                            <td> <?php echo $nombre ?> </td>
                            <td> <?php echo MONEDA . number_format($precio_desc,2, ',', '.'); ?> </td>
                            <td> 
                                <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>"
                                size="5" id="cantidad_ <?php echo $_id; ?>" onchange="">
                            </td>
                            <td> 
                                <div id="subtotal_ <?php echo $_id; ?>" name="subtotal[]"> 
                                <?php echo MONEDA . number_format($subtotal,2, ',', '.');?> 
                                </div>    
                            </td>
                            <td>
                                <a href="#" id="eliminar" class="btn ntn-warning btn-sm" data-bs-id="<?php echo $_id ?>" 
                                data-bs-toogle="modal" data-bs-target="eliminaModal"> Eliminar </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <?php } ?>
                <table>
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