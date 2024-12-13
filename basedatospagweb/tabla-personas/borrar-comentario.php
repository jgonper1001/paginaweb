<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Delete comments");

// Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comentario_id'])) {
    $comentario_id = intval($_POST['comentario_id']);

    // Eliminar el comentario de la base de datos
    $consulta = "DELETE FROM comentarios WHERE id = :id";
    $stmt = $pdo->prepare($consulta);

    if ($stmt->execute([':id' => $comentario_id])) {
        echo "<p class='aviso'>Comment deleted succesfuly.</p>";
    } else {
        echo "<p class='aviso'>Error al eliminar el comentario: " . $pdo->errorInfo()[2] . "</p>";
    }
}

// Recuperar los comentarios para mostrarlos en la tabla
$consulta = "SELECT comentarios.id, usuarios.nombre AS usuario, videojuegos.nombre AS juego, comentarios.comentario
             FROM comentarios
             JOIN usuarios ON comentarios.usuario_id = usuarios.id
             JOIN videojuegos ON comentarios.juego_id = videojuegos.id";

$resultado = $pdo->query($consulta);

if (!$resultado) {
    echo "<p>Error al realizar la consulta: " . $pdo->errorInfo()[2] . "</p>";
} elseif ($resultado->rowCount() === 0) {
    echo "<p>No hay comentarios registrados.</p>";
} else {
?>

    <form action="" method="post">
        <table class="conborde franjas">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Game</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    foreach ($resultado as $comentario) {
        echo "<tr>";
        echo "<td>{$comentario['usuario']}</td>";
        echo "<td>{$comentario['juego']}</td>";
        echo "<td>{$comentario['comentario']}</td>";
        echo "<td><button type='submit' name='comentario_id' value='{$comentario['id']}'>Delete</button></td>";
        echo "</tr>";
    }
?>
            </tbody>
        </table>
    </form>

<?php
}

pie();
?>