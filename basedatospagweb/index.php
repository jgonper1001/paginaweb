<?php


require_once "comunes/biblioteca.php";

session_name("sesiondb");
session_start();
  if (!isset($_SESSION["conectado"])) {
cabecera("Welcome");
pie();
}
else{
header("Location:tabla-personas/personas.php");
}
