<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Add new purchases");
?>
<form action="insertar-cliente2.php" method="POST">
<p>Write the details of the new clients:</p>
    <label for="nombre">Name:</label>
    <input type="text" name="nombre" required>
    <br>
    <label for="apellidos">Surname:</label>
    <input type="text" name="apellidos" required>
    <br>
    <label for="fecha_compra">Date of purchase:</label>
    <input type="text" name="fecha_compra" required>
    <br>
    <label for="juego_id">Select a game:</label>
    <select name="juego_id" required>
        <?php
        // Conexión a la base de datos
        $conn = new mysqli("localhost", "root", "root", "videojuegos");
        $sql = "SELECT id, nombre FROM videojuegos";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
        }
        $conn->close();
        ?>
    </select>
    <br><br>
    <button type="submit">Register purchase</button>
</form>
<?php

pie();
?>