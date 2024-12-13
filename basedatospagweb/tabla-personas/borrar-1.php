<?php


require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Delete games");



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
    <form action="borrar-2.php" method="post">
      <p>Mark the game you want to delete:</p>
      <table class="conborde franjas">
        <thead>
          <tr>
            <th>Delete</th>
            <th>Name</th>
            <th>Developer</th>
            <th>Platform</th>
            <th>Release date</th>
            <th>Game mode</th>
            <th>Quantity in stock</th>
          </tr>
        </thead>
<?php
        foreach ($resultado as $registro) {
            print "        <tr>\n";

                print "          <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$registro[id]\" checked></td>\n";
          
            
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
        print "        <input type=\"submit\" value=\"Delete game\" >\n";
        print "        <input type=\"reset\" value=\"Restart form\">\n";
        print "      </p>\n";
        print "    </form>\n";
    }

}
pie();
?>
