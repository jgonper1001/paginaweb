<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opcion_id = (int)$_POST['opcion_id'];

    // Conexión a la base de datos
    $conn = new PDO("mysql:host=localhost;dbname=videojuegos", 'root', 'root');

    // Incrementar el contador de votos para la opción seleccionada
    $sql = "UPDATE opciones SET votos = votos + 1 WHERE id = :opcion_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':opcion_id', $opcion_id);

    if ($stmt->execute()) {
        echo "¡Gracias por tu voto!";
        header("Location: resultados.php?encuesta_id=" . $_POST['encuesta_id']);
    } else {
        echo "Error al registrar tu voto.";
    }
}
?>