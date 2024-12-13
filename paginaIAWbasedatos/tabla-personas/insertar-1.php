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

    // Mostramos el formulario
?>
<form action="insertar-2.php" method="post">
  <p>Write the details of the games:</p>

  <table>
    <tr>
      <td>Name:</td>
      <td><input type="text" name="nombre" autofocus></td>
    </tr>
    <tr>
      <td>Development Company:</td>
      <td><input type="text" name="empresa_desarrolladora"></td>
    </tr>
    <tr>
      <td>Platform:</td>
      <td><input type="text" name="plataforma"></td>
    </tr>
    <tr>
      <td>Release Date:</td>
      <td><input type="text" name="fecha_lanzamiento"></td>
    </tr>
    <tr>
      <td>Game Mode:</td>
      <td><input type="text" name="modo_juego"></td>
    </tr>
    <tr>
      <td>Quantity in stock:</td>
      <td><input type="text" name="cantidad_stock"></td>
    </tr>
  </table>
  <p>
    <input type="submit" value="Add">
    <input type="reset" value="Restart form">
  </p>
</form>
<?php

pie();
?>
