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
        <link rel="stylesheet" href="./edit.css">
        <title>Editar Producto</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <style>
            .close_ocult {
                display: none;
            }
        </style>
    </head>

    <body>

        <div class="container">

            <nav>
                <div class="wrapper_nav">

                    <div class="logo"><a href="../menu_admin/menu.php"><img src="./assets/coctel.jpg" alt="" width="50"
                                height="50"></a></div>
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
                                        <a href="../tasa_cambio/cambio.php">Tasa del día</a>
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

                <?php
                if (@$_GET['answer'] == 1) { ?>
                    <h2 class="h2_1">Its edition was successful</h2>
                    <meta http-equiv="refresh" content="2; url = ../show/show.php" />
                <?php }
                if (@$_GET['answer'] == 2) { ?>
                    <h2 class="h2_2">There were problems registering, please try again later</h2>
                    <meta http-equiv="refresh" content="3; url = ../show/show.php" />
                <?php
                }

                if (isset($_GET['answer'])) {
                } else {
                ?>

                    <form action="../../controller/actions.php" method="post" class="form-box" enctype="multipart/form-data"
                        id="productForm">

                        <div class="register-container" id="register">

                            <div class="top">
                                <header>Editar Producto</header>
                            </div>

                            <div class="two-forms">

                                <?php
                                include "../../controller/connection.php";

                                // Obtener el ID del producto a editar
                                $product_id = $_GET['e'];

                                // Consulta para obtener los detalles del producto y la categoría
                                $sql = "SELECT p.*, c.name_category 
                                FROM product p 
                                JOIN category c ON p.id_category = c.id 
                                WHERE p.id_product = '$product_id'";

                                $consult = mysqli_query($connection, $sql);
                                $ver = mysqli_fetch_array($consult);

                                // Consulta para obtener todas las categorías
                                $sql_categories = "SELECT id, name_category FROM category WHERE status = 1";
                                $result = mysqli_query($connection, $sql_categories);
                                ?>

                                <input type="hidden" name="numberId" value="<?php echo $ver[0]; ?>">

                                <div class="input-box">
                                    <input type="text" class="input-field" placeholder="Nombre del Producto" name="name"
                                        id="productName" value="<?php echo $ver[2]; ?>">
                                    <i class='bx bxs-food-menu iconoOne'></i>
                                    <div class="error_two"></div>
                                </div>

                                <div class="input-box select">
                                    <select class="input-field select-custom" name="id_category" id="productCategory">
                                        <option value="" disabled selected>Elegir una Categoría</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = $row['id'] == $ver['id_category'] ? 'selected' : '';
                                            echo "<option value='{$row['id']}' $selected>{$row['name_category']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <i class='bx bxs-category'></i>
                                    <div class="error_two"></div>
                                </div>

                            </div>

                            <div class="two-forms">

                                <div class="input-box">
                                    <input type="text" class="input-field" placeholder="Precio" name="price" id="productPrice"
                                        value="<?php echo $ver[5]; ?>">
                                    <i class='bx bxs-dollar-circle'></i>
                                    <div class="error_two"></div>
                                </div>

                                <div class="input-box select">
                                    <select class="input-field select-custom" name="status" id="productAvailability">
                                        <option value="" disabled>Elegir Disponibilidad</option>
                                        <option value="1" <?php if ($ver['status'] == 1)
                                                                echo 'selected'; ?>>Disponible</option>
                                        <option value="2" <?php if ($ver['status'] == 2)
                                                                echo 'selected'; ?>>No Disponible</option>
                                    </select>
                                    <i class='bx bx-stats'></i>
                                    <div class="error_two"></div>
                                </div>

                            </div>

                            <div class="input-box">
                                <input type="date" class="input-field" placeholder="Fecha" name="date" id="productDate"
                                    value="<?php echo $ver[6]; ?>">
                                <i class='bx bxs-calendar'></i>
                                <div class="error"></div>
                            </div>

                            <div class="input-box_2 img_edit">
                                <div class="img-area_2">
                                    <label for="#">Imagen Actual:</label>
                                    <img src="../../img/<?php echo basename($ver['img_product']); ?>" alt="Imagen Actual"
                                        width="100">
                                </div>
                            </div>

                            <div class="input-box_2">
                                <input type="file" name="img" id="file" accept="image/*" hidden>
                                <div class="img-area" data-img="">
                                    <i class='bx bxs-image-alt icon'></i>
                                    <h3>Imagen</h3>
                                    <p>La imagen debe ser inferior a <span>2MB</span></p>
                                </div>
                                <div class="select-image" id="select-image">
                                    <p>Cambiar imagen</p>
                                </div>
                            </div>
                            <div id="imageError" class="error_2"></div>

                            <div class="input-box close_ocult">
                                <textarea class="textarea-field" placeholder="Descripción" maxlength="150" name="description"
                                    id="productDescription"><?php echo $ver[3]; ?></textarea>
                                <i class='bx bxs-comment-detail textarea-icon'></i>
                                <div class="error"></div>
                            </div>

                            <input type="hidden" name="hidden" value="5">

                            <div class="input-box">
                                <input type="submit" class="submit" value="Subir Cambios">
                            </div>

                        </div>
                    </form>

                <?php } ?>

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
                } else {
                    // For image error
                    const imageErrorDisplay = document.getElementById('imageError');
                    imageErrorDisplay.innerText = message;
                    imageErrorDisplay.style.display = 'block';
                }
            }

            const setSuccess = (element) => {
                const errorDisplay = element.parentElement.querySelector(".error, .error_two");
                if (errorDisplay) {
                    errorDisplay.innerText = '';
                    errorDisplay.style.display = 'none';
                } else {
                    // For image error
                    const imageErrorDisplay = document.getElementById('imageError');
                    imageErrorDisplay.innerText = '';
                    imageErrorDisplay.style.display = 'none';
                }
            }

            const isValidDate = (selectedDate) => {
                // Obtener la fecha actual ajustada a tu zona horaria (Venezuela Time)
                let currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0); // Establecer la hora a 00:00:00

                // Formatear las fechas para comparación 'YYYY-MM-DD'
                const currentDateString = currentDate.toISOString().split('T')[0];
                const selectedDateObject = new Date(selectedDate);
                const selectedDateString = selectedDateObject.toISOString().split('T')[0];

                return selectedDateString >= currentDateString;
            }

            document.getElementById('productForm').addEventListener('submit', function(event) {
                const productName = document.getElementById('productName');
                const productCategory = document.getElementById('productCategory');
                const productPrice = document.getElementById('productPrice');
                const productAvailability = document.getElementById('productAvailability');
                const productDate = document.getElementById('productDate');
                const file = document.getElementById('file');
                const currentImage = document.querySelector('.img-area_2 img'); // Selección de la imagen actual
                let valid = true;

                // Limpiar mensajes de error
                document.querySelectorAll('.error, .error_two').forEach((el) => el.innerHTML = '');

                if (productName.value.trim() === '') {
                    setError(productName, 'El nombre del producto es requerido.');
                    valid = false;
                } else {
                    setSuccess(productName);
                }

                if (productCategory.value.trim() === '') {
                    setError(productCategory, 'La categoría es requerida.');
                    valid = false;
                } else {
                    setSuccess(productCategory);
                }

                if (productPrice.value.trim() === '') {
                    setError(productPrice, 'El precio es requerido.');
                    valid = false;
                } else {
                    setSuccess(productPrice);
                }

                if (productAvailability.value.trim() === '') {
                    setError(productAvailability, 'La disponibilidad es requerida');
                    valid = false;
                } else {
                    setSuccess(productAvailability);
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

                // Verificar la imagen actual 
                if (file.value.trim() === '' && (!currentImage || currentImage.src.trim() === '')) {
                    setError(file, 'La imagen es requerida.');
                    valid = false;
                } else {
                    setSuccess(file);

                }

                if (!valid) {
                    event.preventDefault();
                }
            });

            document.querySelector('.select-image').addEventListener('click', function() {
                document.querySelector('#file').click();
            })

            document.querySelector('#file').addEventListener('change', function() {
                const image = this.files[0];
                if (image.size < 2000000) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        const allImg = document.querySelector('.img-area').querySelectorAll('img');
                        allImg.forEach(item => item.remove());
                        const imgUrl = reader.result;
                        const img = document.createElement('img');
                        img.src = imgUrl;
                        document.querySelector('.img-area').appendChild(img);
                        document.querySelector('.img-area').classList.add('active');
                        document.querySelector('.img-area').dataset.img = image.name;
                        setSuccess(document.querySelector('#file')); // Set success when image is valid
                    }
                    reader.readAsDataURL(image);
                } else {
                    alert("Image size more than 2MB");
                    setError(document.querySelector('#file'), 'La imagen debe ser inferior a 2MB.');
                }
            })
        </script>


        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>

    </html>
<?php } else {
    header("location:../login/login.php?answer=6");
} ?>