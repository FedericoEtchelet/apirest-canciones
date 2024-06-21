<?php
require_once "APP/controller/songsController.php";
require_once "APP/controller/authController.php";
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/'); // Define la URL base para construir rutas

if (empty($_GET['action'])) {
    $_GET['action'] = 'home'; // Si no se proporciona una acción en la URL, establece "home" como acción predeterminada
}

$action = $_GET['action']; // Obtiene la acción de la URL
$parametro = explode('/', $action); // Divide la acción en partes utilizando "/" como separador


switch ($parametro[0]) {
    case 'home':
        $controller = new sonsgController();
        $controller->showHome();
        break;

    case 'showAllSongs':
        $controller = new sonsgController();
        $controller->mostrarCanciones();
        break;

    case 'album':
        $controller = new sonsgController();
        $controller->mostrarCancionesPorAlbum($parametro[1]);
        break;

    case 'showAlbumForm':
        $controller = new sonsgController();
        $controller->showAlbumForm();
        break;

    case 'insertAlbum':
        $controller = new sonsgController();
        $controller->insertAlbum();
        break;

    case 'showSongForm':
        $controller = new sonsgController();
        $controller->showSongForm();
        break;

    case 'showAlbums':
        $controller = new sonsgController();
        $controller->mostrarAlbums();
        break;

    case 'showLoginForm':
        $controller = new authController();
        $controller->showLoginForm();
        break;

    case 'addSong':
        $controller = new sonsgController();
        $controller->insertSongInAlbum($parametro[1]);
        break;

    case 'delete':
        $controller = new sonsgController();
        $controller->deleteSongs($parametro[1]);
        break;

    case 'deleteByAlbum':
        $controller = new sonsgController();
        $controller->deleteSongsByAlbum($parametro[1]);
        break;

    case 'deleteAllSongs':
        $controller = new sonsgController();
        $controller->deleteAllSongs($parametro[1]);
        break;

    case 'deleteAlbum':
        $controller = new sonsgController();
        $controller->deleteAlbum($parametro[1]);
        break;

    case 'editar':
        $controller = new sonsgController();
        $controller->mostrarEditor($parametro[1]);
        break;

    case 'editAlbum':
        $controller = new sonsgController();
        $controller->mostrarEditorAlbum($parametro[1]);
        break;

    case 'finalizarEdit':
        $controller = new sonsgController();
        $controller->finalizarEdicion($parametro[1]);
        break;

    case 'finalizarEditAlbum':
        $controller = new sonsgController();
        $controller->finalizarEditAlbum($parametro[1]);
        break;

    case 'login':
        $controller = new authController();
        $controller->loguear();
        break;

    case 'logout':
        $controller = new authController();
        $controller->logOut();
        break;

    default:
        echo "404 Page Not Found";
        break;
}

?>