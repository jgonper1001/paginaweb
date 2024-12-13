<?php


require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$borrar = recoge("borrar");

if ($borrar != "Sí") {
    header("Location:personas.php");
    exit;
}

$pdo = conectaDb();

cabecera("Delete all games");

borraTodo();

pie();
