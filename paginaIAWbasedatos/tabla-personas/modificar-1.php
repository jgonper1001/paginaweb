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

cabecera("Modify games");


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
    // Recuperamos todos los registros para mostrarlos en una <table>
    $consulta = "SELECT * FROM videojuegos";

    $resultado = $pdo->query($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
?>
      <p>Indicate de game you want to modify:</p>
	<form action="modificar-2.php" method="post">
      <table class="conborde franjas">
        <thead>
          <tr>
            <th>Modify</th>
            <th>Name</th>
            <th>Developer</th>
            <th>Platform</th>
            <th>Release date</th>
            <th>Game mode</th>
            <th>Stock quantity</th>
          </tr>
        </thead>
<?php
        foreach ($resultado as $registro) {
            print "        <tr>\n";
            print "          <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$registro[id]\"></td>\n";
            print "          <td>$registro[nombre]</td>\n";
            print "          <td>$registro[empresa_desarrolladora]</td>\n";
            print "          <td>$registro[plataforma]</td>\n";
            print "          <td>$registro[fecha_lanzamiento]</td>\n";
            print "          <td>$registro[modo_juego]</td>\n";
            print "          <td>$registro[cantidad_stock]</td>\n";
            print "        </tr>\n";
        }
        print "      </table>\n";
        print "\n";
        print "      <p>\n";
        print "        <input type=\"submit\" value=\"Modify game\">\n";
        print "        <input type=\"reset\" value=\"Restart form\">\n";
        print "      </p>\n";
        print "    </form>\n";
    }
}

pie();
?>
