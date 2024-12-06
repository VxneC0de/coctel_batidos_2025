<?php
include "../../controller/connection.php"; // Ajusta esta ruta según tu estructura de directorios

$product_id = $_GET['product_id'];

$sql_product_name = "SELECT name_product FROM product WHERE id_product = '$product_id'";
$result_product_name = mysqli_query($connection, $sql_product_name);
$row_product_name = mysqli_fetch_assoc($result_product_name);
$product_name = $row_product_name['name_product'] ?? 'Producto desconocido';

echo $product_name;
?>
