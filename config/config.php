<?php

define("KEY_TOKEN", "HCA-04@u23#5");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SSSION['carrito']['producto']);
}
?>