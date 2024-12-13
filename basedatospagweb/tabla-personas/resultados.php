<?php
$encuesta_id = (int)$_GET['encuesta_id'];

// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=videojuegos", 'root', 'root');

// Obtener la encuesta
$sql = "SELECT pregunta FROM encuestas WHERE id = :encuesta_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':encuesta_id', $encuesta_id);
$stmt->execute();
$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

if ($encuesta) {
    echo "<h2>Resultados para: " . htmlspecialchars($encuesta['pregunta']) . "</h2>";

    // Obtener las opciones con sus votos
    $sql_opciones = "SELECT opcion, votos FROM opciones WHERE encuesta_id = :encuesta_id";
    $stmt_opciones = $conn->prepare($sql_opciones);
    $stmt_opciones->bindParam(':encuesta_id', $encuesta_id);
    $stmt_opciones->execute();
    $opciones = $stmt_opciones->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar resultados
    echo '<ul>';
    foreach ($opciones as $opcion) {
        echo '<li>' . htmlspecialchars($opcion['opcion']) . ': ' . $opcion['votos'] . ' votos</li>';
    }
    echo '</ul>';
} else {
    echo "<p>No se encontraron resultados para esta encuesta.</p>";
}
?>