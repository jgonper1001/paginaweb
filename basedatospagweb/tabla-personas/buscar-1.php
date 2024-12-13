<?php


require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("¿Looking for a specific game?");

// Comprobamos si la base de datos contiene registros
$hayRegistrosOk = false;

$consulta = "SELECT COUNT(*) FROM videojuegos";

$resultado = $pdo->query($consulta);
if (!$resultado) {
    print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
} elseif ($resultado->fetchColumn() == 0) {
    print "    <p class=\"aviso\">No se ha creado todavía ningún registro.</p>\n";
} else {
    $hayRegistrosOk = true;
}

// Si todas las comprobaciones han tenido éxito ...
if ($hayRegistrosOk) {
    // Mostramos el formulario
    
?>

<form action="buscar-2.php" method="post">
<h2>Enter the name of the game to search</h2>
  <table>
    <tr>
      <td>Name:</td>
      <td><input type="text" name="nombre"  autofocus></td>
    </tr>
  </table>
  <p>
    <input type="submit" value="Search">
    <input type="reset" value="Restart form">
  </p>
</form>
<?php
}

pie();
?>
