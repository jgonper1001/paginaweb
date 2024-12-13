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

cabecera("Add Games to our storage");

$nombre    = recoge("nombre");
$desarrolladora = recoge("empresa_desarrolladora");
$plataforma  = recoge("plataforma");
$lanzamiento    = recoge("fecha_lanzamiento");
$modojuego  = recoge("modo_juego");
$cantidadstock    = recoge("cantidad_stock");


// Comprobamos que no se intenta crear un registro vacío
$registroNoVacioOk = false;

    if ($nombre == "" && $desarrolladora == "" && $plataforma == "" && $lanzamiento == "" && $modojuego == "" && $cantidadstock == "") {
        print "    <p class=\"aviso\">Hay que rellenar al menos uno de los campos. No se ha guardado el registro.</p>\n";
        print "\n";
    } else {
        $registroNoVacioOk = true;
    }

// Comprobamos que no se intenta crear un registro idéntico a uno que ya existe
$registroDistintoOk = false;

if ($registroNoVacioOk) {
    $consulta = "SELECT COUNT(*) FROM videojuegos
                 WHERE nombre = :nombre
                 AND empresa_desarrolladora = :desarrolladora
                 AND plataforma = :plataforma
                 AND fecha_lanzamiento = :lanzamiento
                 AND modo_juego = :modojuego
                 AND cantidad_stock = :cantidadstock";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => $nombre, ":desarrolladora" => $desarrolladora, ":plataforma" => $plataforma, ":lanzamiento" => $lanzamiento, ":modojuego" => $modojuego, ":cantidadstock" => $cantidadstock])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() > 0) {
        print "    <p class=\"aviso\">El registro ya existe.</p>\n";
    } else {
        $registroDistintoOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($registroNoVacioOk && $registroDistintoOk ) {
    // Insertamos el registro en la tabla
    $consulta = "INSERT INTO videojuegos
                 (nombre, empresa_desarrolladora, plataforma, fecha_lanzamiento, modo_juego, cantidad_stock)
                 VALUES (:nombre, :desarrolladora, :plataforma, :lanzamiento, :modojuego, :cantidadstock)";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => $nombre, ":desarrolladora" => $desarrolladora, ":plataforma" => $plataforma, ":lanzamiento" => $lanzamiento, ":modojuego" => $modojuego, ":cantidadstock" => $cantidadstock])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Registro creado correctamente.</p>\n";
    }
}

pie();
