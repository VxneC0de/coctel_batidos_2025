<?php

include "connection.php";
session_start(); // Asegúrate de que la sesión esté iniciada para acceder a $_SESSION
extract($_POST);
extract($_GET);

function handleFileUpload($fileKey, $connection)
{
    $file = $_FILES[$fileKey]['tmp_name'];
    $type = $_FILES[$fileKey]['type'];
    $img = "";

    if (isset($file) && !empty($file)) {
        if (strpos($type, "gif") !== false || strpos($type, "jpeg") !== false || strpos($type, "jpg") !== false || strpos($type, "png") !== false) {
            $sql = "SELECT MAX(id_payment) FROM payment";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_array($result);

            if (isset($row[0])) {
                $max = $row[0] + 1;
            } else {
                $max = 1;
            }

            $ext = getimagesize($file);

            if ($ext[2] == IMAGETYPE_GIF) {
                $max = $max . ".gif";
            } elseif ($ext[2] == IMAGETYPE_JPEG) {
                $max = $max . ".jpg";
            } elseif ($ext[2] == IMAGETYPE_PNG) {
                $max = $max . ".png";
            }

            if (is_uploaded_file($file)) {
                if (move_uploaded_file($file, '../img_payment/' . $max)) {
                    $img = '../img_payment/' . $max;
                } else {
                    echo "Error al mover el archivo.";
                }
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Tipo de archivo no permitido.";
        }
    } else {
        echo "No se seleccionó ningún archivo.";
    }

    return $img;
}


switch ($hidden) {
    case 1:
        //REGISTER

        $errors = array();

        $sqlNick = "SELECT COUNT(id) FROM user WHERE nick='$nickRegister'";
        $sqlEmail = "SELECT COUNT(id) FROM user WHERE email='$emailRegister'";

        $conne_1 = mysqli_query($connection, $sqlNick);
        $conne_2 = mysqli_query($connection, $sqlEmail);

        $union_1 = mysqli_fetch_array($conne_1);
        $union_2 = mysqli_fetch_array($conne_2);

        if ($union_1[0] > 0) {
            $errors[] = "nickRegister";
        }

        if ($union_2[0] > 0) {
            $errors[] = "emailRegister";
        }

        if (!empty($errors)) {
            $errorFields = implode(',', $errors);
            header("location:../visual/login/login.php?answer=4&fields=$errorFields&nickRegister=$nickRegister&emailRegister=$emailRegister&errorLogin=1");
        } else {
            $sql = "INSERT INTO user VALUES('', '$nickRegister', '$emailRegister', MD5('$confirmRegister'), 0, 0)";
            if (mysqli_query($connection, $sql)) {
                header("location:../visual/login/login.php?answer=1");
            } else {
                header("location:../visual/login/login.php?answer=2&nickRegister=$nickRegister&emailRegister=$emailRegister");
            }
        }

        break;
    case 2:
        $loginData = $_POST['loginData'];
        $passwordLogin = $_POST['passwordLogin'];

        $sql = "SELECT id, nick, email, status FROM user WHERE (nick = '$loginData' OR email = '$loginData') AND password = MD5('$passwordLogin')";
        $conne = mysqli_query($connection, $sql);

        if ($v = mysqli_fetch_array($conne)) {
            session_start();
            $_SESSION['who'] = $v['id'];
            $_SESSION['nick'] = $v['nick'];
            $_SESSION['email'] = $v['email'];

            if ($v['status'] == 1) {
                header("Location: ../visual/upload/upload.php");
            } else {
                header("Location: ../visual/menu_login/menu.php");
            }
            exit();
        } else {
            $sqlNick = "SELECT COUNT(id) FROM user WHERE nick='$loginData'";
            $sqlEmail = "SELECT COUNT(id) FROM user WHERE email='$loginData'";

            $conneNick = mysqli_query($connection, $sqlNick);
            $conneEmail = mysqli_query($connection, $sqlEmail);

            $countNick = mysqli_fetch_array($conneNick)[0];
            $countEmail = mysqli_fetch_array($conneEmail)[0];

            if ($countNick == 0 && $countEmail == 0) {
                header("Location: ../visual/login/login.php?error=user");
            } else {
                header("Location: ../visual/login/login.php?error=password");
            }
            exit();
        }
        break;
    case 3:

        session_start();

        session_unset();
        session_destroy();
        header("location:../visual/login/login.php");

        break;
    case 4:
        // INSERT

        // IMG

        $file = $_FILES['img']['tmp_name'];
        $type = $_FILES['img']['type'];

        if (strpos($type, "gif") !== false || strpos($type, "jpeg") !== false || strpos($type, "jpg") !== false || strpos($type, "png") !== false) {
            $sql = "SELECT MAX(id_product) FROM product";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_array($result);

            if (isset($row[0])) {
                $max = $row[0] + 1;
            } else {
                $max = 1;
            }

            $ext = getimagesize($file);

            if ($ext[2] == IMAGETYPE_GIF) {
                $max = $max . ".gif";
            } elseif ($ext[2] == IMAGETYPE_JPEG) {
                $max = $max . ".jpg";
            } elseif ($ext[2] == IMAGETYPE_PNG) {
                $max = $max . ".png";
            }

            if (is_uploaded_file($file)) {
                move_uploaded_file($file, '../img/' . $max);
                $img = '../img/' . $max;
            } else {
                echo "Error al subir el archivo.";
            }
        }

        //Sanitizar el valor del precio
        $price = str_replace(',', '.', $_POST['price']);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


        $sql = "INSERT INTO product (id_category, name_product, description_product, img_product, price_product, date_product, quantity_product, status) VALUES ('$id_category', '$name', '$description', '$img', '$price', '$date', '$quantity', '$status')";

        if (mysqli_query($connection, $sql)) {
            header("location:../visual/show/show.php");
        } else {
            header("location:../visual/upload/upload.php?answer=2");
        }

        break;

    case 5:
        // EDIT

        $img = ""; // Inicializamos la variable $img

        // Comprobar si se ha subido una nueva imagen
        if (!empty($_FILES['img']['tmp_name'])) {
            $file = $_FILES['img']['tmp_name'];
            $type = $_FILES['img']['type'];

            if (strpos($type, "gif") !== false || strpos($type, "jpeg") !== false || strpos($type, "jpg") !== false || strpos($type, "png") !== false) {
                $sql = "SELECT MAX(id_product) FROM product";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_array($result);

                if (isset($row[0])) {
                    $max = $row[0] + 1;
                } else {
                    $max = 1;
                }

                $ext = getimagesize($file);

                if ($ext[2] == IMAGETYPE_GIF) {
                    $max = $max . ".gif";
                } elseif ($ext[2] == IMAGETYPE_JPEG) {
                    $max = $max . ".jpg";
                } elseif ($ext[2] == IMAGETYPE_PNG) {
                    $max = $max . ".png";
                }

                if (is_uploaded_file($file)) {
                    move_uploaded_file($file, '../img/' . $max);
                    $img = '../img/' . $max;
                } else {
                    echo "Error al subir el archivo.";
                    exit;
                }
            }
        }

        // Si no se ha subido una nueva imagen, recuperar la imagen existente
        if (empty($img)) {
            $sql = "SELECT img_product FROM product WHERE id_product = '$numberId'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_array($result);
            $img = $row['img_product'];
        }

        $sql = "UPDATE product SET id_category='$id_category', name_product='$name', description_product='$description', img_product='$img', price_product='$price', date_product='$date', status='$status' WHERE id_product='$numberId'";

        if (mysqli_query($connection, $sql)) {
            header("location:../visual/edit/edit.php?answer=1");
        } else {
            header("location:../visual/edit/edit.php?answer=2");
        }

        break;


    case 6:
        // DELETE
        $sql = "UPDATE product SET status=3 WHERE id_product=?";
        if ($statement = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($statement, "i", $e);

            if (mysqli_stmt_execute($statement)) {
                header("location:../visual/show/show.php");
            } else {
                echo "<script>alert('Could not delete');</script>";
                header("location:../visual/show/show.php");
            }

            mysqli_stmt_close($statement);
        } else {
            echo "<script>alert('Query preparation failed');</script>";
            header("location:../visual/show/show.php");
        }
        break;

    case 7:

        $user_id = $_SESSION['who'];

        foreach ($id_product_cart as $index => $product_id) {
            $product_price = $price_cart[$index];
            $product_quantity = $quantity_cart[$index];
            $status_value = $status[$index];

            $query = "INSERT INTO cart (id_user_cart, id_product_cart, price_cart, quantity_cart, status) VALUES ('$user_id', '$product_id', '$product_price', '$product_quantity', '$status_value')";

            $consulta = mysqli_query($connection, $query);

            if (!$consulta) {
                echo "Error: " . mysqli_error($connection);
            }
        }
        header("Location: ../visual/payment/payment.php");
        break;

    case 8:

        // EDIT CARRITO

        foreach ($id_cart as $index => $id_cart_value) {
            $id_user_cart_value = $id_user_cart[$index];
            $id_product_cart_value = $id_product_cart[$index];
            $price_cart_value = $price_cart[$index];
            $quantity_cart_value = $quantity_cart[$index];
            $status_value = $status[$index];

            $sql = "UPDATE cart SET id_user_cart='$id_user_cart_value', id_product_cart='$id_product_cart_value', price_cart='$price_cart_value', quantity_cart='$quantity_cart_value', status='$status_value' WHERE id_cart='$id_cart_value'";

            if (mysqli_query($connection, $sql)) {
                header("Location: ../visual/menu_login/menu.php?answer=1");
            } else {
                header("Location: ../visual/menu_login/menu.php?answer=2");
            }
        }

        break;
    case 9:
        // INSERTAR DATOS DEL PAGO
        $id_user = $_SESSION['who'];
        $id_metodo = ($_POST['payment_method'] == "movil" ? 1 : ($_POST['payment_method'] == "efectivo" ? 2 : 3));
        $name = $_POST['namePay'];
        $lastName = $_POST['lasnamePay'];
        $phone = $_POST['phonePay'];
        $notes = $_POST['notesPay'];
        $date = $_POST['datePay'];
        $hour = $_POST['hourPay'];
        $reference_data = $_POST['reference_movil'] ?: ($_POST['reference_efectivo'] ?: '');
        $reference_phone = $_POST['phone_movil'] ?: ($_POST['phone_efectivo'] ?: '');

        // Manejo de archivos para los dos tipos de pagos
        $img = "";
        if (isset($_FILES['img_movil']['tmp_name']) && !empty($_FILES['img_movil']['tmp_name'])) {
            $img = handleFileUpload('img_movil', $connection);
        } elseif (isset($_FILES['img_efectivo']['tmp_name']) && !empty($_FILES['img_efectivo']['tmp_name'])) {
            $img = handleFileUpload('img_efectivo', $connection);
        }

        $sql_payment = "INSERT INTO payment (id_user_payment, id_metodo_payment, name_payment, lastName_payment, phone_payment, description_payment, date_payment, hour_payment, reference_data, reference_phone, img_payment) 
            VALUES ('$id_user', '$id_metodo', '$name', '$lastName', '$phone', '$notes', '$date', '$hour', '$reference_data', '$reference_phone', '$img')";

        if (mysqli_query($connection, $sql_payment)) {
            $id_payment = mysqli_insert_id($connection); // Obtener el ID del pago recién insertado

            // OBTENER PRODUCTOS DEL CARRITO
            $sql_cart = "SELECT c.id_product_cart, c.quantity_cart, p.price_product
                     FROM cart c 
                     JOIN product p ON c.id_product_cart = p.id_product
                     WHERE c.id_user_cart = '$id_user' AND c.status = 1";
            $result_cart = mysqli_query($connection, $sql_cart);

            $order_details = [];
            $total_bs = 0;
            while ($row_cart = mysqli_fetch_assoc($result_cart)) {
                $id_product = $row_cart['id_product_cart'];
                $quantity = $row_cart['quantity_cart'];
                $price = $row_cart['price_product'];
                $subtotal = $price * $quantity;
                $total_bs += $subtotal;

                // Guardar detalles en un array
                $order_details[] = [
                    'id_product' => $id_product,
                    'price' => $price, // Agregar el precio aquí
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            }

            // Convertir array a JSON para almacenarlo en order_details
            $order_details_json = json_encode($order_details);

            // Obtener la tasa de cambio más reciente
            $tasaSql = "SELECT tasa_cambio FROM tasas_de_cambio ORDER BY fecha_cambio DESC LIMIT 1";
            $tasaResult = mysqli_query($connection, $tasaSql);
            $tasaRow = mysqli_fetch_assoc($tasaResult);
            $tasaCambio = $tasaRow['tasa_cambio'] ?? 1;
            $total_ef = $total_bs / $tasaCambio;

            // INSERTAR NUEVO PEDIDO EN LA TABLA ORDERS
            $sql_order = "INSERT INTO orders (id_user_order, id_payment_order, order_details, total_bs, total_ef, status) 
                      VALUES ('$id_user', '$id_payment', '$order_details_json', '$total_bs', '$total_ef', 1)";

            if (mysqli_query($connection, $sql_order)) {
                $id_order = mysqli_insert_id($connection);

                // ACTUALIZAR EL ESTADO DE TODOS LOS PRODUCTOS EN EL CARRITO A 2
                $sql_update_cart = "UPDATE cart SET status = 2 WHERE id_user_cart = '$id_user' AND status = 1";
                mysqli_query($connection, $sql_update_cart);

                header("Location: ../visual/order_client/order.php");
            } else {
                header("Location: ../visual/payment/payment.php?answer=2");
            }
        } else {
            header("Location: ../visual/payment/payment.php?answer=2");
        }
        break;
    case 10:
        // DELETE from cart
        $sql = "DELETE FROM cart WHERE id_cart=?";
        if ($statement = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($statement, "i", $e);

            if (mysqli_stmt_execute($statement)) {
                header("location:../visual/menu_login/menu.php");
            } else {
                echo "<script>alert('Could not delete');</script>";
                header("location:../visual/menu_login/menu.php");
            }

            mysqli_stmt_close($statement);
        } else {
            echo "<script>alert('Query preparation failed');</script>";
            header("location:../visual/menu_login/menu.php");
        }
        break;
    case 11:
        // Sanitize input values to prevent SQL injection
        $precio = mysqli_real_escape_string($connection, $_POST['precio']);
        $fecha = mysqli_real_escape_string($connection, $_POST['date']);

        // Round the price to three decimal places
        $precio = round($precio, 3);

        // Check if a record already exists for the given date
        $checkSql = "SELECT id FROM tasas_de_cambio WHERE fecha_cambio = '$fecha'";
        $result = mysqli_query($connection, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            // Record exists, perform update
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];

            $sql = "UPDATE tasas_de_cambio SET tasa_cambio = '$precio', fecha_cambio = '$fecha', status = 1 WHERE id = '$id'";

            if (mysqli_query($connection, $sql)) {
                header("location:../visual/menu_admin/menu.php?answer=1");
            } else {
                header("location:../visual/menu_admin/menu.php?answer=2");
            }
        } else {
            // Record does not exist, perform insert
            $sql = "INSERT INTO tasas_de_cambio (tasa_cambio, fecha_cambio, status) VALUES ('$precio', '$fecha', 1)";

            if (mysqli_query($connection, $sql)) {
                header("location:../visual/menu_admin/menu.php?answer=1");
            } else {
                header("location:../visual/menu_admin/menu.php?answer=2");
            }
        }
        break;
    case 12:
        $order_id = $_POST['order_id'];
        $status_pedido = $_POST['status_pedido'];

        // Actualizar el estado del pedido
        $sql = "UPDATE orders SET status='$status_pedido' WHERE id_order='$order_id'";

        if (mysqli_query($connection, $sql)) {
            header("Location:../visual/order_admin/order.php?answer=1"); // Redirige a la página correspondiente con un mensaje de éxito
        } else {
            header("Location:../visual/order_admin/order.php?answer=2"); // Redirige a la página correspondiente con un mensaje de error
        }

        break;
};

?>;