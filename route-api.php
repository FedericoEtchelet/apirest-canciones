<?php
require_once 'libs/Router.php';
require_once 'APP/API/songsApiController.php';
require_once 'APP/API/albumApiController.php';

define("BASE_URL", 'http://' . $_SERVER["SERVER_NAME"] . ':' . $_SERVER["SERVER_PORT"] . dirname($_SERVER["PHP_SELF"]) . '/');

$router = new Router();

//RUTAS SONGS
$router->addRoute("songs", "GET", "songsApiController", "getSongs");
$router->addRoute("songs/:ID", "GET", "songsApiController", "getSongByid");
$router->addRoute("songs/:ID", "DELETE", "songsApiController", "deleteSong");
$router->addRoute("songs", "POST", "songsApiController", "addSong");
$router->addRoute("songs/:ID", "PUT", "songsApiController", "editSong");

//RUTAS ALBUMS
$router->addRoute("album", "GET", "albumApiController", "getAlbums");
$router->addRoute("album/:ID", "GET", "albumApiController", "getAlbumByid");
$router->addRoute("album/:ID", "DELETE", "albumApiController", "deleteAlbum");
$router->addRoute("album", "POST", "albumApiController", "addAlbum");
$router->addRoute("album/:ID", "PUT", "albumApiController", "editAlbum");


//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); 
?>