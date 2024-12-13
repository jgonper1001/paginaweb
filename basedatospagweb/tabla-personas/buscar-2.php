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

$nombre    = recoge("nombre");



// Comprobamos los datos recibidos procedentes de un formulario
$nombreOk    = false;
if ($nombre==""){
print "<p class=\"aviso\">El nombre proporcionado está vacío</p>";
}
else{
$nombreOk=true;
}



// Comprobamos si existen registros con las condiciones de búsqueda recibidas
$registrosEncontradosOk = false;

if ($nombreOk) {
    $consulta = "SELECT COUNT(*) FROM videojuegos
                 WHERE nombre = :nombre;";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => "$nombre"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() == 0) {
        print "    <p class=\"aviso\">No se han encontrado registros.</p>\n";
    } else {
        $registrosEncontradosOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($nombreOk && $registrosEncontradosOk) {
    // Seleccionamos todos los registros con las condiciones de búsqueda recibidas
    $consulta = "SELECT * FROM videojuegos
                 WHERE nombre = :nombre";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => "$nombre"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
?>

   
      <p>Games found:</p>

      <table class=\"conborde franjas\">
        <thead>
          <tr>
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
            print "          <td>$registro[nombre]</td>\n";
            print "          <td>$registro[empresa_desarrolladora]</td>\n";
            print "          <td>$registro[plataforma]</td>\n";
            print "          <td>$registro[fecha_lanzamiento]</td>\n";
            print "          <td>$registro[modo_juego]</td>\n";
            print "          <td>$registro[cantidad_stock]</td>\n";
            print "        </tr>\n";
        }
        print "      </table>\n";
    }
}

pie();
