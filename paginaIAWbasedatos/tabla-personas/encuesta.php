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

cabecera("¡choose your favourite game!");


// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=videojuegos", 'root', 'root');

// Obtener la encuesta activa
$sql = "SELECT * FROM encuestas WHERE CURDATE() BETWEEN fecha_inicio AND fecha_fin LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

if ($encuesta) {
    echo "<h2>" . htmlspecialchars($encuesta['pregunta']) . "</h2>";

    // Obtener las opciones de la encuesta
    $sql_opciones = "SELECT * FROM opciones WHERE encuesta_id = :encuesta_id";
    $stmt_opciones = $conn->prepare($sql_opciones);
    $stmt_opciones->bindParam(':encuesta_id', $encuesta['id']);
    $stmt_opciones->execute();
    $opciones = $stmt_opciones->fetchAll(PDO::FETCH_ASSOC);

    echo '<form action="voto.php" method="POST">';
    echo '<input type="hidden" name="encuesta_id" value="' . htmlspecialchars($encuesta['id']) . '">';
    foreach ($opciones as $opcion) {
        echo '<label>';
        echo '<input type="radio" name="opcion_id" value="' . htmlspecialchars($opcion['id']) . '" required> ';
        echo htmlspecialchars($opcion['opcion']);
        echo '</label><br>';
    }
    echo '<button type="submit">Votar</button>';
    echo '</form>';
} else {
    echo "<p>No hay encuestas activas en este momento.</p>";
}

pie();
?>