<?php
// Configuración de la base de datos
$connection = mysqli_connect("localhost", "root", "", "coctel_de_los_batidos") or die("Could not connect to DB");

// Verificar conexión
if (!$connection) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// SQL para eliminar registros con status = 1
$sql = "DELETE FROM cart WHERE status = 1";

if (mysqli_query($connection, $sql)) {
    echo "Registros eliminados correctamente";
} else {
    echo "Error eliminando registros: " . mysqli_error($connection);
}

mysqli_close($connection);
?>