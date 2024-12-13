<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Comment about the games");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_POST["usuario_id"] ?? null;
    $juego_id = $_POST["juego_id"] ?? null;
    $comentario = trim($_POST["comentario"]) ?? "";

    if ($usuario_id && $juego_id && $comentario !== "") {
        $sql = "INSERT INTO comentarios (usuario_id, juego_id, comentario)
                VALUES (:usuario_id, :juego_id, :comentario)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([
            ":usuario_id" => $usuario_id,
            ":juego_id" => $juego_id,
            ":comentario" => $comentario,
        ])) {
            echo "<p>Comentario guardado con éxito.</p>";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "<p>Error al guardar el comentario: {$errorInfo[2]}</p>";
        }
    } else {
        echo "<p>No se han proporcionado todos los datos necesarios.</p>";
    }
}
?>

<form action="" method="post">
    <p>
        <label for="usuario_id">Select User:</label>
        <select name="usuario_id" id="usuario_id" required>
            <?php
            $usuarios = $pdo->query("SELECT id, nombre FROM usuarios")->fetchAll();
            foreach ($usuarios as $usuario) {
                echo "<option value=\"{$usuario["id"]}\">{$usuario["nombre"]}</option>";
            }
            ?>
        </select>
    </p>
    <p>
        <label for="juego_id">Select Game:</label>
        <select name="juego_id" id="juego_id" required>
            <?php
            $juegos = $pdo->query("SELECT id, nombre FROM videojuegos")->fetchAll();
            foreach ($juegos as $juego) {
                echo "<option value=\"{$juego["id"]}\">{$juego["nombre"]}</option>";
            }
            ?>
        </select>
    </p>
    <p>
        <label for="comentario">Write your comment:</label>
        <textarea name="comentario" id="comentario" rows="4" cols="40" required></textarea>
    </p>
    <p>
        <button type="submit">Send comment</button>
    </p>
</form>

<?php
pie();
?>