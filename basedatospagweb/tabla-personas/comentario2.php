<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Recent comments about the games");

// CSS incluido directamente en el archivo PHP
echo '<style>
    .comentarios {
        max-width: 800px;
        margin: 0 auto;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .comentario {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .comentario h4 {
        margin: 0 0 10px;
        font-size: 1.1em;
        color: #333;
    }

    .comentario h4 em {
        font-style: italic;
        color: #007bff;
    }

    .comentario p {
        margin: 0;
        font-size: 1em;
        line-height: 1.4;
        color: #555;
    }
</style>';
?>

<div class="comentarios">
<?php
// Consulta para obtener los comentarios
$consulta = "SELECT usuarios.nombre AS usuario, videojuegos.nombre AS juego, comentarios.comentario
             FROM comentarios
             JOIN usuarios ON comentarios.usuario_id = usuarios.id
             JOIN videojuegos ON comentarios.juego_id = videojuegos.id";

$resultado = $pdo->query($consulta);

if (!$resultado) {
    echo "<p>Error al realizar la consulta: " . $pdo->errorInfo()[2] . "</p>";
} elseif ($resultado->rowCount() === 0) {
    echo "<p>No hay comentarios registrados.</p>";
} else {
    foreach ($resultado as $comentario) {
        echo "<div class='comentario'>";
        echo "<h4><em>{$comentario['usuario']}</em> comments about <strong>{$comentario['juego']}</strong>:</h4>";
        echo "<p>{$comentario['comentario']}</p>";
        echo "</div>";
    }
}
?>
</div>

<?php
pie();
?>