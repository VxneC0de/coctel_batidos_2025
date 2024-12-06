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
        <link rel="stylesheet" href="./payment.css">
        <title>Pago</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <style>
            .close_ocult {
                display: none;
            }
        </style>
    </head>

    <body>

        <?php
        include "../../controller/connection.php";
        include "../../controller/details.php";
        ?>

        <nav>

            <div class="wrapper_nav">

                <div class="logo"><a href="../menu_login/menu.php"><img src="./assets/coctel.jpg" alt="" width="50"
                            height="50"></a></div>
                <input type="radio" name="slider" id="menu-btn">
                <input type="radio" name="slider" id="close-btn">

                <ul class="nav-links">

                    <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                    <li><a href="../../menu_login/menu.php">Inicio</a></li>

                </ul>

                <div class="header-right">

                    <div class="cart_icon">
                        <a href="#"><ion-icon name="cart"></ion-icon></a>
                        <span id="cart_total_amount">Bs. 0,00</span>
                    </div>

                </div>

                <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>

            </div>

        </nav>

        <section class="section_container form_order">


            <?php if (!empty($errorMessage)): ?>
                <div class="error-message" style="color:red;">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <div class="payment_div">

                <header>Orden</header>

                <form action="../../controller/actions.php" method="post" enctype="multipart/form-data" class="form_payment"
                    id="orderForm">

                    <div class="error_div">

                        <div class="container_error">
                        </div>

                    </div>

                    <div class="data">

                        <h3 class="title_form">Mi contacto</h3>

                        <div class="input-box">
                            <label>Nombre <span>*</span></label>
                            <input type="text" name="namePay" id="firstName" />
                        </div>

                        <div class="input-box">
                            <label>Apellido <span>*</span></label>
                            <input type="text" name="lasnamePay" id="lastName" />
                        </div>

                        <div class="input-box">
                            <label>Teléfono <span>*</span></label>
                            <input type="text" name="phonePay" id="phone" />
                        </div>

                    </div>

                    <div class="data">

                        <h3 class="title_form">Método de envío</h3>

                        <div class="div_envio">

                            <div class="envio">
                                <div class="pickup">Pickup</div>
                            </div>

                        </div>

                    </div>

                    <div class="data">

                        <h3 class="title_form">Punto de recogida</h3>

                        <div class="div_recogida">
                            <p>Calle los Apatames, Edificio número 5, Local único, Caracas.
                                <br>
                                Caracas
                                <br>
                                Capital
                                <br>
                                1011
                            </p>
                        </div>

                    </div>

                    <div class="data">

                        <h3 class="title_form">Notas adicionales</h3>

                        <div class="input-box">
                            <label>Notas del pedido (opcional)</label>
                            <textarea name="notesPay" id="orderNotes" maxlength="150"></textarea>
                        </div>

                        <h5>Seleccionar la hora de recogida</h5>

                        <div class="column">

                            <div class="input-box">
                                <label>Fecha <span>*</span></label>
                                <select id="pickupDate" name="datePay">
                                    <option value="" disabled selected>Elegir fecha</option>
                                    <option value="Hoy">Hoy</option>
                                </select>

                            </div>

                            <div class="input-box">
                                <label>Tiempo <span>*</span></label>
                                <select id="pickupTime" name="hourPay">
                                    <option value="" disabled selected>Elegir tiempo</option>
                                    <option value="Pronto">Tan pronto como sea posible</option>
                                    <option value="7:00-7:30">7:00 - 7:30</option>
                                    <option value="7:30-8:00">7:30 - 8:00</option>
                                    <option value="8:00-8:30">8:00 - 8:30</option>
                                    <option value="8:30-9:00">8:30 - 9:00</option>
                                    <option value="9:00-9:30">9:00 - 9:30</option>
                                    <option value="9:30-10:00">9:30 - 10:00</option>
                                    <option value="10:00-10:30">10:00 - 10:30</option>
                                    <option value="10:30-11:00">10:30 - 11:00</option>
                                    <option value="11:00-11:30">11:00 - 11:30</option>
                                    <option value="11:30-12:00">11:30 - 12:00</option>
                                    <option value="12:30-13:00">12:30 - 13:00</option>
                                </select>
                            </div>


                        </div>

                    </div>

                    <div class="data">

                        <h3 class="title_form">Modo de Pago</h3>

                        <div class="metodos">

                            <div class="payment-option" id="pago-movil">

                                <input type="radio" name="payment_method" id="radio-pago-movil" value="movil">
                                <label for="radio-pago-movil" class="label_pago">Pago Móvil</label>
                                <div class="details_movil" id="details-movil">

                                    <div class="input-box">
                                        <label for="referencia-movil">Ultimos 4 números de la referencia
                                            <span>*</span></label>
                                        <input type="text" name="reference_movil" id="referencia-movil">

                                    </div>

                                    <div class="input-box">
                                        <label for="telefono-movil">Número de telefono donde se hizo el pago
                                            <span>*</span></label>
                                        <input type="text" name="phone_movil" id="telefono-movil">

                                    </div>

                                    <div class="input-box_2">
                                        <input type="file" name="img_movil" id="file-movil" accept="image/*" hidden>
                                        <div class="img-area" data-img="">
                                            <i class='bx bxs-image-alt icon'></i>
                                            <h3 class="title_area">Captura del pago</h3>
                                            <p>La imagen debe ser inferior a <span>2MB</span></p>
                                        </div>
                                        <div class="select-image" id="select-image-movil">
                                            <p>Subir Captura</p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="payment-option" id="efectivo">

                                <input type="radio" name="payment_method" id="radio-efectivo" value="efectivo">
                                <label for="radio-efectivo" class="label_pago">Efectivo</label>
                                <div class="details_efectivo" id="details-efectivo">

                                    <div class="input-box_2">

                                        <input type="file" name="img_efectivo" id="file-efectivo" accept="image/*" hidden>
                                        <div class="img-area" data-img="">
                                            <i class='bx bxs-image-alt icon'></i>
                                            <h3 class="title_area">Captura del pago</h3>
                                            <p>La imagen debe ser inferior a <span>2MB</span></p>
                                        </div>
                                        <div class="select-image" id="select-image-efectivo">
                                            <p>Subir Captura</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="payment-option" id="tarjeta">

                                <input type="radio" name="payment_method" id="radio-tarjeta" value="tarjeta">
                                <label for="radio-tarjeta" class="label_pago">Tarjeta</label>
                                <div class="details_tarjeta" id="details-tarjeta">

                                    <div class="input-box_2 img_edit">
                                        <div class="img-area_2">
                                            <p>Pagar directamente en caja al retirar el pedido</p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <input type="hidden" name="hidden" value="9">

                    <div class="input-box box_submit">
                        <input type="submit" class="submit" value=" Confirmar el pedido">
                    </div>

                </form>

            </div>

        </section>

        <div class="modal_overlay"></div>

        <section class="show_cart">

            <div class="cart_div">

                <div class="cart_header">
                    <h2>RESUMEN DEL PEDIDO</h2>
                </div>

                <div class="cart_container">

                    <form method="post" action="#" class="cart_items">

                        <?php

                        include "../../controller/connection.php";

                        if (isset($_SESSION['who'])) {
                            $user_id = $_SESSION['who'];
                            $search = isset($_POST['search']) ? $_POST['search'] : '';

                            $sql = "
                        SELECT 
                        c.price_cart, 
                        c.quantity_cart, 
                        p.name_product,
                        p.price_product
                        FROM 
                        cart c 
                        JOIN 
                        product p 
                        ON 
                        c.id_product_cart = p.id_product 
                        WHERE 
                        c.id_user_cart = '$user_id' AND 
                        c.status = 1
                        ";

                            $consult = mysqli_query($connection, $sql);
                            $subtotal = 0;

                            while ($ver = mysqli_fetch_array($consult)) {
                                $nameProduct = $ver['name_product'];
                                $priceCart = $ver['price_cart'];
                                $quantityCart = $ver['quantity_cart'];
                                $priceProduct = $ver['price_product'];
                                $totalProduct = $priceProduct * $quantityCart;
                                $subtotal += $totalProduct;
                        ?>

                                <div class="cart_item" data-price-cart="<?php echo $priceCart; ?>"
                                    data-quantity-cart="<?php echo $quantityCart; ?>">

                                    <div class="cart_right">

                                        <div class="item_details">

                                            <div class="item_details_title">
                                                <p><?php echo $nameProduct; ?></p>
                                            </div>

                                            <div class="item_details_price">
                                                <strong>Bs.
                                                    <span><?php echo number_format($priceProduct, 2, ",", "."); ?></span></strong>
                                            </div>
                                        </div>

                                        <div class="quantity">
                                            <strong><label for="productQuantity">Cantidad:</label></strong>
                                            <div class="quantity_control">
                                                <input type="text" id="productQuantity" value="<?php echo $quantityCart; ?>"
                                                    readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="cart_left">

                                        <div class="total">
                                            <div class="item_price_complete">Bs. <span
                                                    class="item_total"><?php echo number_format($totalProduct, 2, '.', ''); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                        <?php
                            }

                            $formattedSubtotal = number_format($subtotal, 2, ',', '.');
                            $formattedTotal = number_format($subtotal, 2, ',', '.');

                            // Obtener la tasa de cambio más reciente de la tabla tasas_de_cambio
                            $tasaSql = "SELECT tasa_cambio FROM tasas_de_cambio ORDER BY fecha_cambio DESC LIMIT 1";
                            $tasaResult = mysqli_query($connection, $tasaSql);

                            if ($tasaResult && mysqli_num_rows($tasaResult) > 0) {
                                $tasaRow = mysqli_fetch_assoc($tasaResult);
                                $tasaCambio = $tasaRow['tasa_cambio'];
                                $totalEfectivo = $subtotal / $tasaCambio;
                                $formattedTotalEfectivo = number_format($totalEfectivo, 2, ',', '.');
                            } else {
                                $tasaCambio = 1; // Valor por defecto en caso de no encontrar la tasa
                                $formattedTotalEfectivo = number_format($subtotal / $tasaCambio, 2, ',', '.');
                            }
                        }
                        ?>

                    </form>

                    <div class="cart_total">

                        <div class="total_data">
                            <span>Subtotal</span>
                            <span class="subtotal_amount">Bs. <?php echo $formattedSubtotal; ?></span>
                        </div>

                        <div class="total_data">
                            <span>Envío</span>
                            <span>--</span>
                        </div>

                        <div class="total_data">
                            <span>TOTAL EN BS</span>
                            <span class="total_amount">Bs. <?php echo $formattedTotal; ?></span>
                        </div>

                        <div class="total_data">
                            <span>TOTAL EN EFECTIVO</span>
                            <span class="total_amount_efectivo">$. <?php echo $formattedTotalEfectivo; ?></span>
                        </div>


                    </div>


                    <div class="cart_close">
                        <button class="close">Cerrar</button>
                    </div>

                </div>

            </div>

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

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const totalAmount = "<?php echo $formattedTotal; ?>";
                document.getElementById('cart_total_amount').innerText = "Bs. " + totalAmount;
            });
        </script>

        <script>
            // Mostrar carrito y fondo de superposición al hacer clic en el icono del carrito

            document.querySelector('.cart_icon').addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.modal_overlay').style.display = 'block';
                document.querySelector('.show_cart').style.display = 'flex';
            });

            // Cerrar carrito y fondo de superposición al hacer clic en el botón de cerrar
            document.querySelector('.close').addEventListener('click', function() {
                document.querySelector('.modal_overlay').style.display = 'none';
                document.querySelector('.show_cart').style.display = 'none';
            });

            // Cerrar el carrito al hacer clic fuera del área del carrito
            document.querySelector('.modal_overlay').addEventListener('click', function() {
                document.querySelector('.modal_overlay').style.display = 'none';
                document.querySelector('.show_cart').style.display = 'none';
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const pickupTimeSelect = document.getElementById('pickupTime');

                const updatePickupTimeOptions = () => {
                    const currentDate = new Date();
                    const currentHour = currentDate.getHours();
                    const currentMinute = currentDate.getMinutes();

                    const timeOptions = [{
                            value: "7:00-7:30",
                            text: "7:00 - 7:30",
                            hour: 7,
                            minute: 0
                        },
                        {
                            value: "7:30-8:00",
                            text: "7:30 - 8:00",
                            hour: 7,
                            minute: 30
                        },
                        {
                            value: "8:00-8:30",
                            text: "8:00 - 8:30",
                            hour: 8,
                            minute: 0
                        },
                        {
                            value: "8:30-9:00",
                            text: "8:30 - 9:00",
                            hour: 8,
                            minute: 30
                        },
                        {
                            value: "9:00-9:30",
                            text: "9:00 - 9:30",
                            hour: 9,
                            minute: 0
                        },
                        {
                            value: "9:30-10:00",
                            text: "9:30 - 10:00",
                            hour: 9,
                            minute: 30
                        },
                        {
                            value: "10:00-10:30",
                            text: "10:00 - 10:30",
                            hour: 10,
                            minute: 0
                        },
                        {
                            value: "10:30-11:00",
                            text: "10:30 - 11:00",
                            hour: 10,
                            minute: 30
                        },
                        {
                            value: "11:00-11:30",
                            text: "11:00 - 11:30",
                            hour: 11,
                            minute: 0
                        },
                        {
                            value: "11:30-12:00",
                            text: "11:30 - 12:00",
                            hour: 11,
                            minute: 30
                        },
                        {
                            value: "12:30-13:00",
                            text: "12:30 - 13:00",
                            hour: 12,
                            minute: 30
                        }
                    ];

                    // Limpiar opciones del select
                    pickupTimeSelect.innerHTML = '<option value="" disabled selected>Elegir tiempo</option>';

                    // Agregar opción "Pronto" si la hora está entre 6:00 y 13:00
                    if (currentHour >= 6 && currentHour < 13) {
                        const opt = document.createElement('option');
                        opt.value = "Pronto";
                        opt.text = "Tan pronto como sea posible";
                        pickupTimeSelect.appendChild(opt);
                    }

                    // Agregar opciones según la hora actual
                    timeOptions.forEach(option => {
                        if (currentHour < option.hour || (currentHour === option.hour && currentMinute <= option.minute)) {
                            const opt = document.createElement('option');
                            opt.value = option.value;
                            opt.text = option.text;
                            pickupTimeSelect.appendChild(opt);
                        }
                    });

                    // Si la hora es mayor o igual a 13:00, quitar todas las opciones
                    if (currentHour >= 13 || currentHour < 6) {
                        pickupTimeSelect.innerHTML = '<option value="" disabled selected>Elegir tiempo</option>';
                    }
                }

                // Actualizar opciones al cargar la página
                updatePickupTimeOptions();

                // Actualizar opciones cada minuto
                setInterval(updatePickupTimeOptions, 60000);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Función para ocultar detalles
                function hideAllDetails() {
                    document.querySelectorAll('.details_movil, .details_efectivo, .details_tarjeta').forEach(detail => {
                        detail.style.display = 'none';
                    });
                }

                // Función para limpiar todos los inputs y áreas de imagen
                function clearInputs() {
                    document.querySelectorAll('.details_movil input, .details_efectivo input, .details_movil textarea, .details_efectivo textarea').forEach(input => {
                        input.value = '';
                    });
                    document.querySelectorAll('.img-area').forEach(imgArea => {
                        imgArea.innerHTML = `
                            <i class='bx bxs-image-alt icon'></i>
                            <h3 class="title_area">Captura del pago</h3>
                            <p>La imagen debe ser inferior a <span>2MB</span></p>
                        `;
                        imgArea.classList.remove('active');
                        imgArea.dataset.img = '';
                    });
                }

                // Listeners para los inputs de tipo radio
                document.querySelector('#radio-pago-movil').addEventListener('click', function() {
                    hideAllDetails();
                    clearInputs();
                    document.querySelector('.details_movil').style.display = 'flex';
                    console.log('Pago Móvil seleccionado');
                });

                document.querySelector('#radio-efectivo').addEventListener('click', function() {
                    hideAllDetails();
                    clearInputs();
                    document.querySelector('.details_efectivo').style.display = 'flex';
                    console.log('Efectivo seleccionado');
                });

                document.querySelector('#radio-tarjeta').addEventListener('click', function() {
                    hideAllDetails();
                    clearInputs();
                    document.querySelector('.details_tarjeta').style.display = 'flex';
                    console.log('Tarjeta seleccionada');
                });


            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const pickupDiv = document.querySelector('.pickup');
                const radioInputs = document.querySelectorAll('input[name="payment_method"]');

                pickupDiv.addEventListener('click', () => {
                    // Desmarcar otros radio inputs
                    radioInputs.forEach(input => input.checked = false);
                    // Remover la clase 'selected' de todos los labels
                    document.querySelectorAll('.payment-option label').forEach(label => {
                        label.classList.remove('selected');
                    });
                    // Agregar la clase 'selected' al div pickup
                    pickupDiv.classList.add('selected');
                });

                // Listener para desmarcar el div pickup cuando un radio input se selecciona
                radioInputs.forEach(input => {
                    input.addEventListener('click', () => {
                        pickupDiv.classList.remove('selected');
                    });
                });
            });
        </script>

        <script>
            const setError = (message) => {
                const errorDisplay = document.querySelector('.container_error');
                const errorItem = document.createElement('p');
                errorItem.innerHTML = message;
                errorDisplay.appendChild(errorItem);
            }

            const clearErrors = () => {
                const errorDisplay = document.querySelector('.container_error');
                while (errorDisplay.firstChild) {
                    errorDisplay.removeChild(errorDisplay.firstChild);
                }
            }

            const isStoreClosed = () => {
                const currentDate = new Date();
                const currentHour = currentDate.getHours();
                return currentHour >= 13 || currentHour < 6;
            }

            document.getElementById('orderForm').addEventListener('submit', function(event) {
                const firstName = document.getElementById('firstName');
                const lastName = document.getElementById('lastName');
                const phone = document.getElementById('phone');
                const pickupDate = document.getElementById('pickupDate');
                const pickupTime = document.getElementById('pickupTime');
                const referenciaMovil = document.getElementById('referencia-movil');
                const telefonoMovil = document.getElementById('telefono-movil');
                const fileMovil = document.getElementById('file-movil');
                const fileEfectivo = document.getElementById('file-efectivo');
                let valid = true;

                // Limpiar mensajes de error
                clearErrors();
                document.querySelector('.error_div').style.display = 'none';
                document.querySelector('.container_error').style.display = 'none';

                if (isStoreClosed()) {
                    setError('La tienda está cerrada.');
                    valid = false;
                }

                if (firstName.value.trim() === '') {
                    setError('Nombre <span>es un campo requerido.</span>');
                    valid = false;
                } else if (!/^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/.test(firstName.value.trim())) {
                    setError('Nombre <span>Debe ingresar un nombre válido.</span>');
                    valid = false;
                }

                if (lastName.value.trim() === '') {
                    setError('Apellido <span>es un campo requerido.</span>');
                    valid = false;
                } else if (!/^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/.test(lastName.value.trim())) {
                    setError('Apellido <span>Debe ingresar un apellido válido.</span>');
                    valid = false;
                }

                if (phone.value.trim() === '') {
                    setError('Teléfono <span>es un campo requerido.</span>');
                    valid = false;
                } else if (!/^\d{11}$/.test(phone.value.trim())) {
                    setError('Teléfono <span>Debe ingresar un número de teléfono válido.</span>');
                    valid = false;
                }

                if (pickupDate.value === '') {
                    setError('Fecha <span>es un campo requerido.</span>');
                    valid = false;
                }

                if (pickupTime.value === '') {
                    setError('Tiempo <span>es un campo requerido.</span>');
                    valid = false;
                }

                if (!document.querySelector('#radio-pago-movil').checked && !document.querySelector('#radio-efectivo').checked && !document.querySelector('#radio-tarjeta').checked) {
                    setError('Método de Pago <span>es un campo requerido.</span>');
                    valid = false;
                }

                if (document.querySelector('#radio-pago-movil').checked) {
                    if (referenciaMovil.value.trim() === '') {
                        setError('Datos del Pago Móvil <span>Referencia es requerida.</span>');
                        valid = false;
                    } else if (!/^\d{4,}$/.test(referenciaMovil.value.trim())) {
                        setError('Datos del Pago Móvil <span>Debe ingresar una referencia válida.</span>');
                        valid = false;
                    }

                    if (telefonoMovil.value.trim() === '') {
                        setError('Datos del Pago Móvil <span>Número de teléfono es requerido.</span>');
                        valid = false;
                    } else if (!/^\d{11,}$/.test(telefonoMovil.value.trim())) {
                        setError('Datos del Pago Móvil <span>Debe ingresar un número de teléfono válido.</span>');
                        valid = false;
                    }

                    if (fileMovil.value.trim() === '') {
                        setError('Datos del Pago Móvil <span>Imagen es requerida.</span>');
                        valid = false;
                    }
                }

                if (document.querySelector('#radio-efectivo').checked) {
                    if (fileEfectivo.value.trim() === '') {
                        setError('Datos del Efectivo <span>Imagen es requerida.</span>');
                        valid = false;
                    }
                }

                if (!valid) {
                    document.querySelector('.error_div').style.display = 'flex';
                    document.querySelector('.container_error').style.display = 'flex';
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    event.preventDefault();
                }
            });

            document.querySelectorAll('.select-image').forEach(selectImage => {
                const inputFile = selectImage.parentElement.querySelector('input[type="file"]');
                const imgArea = selectImage.parentElement.querySelector('.img-area');

                selectImage.addEventListener('click', () => {
                    inputFile.click();
                });

                inputFile.addEventListener('change', () => {
                    const image = inputFile.files[0];
                    if (image.size < 2000000) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            const allImg = imgArea.querySelectorAll('img');
                            allImg.forEach(img => img.remove());
                            const imgUrl = reader.result;
                            const img = document.createElement('img');
                            img.src = imgUrl;
                            imgArea.appendChild(img);
                            imgArea.classList.add('active');
                            imgArea.dataset.img = image.name;
                        }
                        reader.readAsDataURL(image);
                    } else {
                        alert("La imagen debe ser menor a 2MB");
                        setError('Datos del Pago Móvil/Efectivo <span>La imagen debe ser inferior a 2MB</span>');
                    }
                });
            });
        </script>

        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        </script>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>

    </html>
<?php } else {
    header("location:../login/login.php?answer=6");
} ?>