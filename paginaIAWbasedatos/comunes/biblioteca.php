<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */


// Carga Biblioteca específica de la base de datos utilizada





function recoge($key, $type = "", $default = null, $allowed = null)
{
    if (!is_string($key) && !is_int($key) || $key == "") {
        trigger_error("Function recoge(): Argument #1 (\$key) must be a non-empty string or an integer", E_USER_ERROR);
    } elseif ($type !== "" && $type !== []) {
        trigger_error("Function recoge(): Argument #2 (\$type) is optional, but if provided, it must be an empty array or an empty string", E_USER_ERROR);
    } elseif (isset($default) && !is_string($default)) {
        trigger_error("Function recoge(): Argument #3 (\$default) is optional, but if provided, it must be a string", E_USER_ERROR);
    } elseif (isset($allowed) && !is_array($allowed)) {
        trigger_error("Function recoge(): Argument #4 (\$allowed) is optional, but if provided, it must be an array of strings", E_USER_ERROR);
    } elseif (is_array($allowed) && array_filter($allowed, function ($value) { return !is_string($value); })) {
        trigger_error("Function recoge(): Argument #4 (\$allowed) is optional, but if provided, it must be an array of strings", E_USER_ERROR);
    } elseif (!isset($default) && isset($allowed) && !in_array("", $allowed)) {
        trigger_error("Function recoge(): If argument #3 (\$default) is not set and argument #4 (\$allowed) is set, the empty string must be included in the \$allowed array", E_USER_ERROR);
    } elseif (isset($default, $allowed) && !in_array($default, $allowed)) {
        trigger_error("Function recoge(): If arguments #3 (\$default) and #4 (\$allowed) are set, the \$default string must be included in the \$allowed array", E_USER_ERROR);
    }

    if ($type == "") {
        if (!isset($_REQUEST[$key]) || (is_array($_REQUEST[$key]) != is_array($type))) {
            $tmp = "";
        } else {
            $tmp = trim(htmlspecialchars($_REQUEST[$key]));
        }
        if ($tmp == "" && !isset($allowed) || isset($allowed) && !in_array($tmp, $allowed)) {
            $tmp = $default ?? "";
        }
    } else {
        if (!isset($_REQUEST[$key]) || (is_array($_REQUEST[$key]) != is_array($type))) {
            $tmp = [];
        } else {
            $tmp = $_REQUEST[$key];
            array_walk_recursive($tmp, function (&$value) use ($default, $allowed) {
                $value = trim(htmlspecialchars($value));
                if ($value == "" && !isset($allowed) || isset($allowed) && !in_array($value, $allowed)) {
                    $value = $default ?? "";
                }
            });
        }
    }
    return $tmp;
}
/*
Esta función pinta la parte superior de las páginas web
SI LA SESIÓN ESTÁ INICIADA: Saca el menú de las funciones que se pueden hacer en la base de datos + DESCONECTARSE
SI LA SESIÓN NO ESTÁ INICIADA: Saca exclusivamente el menu CONECTARSE
*/
function cabecera($texto)
{
    print "<!DOCTYPE html>\n";
    print "<html lang=\"es\">\n";
    print "<head>\n";
    print "  <meta charset=\"utf-8\">\n";
    print "  <title>\n";
    print "    $texto. \n";
    print "  </title>\n";
    print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    print "  <link rel=\"stylesheet\" href=\"mclibre-php-proyectos.css\" title=\"Color\">\n";
    print "</head>\n";
    print "\n";
    print "<body>\n";
    print "  <header>\n";
    print "    <h1>Pixelverse - $texto</h1>\n";
    print "\n";
    print "    <nav>\n";
    print "      <ul>\n";
    if (!isset($_SESSION["conectado"])) {
     
            print "        <li><a href=\"login-1.php\">Conectarse</a></li>\n";
       
        }
       
     else {
           
            print "        <li><a href=\"personas.php\">Main page</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Add games</a></li>\n";
            print "        <li><a href=\"insertar-cliente.php\">Add clients</a></li>\n";
            print "        <li><a href=\"listar.php\">Games on sale</a></li>\n";
            print "        <li><a href=\"encuesta.php\">¿Favourite game?</a></li>\n";
            print "        <li><a href=\"clientes.php\">Clients</a></li>\n";
            print "        <li><a href=\"comentario.php\">¡Tell us!</a></li>\n";
            print "        <li><a href=\"comentario2.php\">Comments</a></li>\n";
            print "        <li><a href=\"borrar-comentario.php\">Delete comments</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Delete games</a></li>\n";
            print "        <li><a href=\"borrar-cliente.php\">Delete clients</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Search for a game</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modify game list</a></li>\n";
            print "        <li><a href=\"borrar-todo-1.php\">Delete all</a></li>\n";
             print "        <li><a href=\"../logout.php\">Disconnect</a></li>\n";
        }
    print "      </ul>\n";
    print "    </nav>\n";
    print "  </header>\n";
    print "\n";
    print "  <main>\n";
}

function pie()
{
    print "  </main>\n";
    print "\n";
    print "  <footer>\n";
    print "    <p class=\"ultmod\">\n";
    print "    </p>\n";
    print "\n";
    print "    <p class=\"licencia\">\n";
    print "Database for workers\n";
    print "</p>\n";
    print "      Follow us on our social networks<strong>  <a href=\"https://www.instagram.com/\">Instagram </a></strong> \n";
    print "</p>\n";
    print "      Follow us on our social networks<strong>  <a href=\"https://x.com/\">X \n";
    print "    </p>\n";
    print "  </footer>\n";
    print "</body>\n";
    print "</html>\n";
}

// Funciones BASES DE DATOS
function conectaDb()
{
   

    try {
        $tmp = new PDO("mysql:host=localhost;dbname=videojuegos;charset=utf8mb4", "root", "root");
       return $tmp;
    }  catch (PDOException $e) {
        print "    <p class=\"aviso\">Error: No puede conectarse con la base de datos. {$e->getMessage()}</p>\n";
    }

}

// MYSQL: Borrado y creación de base de datos y tablas

function borraTodo()
{
    global $pdo;

    print "    <p>Sistema Gestor de Bases de Datos: MySQL.</p>\n";
    print "\n";

    $consulta = "DROP DATABASE IF EXISTS videojuegos";

    if (!$pdo->query($consulta)) {
        print "    <p class=\"aviso\">Error al borrar la base de datos. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Base de datos borrada correctamente (si existía).</p>\n";
    }
    print "\n";

    $consulta = "CREATE DATABASE videojuegos
                 CHARACTER SET utf8mb4
                 COLLATE utf8mb4_unicode_ci";

    if (!$pdo->query($consulta)) {
        print "    <p class=\"aviso\">Error al crear la base de datos. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Base de datos creada correctamente.</p>\n";
        print "\n";

        $consulta = "USE videojuegos";

        if (!$pdo->query($consulta)) {
            print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } else {
            print "    <p>Base de datos seleccionada correctamente.</p>\n";
            print "\n";

            $consulta = "CREATE TABLE stock (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada videojuego
    nombre VARCHAR(255) NOT NULL,              -- Nombre del videojuego
    empresa_desarrolladora VARCHAR(255),       -- Nombre de la empresa desarrolladora
    plataforma VARCHAR(100),                   -- Plataforma (PC, PS5, Xbox, etc.)
    fecha_lanzamiento DATE,                    -- Fecha de lanzamiento del videojuego
    modo_juego ENUM('Un jugador', 'Multijugador', 'Ambos') -- Modo de juego
    cantidad_stock INT DEFAULT 0;
                         )";

            if (!$pdo->query($consulta)) {
                print "    <p class=\"aviso\">Error al crear la tabla. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
            } else {
                print "    <p>Tabla creada correctamente.</p>\n";
            }
        }
    }
}

function encripta($cadena)
{
   

    return hash("sha256", $cadena);
}