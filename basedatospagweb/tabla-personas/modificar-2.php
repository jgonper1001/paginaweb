<?php


require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Modify games");

$id = recoge("id");

// Comprobamos el dato recibido
$idOk = false;

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $idOk = true;
}

// Comprobamos que el registro con el id recibido existe en la base de datos
$registroEncontradoOk = false;

if ($idOk) {
    $consulta = "SELECT COUNT(*) FROM videojuegos
                 WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":id" => $id])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
    } else {
        $registroEncontradoOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($idOk && $registroEncontradoOk) {
    // Recuperamos el registro con el id recibido para incluir sus valores en el formulario
    $consulta = "SELECT * FROM videojuegos
                 WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":id" => $id])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        $registro = $resultado->fetch();

    print "<form action=\"modificar-3.php\" method=\"get\">";
    print "      <p>Modify the data you want:</p>";

    print "      <table>";
    print "        <tr>";
    print "          <td>Name:</td>";
    print "          <td><input type=\"text\" name=\"nombre\" value=\"$registro[nombre]\" autofocus></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Developer:</td>";
    print "          <td><input type=\"text\" name=\"empresa_desarrolladora\" value=\"$registro[empresa_desarrolladora]\"></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Platform:</td>";
    print "          <td><input type=\"text\" name=\"plataforma\" value=\"$registro[plataforma]\"></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Release date:</td>";
    print "          <td><input type=\"text\" name=\"fecha_lanzamiento\" value=\"$registro[fecha_lanzamiento]\"></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Game mode:</td>";
    print "          <td><input type=\"text\" name=\"modo_juego\" value=\"$registro[modo_juego]\"></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Stock quantity:</td>";
    print "          <td><input type=\"text\" name=\"cantidad_stock\" value=\"$registro[cantidad_stock]\"></td>";
    print "        </tr>";
    print "      </table>";
    print "";
    print "      <p>";
    print "        <input type=\"hidden\" name=\"id\" value=\"$id\">";
    print "        <input type=\"submit\" value=\"Update\">";
    print "        <input type=\"reset\" value=\"Restart form\">";
    print "      </p>";
    print "    </form>";
  }
}

pie();
?>
