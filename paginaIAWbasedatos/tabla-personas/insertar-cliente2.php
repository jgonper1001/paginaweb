<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Add new purchases");

    // Mostramos el formulario
?>


<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root"; // Cambiar si es necesario
$database = "videojuegos";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

<?php
// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $juego_id = $_POST['juego_id'];
    $fecha_compra = $_POST['fecha_compra']; // Fecha de compra ingresada por el usuario

    // Si no se ingresa una fecha, usar la fecha actual
    if (empty($fecha_compra)) {
        $fecha_compra = date('Y-m-d'); // Obtener la fecha actual si no se proporciona una fecha
    }

    // Insertar en la tabla usuarios
    $sql_insert = "INSERT INTO usuarios (nombre, apellidos, juego_id, fecha_compra)
                   VALUES ('$nombre', '$apellidos', $juego_id, '$fecha_compra')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<p>Usuario registrado correctamente. <a href='clientes.php'>Ver clientes</a></p>";
    } else {
        echo "<p>Error al registrar usuario: " . $conn->error . "</p>";
    }
    ;
}
?>