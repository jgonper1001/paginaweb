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

$nombre    = recoge("nombre");
$desarrolladora = recoge("empresa_desarrolladora");
$plataforma  = recoge("plataforma");
$lanzamiento    = recoge("fecha_lanzamiento");
$modojuego  = recoge("modo_juego");
$cantidadstock    = recoge("cantidad_stock");
$id        = recoge("id");

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $idOk = true;
}

// Comprobamos que no se intenta crear un registro vacío
$registroNoVacioOk = false;

    if ($nombre == "" && $desarrolladora == "" && $plataforma == "" && $lanzamiento == "" && $modojuego == "" && $cantidadstock == "" && $id == "") {
        print "    <p class=\"aviso\">Hay que rellenar al menos uno de los campos. No se ha guardado el registro.</p>\n";
        print "\n";
    } else {
        $registroNoVacioOk = true;
}

// Comprobamos que el registro con el id recibido existe en la base de datos
$registroEncontradoOk = false;

if ($idOk && $registroNoVacioOk) {
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
if ($idOk && $registroNoVacioOk && $registroEncontradoOk) {
    // Actualizamos el registro con los datos recibidos
    $consulta = "UPDATE videojuegos
                 SET nombre = :nombre, empresa_desarrolladora = :desarrolladora, plataforma = :plataforma, fecha_lanzamiento = :lanzamiento, modo_juego = :modojuego, cantidad_stock = :cantidadstock, id = :id
                 WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => $nombre, ":desarrolladora" => $desarrolladora, ":plataforma" => $plataforma, ":lanzamiento" => $lanzamiento, ":modojuego" => $modojuego, ":cantidadstock" => $cantidadstock, ":id" => $id])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Game modified succesful.</p>\n";
    }
}

pie();
