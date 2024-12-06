<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['who'])) { ?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="./cambio.css">
        <title>Tasa de Cambio</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    </head>

    <body>

        <?php
        include "../../controller/connection.php";
        include "../../controller/details.php";
        ?>

        <div class="container">

            <nav>
                <div class="wrapper_nav">

                    <div class="logo"><a href="../menu_admin/menu.php"><img src="./assets/coctel.jpg" alt="" width="50" height="50"></a></div>
                    <input type="radio" name="slider" id="menu-btn">
                    <input type="radio" name="slider" id="close-btn">

                    <ul class="nav-links">

                        <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                        <li><a href="../menu_admin/menu.php">Tienda</a></li>

                        <li>

                            <a href="#" class="desktop-item">Productos ▾</a>
                            <input type="checkbox" id="showDrop">
                            <label for="showDrop" class="mobile-item">Productos ▾</label>

                            <ul class="drop-menu">
                                <li><a href="../upload/upload.php">Subir Producto</a></li>
                                <li><a href="../show/show.php">Ver Productos</a></li>
                            </ul>

                        </li>

                        <li><a href="../order_admin/order.php">Ordenes</a></li>

                    </ul>

                    <div class="header-right">

                        <div class="user_icon">
                            <a href="#"><ion-icon name="person"></ion-icon></a>
                        </div>

                    </div>

                    <div class="user_sidebar">

                        <button class="close_user"><i class="fas fa-times"></i></button>

                        <div class="user_header">
                            <div class="name_user">
                                <h2><?php echo $_SESSION['nick']; ?></h2>
                            </div>
                            <div class="email_user">
                                <h4><?php echo $_SESSION['email']; ?></h4>
                            </div>
                        </div>

                        <div class="user_items">

                            <div class="user_item">

                                <div class="item_details">
                                    <div class="item_details_title_user">
                                        <i class='bx bx-money'></i>
                                        <a href="./cambio.php">Tasa del día</a>
                                    </div>
                                </div>

                            </div>

                            <div class="user_item">

                                <div class="item_details">
                                    <div class="item_details_title_user">
                                        <i class='bx bx-log-out-circle'></i>
                                        <a href="../../controller/actions.php?hidden=3">Cerrar Sesión</a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>

                </div>
            </nav>

            <section class="content">

                <form action="../../controller/actions.php" method="post" class="form-box" enctype="multipart/form-data" id="tasaForm">
                    <?php
                    include "../../controller/connection.php";

                    if (isset($_SESSION['who'])) {
                        $user_id = $_SESSION['who'];

                        $search = isset($_POST['search']) ? $_POST['search'] : '';

                        $sql = "
                SELECT 
                    id, 
                    tasa_cambio, 
                    fecha_cambio 
                FROM 
                    tasas_de_cambio 
                WHERE 
                    status = 1
            ";

                        $consult = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($consult) > 0) {
                            while ($ver = mysqli_fetch_array($consult)) {
                                $id = $ver['id'];
                                $tasaCambio = $ver['tasa_cambio'];
                                $fechaCambio = $ver['fecha_cambio'];
                    ?>
                                <div class="register-container" id="register">
                                    <div class="top">
                                        <header>Tasa del día</header>
                                    </div>

                                    <div class="input-box">
                                        <input type="text" class="input-field" placeholder="Precio" name="precio" id="productPrice" value="<?php echo round($tasaCambio, 3); ?>">
                                        <i class='bx bx-money'></i>
                                        <div class="error"></div>
                                    </div>

                                    <div class="input-box">
                                        <input type="date" class="input-field" placeholder="Fecha" name="date" id="productDate" value="<?php echo $fechaCambio; ?>">
                                        <i class='bx bxs-calendar'></i>
                                        <div class="error"></div>
                                    </div>

                                    <input type="hidden" name="hidden" value="11">

                                    <div class="input-box">
                                        <input type="submit" class="submit" value="Subir">
                                    </div>
                                </div>
                            <?php
                            }
                        } else {

                            ?>
                            <div class="register-container" id="register">
                                <div class="top">
                                    <header>Tasa del día</header>
                                </div>

                                <div class="input-box">
                                    <input type="text" class="input-field" placeholder="Precio" name="precio" id="productPrice" value="">
                                    <i class='bx bx-money'></i>
                                    <div class="error"></div>
                                </div>

                                <div class="input-box">
                                    <input type="date" class="input-field" placeholder="Fecha" name="date" id="productDate" value="">
                                    <i class='bx bxs-calendar'></i>
                                    <div class="error"></div>
                                </div>

                                <input type="hidden" name="hidden" value="11">

                                <div class="input-box">
                                    <input type="submit" class="submit" value="Subir">
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </form>

            </section>

            <footer class="footer">

                <div class="footer-box">

                    <div class="footer-text">
                        <p>&copy; El Cóctel de los Batidos 2025</p>
                    </div>

                    <div class="footer-creater">
                        <a href="#">By VxneC0de</a>
                    </div>

                </div>

            </footer>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const userIcon = document.querySelector('.user_icon a');
                const userSidebar = document.querySelector('.user_sidebar');
                const closeuser = document.querySelector('.close_user');

                userIcon.addEventListener('click', function(event) {
                    event.preventDefault();
                    userSidebar.style.right = '0';
                });

                closeuser.addEventListener('click', function() {
                    userSidebar.style.right = '-100%';
                });

            });
        </script>

        <script>
            const setError = (element, message) => {
                const errorDisplay = element.parentElement.querySelector(".error, .error_two");
                if (errorDisplay) {
                    errorDisplay.innerText = message;
                    errorDisplay.style.display = 'block';
                }
            }

            const setSuccess = element => {
                const errorDisplay = element.parentElement.querySelector(".error, .error_two");
                if (errorDisplay) {
                    errorDisplay.innerText = '';
                    errorDisplay.style.display = 'none';
                }
            }

            const isValidDate = (selectedDate) => {
                let currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0); 
                const currentDateString = currentDate.toISOString().split('T')[0];
                const selectedDateObject = new Date(selectedDate);
                const selectedDateString = selectedDateObject.toISOString().split('T')[0];
                return selectedDateString >= currentDateString;
            }

            document.getElementById('tasaForm').addEventListener('submit', function(event) {
                const productPrice = document.getElementById('productPrice');
                const productDate = document.getElementById('productDate');
                let valid = true;

                // Limpiar mensajes de error
                document.querySelectorAll('.error, .error_two').forEach((el) => el.innerHTML = '');

           
                const priceValue = productPrice.value.trim();
                const validNumberWithDots = /^\d+(\.\d{1,4})?$/; 

                if (priceValue === '') {
                    setError(productPrice, 'El campo es requerido.');
                    valid = false;
                } else if (!validNumberWithDots.test(priceValue) && !priceValue.includes(',')) {
                    setError(productPrice, 'Debe ingresar un valor válido.');
                    valid = false;
                } else if (priceValue.includes(',')) {
                    setError(productPrice, 'Debe separar los decimales con un punto.');
                    valid = false;
                } else {
                    setSuccess(productPrice);
                }


          
                if (productDate.value.trim() === '') {
                    setError(productDate, 'La fecha es requerida.');
                    valid = false;
                } else if (!isValidDate(productDate.value)) {
                    setError(productDate, 'Ingresa una fecha válida.');
                    valid = false;
                } else {
                    setSuccess(productDate);
                }

                if (!valid) {
                    event.preventDefault();
                }
            });
        </script>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>

    </html>
<?php } else {
    header("location:../login/login.php?answer=6");
} ?>