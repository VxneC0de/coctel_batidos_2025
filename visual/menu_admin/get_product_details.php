<?php
include "../../controller/connection.php";

$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT p.*, c.name_category 
        FROM product p 
        JOIN category c ON p.id_category = c.id
        WHERE p.id_product = $product_id AND p.status IN (1, 2)";
$result = mysqli_query($connection, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

mysqli_close($connection);
?>

