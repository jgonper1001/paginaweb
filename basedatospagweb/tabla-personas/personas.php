<?php


require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

cabecera("¡Welcome to our store!");


?>

<style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(170, 168, 168);
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2em;
        }
        section {
            padding: 20px;
        }
        .hero {
            background: url('hero-image.jpg') no-repeat center center/cover;
            color: white;
            padding: 80px 20px;
            text-align: center;
        }
        .hero h2 {
            font-size: 2.5em;
        }
        .section-title {
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        .product-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .product-item {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            width: 200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .product-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* Estilos para las secciones de testimonios y About Us */
        .about-us {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            text-align: center;
        }

        .about-us h3 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .about-us p {
            font-size: 1.2em;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
        }

        /* Estilos para la sección de Ready to Start Your Gaming Adventure */
        .gaming-adventure {
            background: linear-gradient(135deg, #ff5722, #e91e63);
            color: white;
            text-align: center;
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin: 50px 0;
        }

        .gaming-adventure h3 {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .adventure-text {
            font-size: 1.5em;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #f7f7f7;
        }

        .btn-adventure {
            background-color: #ff9800;
            padding: 15px 30px;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-adventure:hover {
            background-color: #ff5722;
            transform: scale(1.1);
        }

        .btn-adventure:focus {
            outline: none;
        }

        /* Llamada a la acción y otros detalles */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        footer a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Encabezado principal -->
<header>
    <h1>Pixelverse</h1>
    <h2>Your Gateway to Gaming Adventure</h2>
</header>

<!-- Sección de bienvenida (Hero) -->
<section class="hero">
    <h2>Welcome to Pixelverse</h2>
    <h3>Discover the latest releases, timeless classics, and exclusive deals. Level up your gaming experience with us!</h3>
</section>

<!-- Sección de productos destacados -->
<section>
    <h3 class="section-title">Featured Games & Deals</h3>
    <div class="product-grid">
        <!-- Producto 1 -->
        <div class="product-item">
            <img src="persona.jpeg" alt="Persona 3 Reload">
            <h4>Persona 3 Reload</h4>
            <p>Now 20% Off!</p>
            <p>¡Go to the store!</p>
        </div>
        <!-- Producto 2 -->
        <div class="product-item">
            <img src="skyrim.jpg" alt="The Elder Scrolls V: Skyrim">
            <h4>The Elder Scrolls V: Skyrim</h4>
            <p>¡Order Now for the Anniversary edition!</p>
            <p>¡Go to the store!</p>
        </div>
        <!-- Producto 3 -->
        <div class="product-item">
            <img src="reddead.jpeg" alt="Red Dead Redemption 2">
            <h4>Red Dead Redemption 2</h4>
            <p>The best-western adventure game ¡Now 40% Off!</p>
            <p>¡Go to the store!</p>
        </div>
    </div>
</section>

<!-- Sección "Acerca de Nosotros" -->
<section class="about-us">
    <h3>About Us</h3>
    <p>At Pixelverse, we’re more than just a store – we’re a community of gamers. Our mission is to connect players with the games they love and create a space where everyone feels welcome, whether you’re a casual gamer or a seasoned pro.</p>
</section>

<!-- Llamada a la acción final -->
<section class="gaming-adventure">
    <h3 class="section-title">Ready to Start Your Gaming Adventure?</h3>
    <p class="adventure-text">Browse our collection and find your next favourite game today!</p>
</section>

<!-- Pie de página -->
<footer>
    <p>&copy; 2024 Pixelverse. All Rights Reserved.</p>
    <p>Follow us:
        <a href="#">Facebook</a> |
        <a href="#">Instagram</a> |
        <a href="#">Twitter</a>
    </p>
</footer>

</body>
</html>