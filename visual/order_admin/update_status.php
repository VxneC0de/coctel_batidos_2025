<?php
include "../../controller/connection.php"; 
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status_pedido = $_POST['status_pedido'];

    // Actualizar el estado del pedido
    $sql = "UPDATE orders SET status='$status_pedido' WHERE id_order='$order_id'";

    if (mysqli_query($connection, $sql)) {
        header("Location:./order.php?answer=1"); // Redirige a la página correspondiente con un mensaje de éxito
    } else {
        header("Location:./order.php?answer=2"); // Redirige a la página correspondiente con un mensaje de error
    }
}
?>
