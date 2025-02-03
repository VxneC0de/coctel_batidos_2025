<?php
include "../../controller/connection.php";


$search = isset($_POST['search']) ? $_POST['search'] : '';


$sql = "SELECT p.*, c.name_category 
        FROM product p 
        JOIN category c ON p.id_category = c.id

        ORDER BY p.id_category ASC";

if ($search != '') {
    $sql .= " AND p.name_product LIKE '%$search%'";
}

$consult = mysqli_query($connection, $sql);


$productsByCategory = [];

while ($ver = mysqli_fetch_array($consult)) {
    $productsByCategory[$ver['id_category']][] = $ver;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./menu.css">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.btn_hero_2');

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {

                    <?php if (!isset($_SESSION['who'])): ?>
                        alert('Debe registrarse para poder hacer un pedido.');
                        window.location.href = '../login/login.php';
                    <?php else: ?>

                        alert('Producto agregado al carrito.');
                    <?php endif; ?>
                });
            });
        });
    </script>
    <style>
        .banner_card:nth-child(1) {
            background-image: url("./img/banner-1.png");
        }

        .banner_card:nth-child(2) {
            background-image: url("./img/banner-2.png");
        }

        .banner_card:nth-child(3) {
            background-image: url("./img/banner-3.png");
        }

        .footer {
            background-image: url("./img/footer-bg.png");
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
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

            <div class="logo"><a href="./menu.php"><img src="./img/coctel.jpg" alt="" width="50" height="50"></a></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">

            <ul class="nav-links">

                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="#main">Inicio</a></li>

                <li>
                    <a href="#" class="desktop-item">Productos ▾</a>
                    <input type="checkbox" id="showDrop">
                    <label for="showDrop" class="mobile-item">Productos ▾</label>

                    <ul class="drop-menu">
                        <li><a href="#empanadas" class="menu_item">Empanadas</a></li>
                        <li><a href="#pastelitos" class="menu_item">Pastelitos</a></li>
                        <li><a href="#especiales" class="menu_item">Especiales</a></li>
                        <li><a href="#bebidas" class="menu_item">Bebidas Frías</a></li>
                        <li><a href="#otros" class="menu_item">Otros</a></li>
                    </ul>
                </li>

                <li><a href="#footer">Contactos</a></li>

            </ul>

            <div class="header-right">

                <div class="cart_icon">
                    <a href="#"><ion-icon name="cart"></ion-icon></a>
                    <span>0</span>
                </div>

                <div class="user_icon">
                    <a href="#"><ion-icon name="person"></ion-icon></a>
                </div>

            </div>

            <div class="cart_sidebar">

                <button class="close_cart"><i class="fas fa-times"></i></button>

                <div class="cart_header">
                    <h2>Tu Pedido</h2>
                </div>

                <div class="cart_items">

                    <div class="cart_item">

                        <div class="item_details">
                            <div class="item_details_title">
                                <p>Registrate para hacer tu pedido.</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="user_sidebar">

                <button class="close_user"><i class="fas fa-times"></i></button>

                <div class="user_header">
                    <div class="name_user">
                        <h2>Tu Pedido</h2>
                    </div>
                    <div class="email_user">
                        <h4>Disfruta del sabor de una buena empanada</h4>
                    </div>
                </div>

                <div class="user_items">

                    <div class="user_item">

                        <div class="item_details">
                            <div class="item_details_title_user">
                                <i class='bx bx-log-in-circle'></i>
                                <a href="../login/login.php">Registrate para hacer tu pedido.</a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>

        </div>

    </nav>

    <section class="hero" id="main">

        <div class="header_content">

            <div class="hero_text">
                <h2>#Sabores para cualquier momento</h2>
                <h1>¡El Cóctel de los Batidos 2025 te da la bienvenida!</h1>
                <p>Impulsa tu día con nuestras empanadas, pastelitos y jugos naturales. ¡Disfruta de una combinación perfecta de sabor y energía en tus mañanas!</p>

            </div>

        </div>

        <div class="header_image">
            <img src="./img/hero_2.png" alt="hero" class="img_hero_2">
        </div>

    </section>

    <section class="section_container banner_container">

        <div class="banner_card">
            <p>PRUÉBALAS HOY</p>
            <h4>EMPANADA MÁS POPULAR</h4>
        </div>

        <div class="banner_card">
            <p>PRUÉBALAS HOY</p>
            <h4>MÁS SABOR <br> MÁS DIVERSIÓN</h4>
        </div>

        <div class="banner_card">
            <p>PRUÉBALAS HOY</p>
            <h4>FRESCAS Y PICANTES</h4>
        </div>

    </section>

    <section class="section_container order_container">

        <h2 class="section_header">ELIGE Y DISFRUTA</h2>

    </section>

    <?php foreach ($productsByCategory as $categoryId => $products): ?>
        <section class="section_container order_container" id="<?php echo strtolower($products[0]['name_category']); ?>">

            <p class="section_description">
                <?php echo strtoupper($products[0]['name_category']); ?>
            </p>

            <div class="order_grid">
                <?php foreach ($products as $product): ?>
                    <div class="order_card">
                        <img src="<?php echo "../../img/" . basename($product['img_product']); ?>" alt="order">
                        <h4><?php echo $product['name_product']; ?></h4>
                        <h2><?php echo number_format($product['price_product'], 2, ",", ".") . " Bs"; ?></h2>

                        <button class="btn_hero_2" data-id="<?php echo $product['id_product']; ?>">Agregar al carrito</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

    <footer class="footer" id="footer">

        <div class="section_container footer_container">

            <div class="footer_logo">
                <a href="./menu.php">Coctel de los Batidos 2025</a>
            </div>

            <div class="footer_content">

                <p>Bienvenidos a nuestra página de empanadas, donde cada bocado es una fiesta de sabores. Nos enorgullecemos de ofrecer empanadas frescas y deliciosas, hechas con ingredientes de la más alta calidad. ¡Gracias por elegirnos y disfrutar de nuestras especialidades!</p>

                <div>

                    <ul class="footer_links">

                        <li>
                            <span><i class='bx bx-map'></i></span>
                            Calle los Apatames, Caracas, 1011
                        </li>

                        <li>
                            <span><i class='bx bx-envelope'></i></span>
                            cocteldelosbatidos2025@gmail.com
                        </li>

                    </ul>

                    <div class="footer_socials">
                        <a href="https://www.instagram.com/cocteldelosbatidos/" class="a_hero_2"><i class='bx bxl-instagram'></i></a>
                        <a href="https://wa.me/584242357487" class="a_hero_2"><i class='bx bxl-whatsapp'></i></a>
                    </div>

                </div>

            </div>

        </div>

        <div class="footer_bar">
            &copy; El Cóctel de los Batidos 2025. All right reserved
            <a href="https://github.com/VxneC0de">
                <i class='bx bx-code-alt'></i>
                By VxneC0de
            </a>
        </div>

    </footer>




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
        document.addEventListener('DOMContentLoaded', function() {
            const cartIcon = document.querySelector('.cart_icon a');
            const cartSidebar = document.querySelector('.cart_sidebar');
            const closeCart = document.querySelector('.close_cart');

            cartIcon.addEventListener('click', function(event) {
                event.preventDefault();
                cartSidebar.style.right = '0';
            });

            closeCart.addEventListener('click', function() {
                cartSidebar.style.right = '-100%';
            });
        });
    </script>

    <script>
        document.querySelectorAll('.menu_item').forEach(item => {
            item.addEventListener('click', () => {
                document.getElementById('menu-btn').checked = false;
            });
        });
    </script>

    <script src="https://unpkg.com/scrollreveal"></script>

    <script>
        ScrollReveal({
            // reset: true,
            distance: "80px",
            duration: 2000,
            delay: 200
        });

        ScrollReveal().reveal('nav', {
            origin: 'top'
        });
        ScrollReveal().reveal('.banner_card, .section_description, .order_card', {
            origin: 'bottom'
        });
        ScrollReveal().reveal('.hero_text h2, .hero_text h1, .hero_p, .footer_logo, .footer_content p', {
            origin: 'left'
        });
        ScrollReveal().reveal('.header_image, .top2, .footer_links li, .footer_socials a', {
            origin: 'right'
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