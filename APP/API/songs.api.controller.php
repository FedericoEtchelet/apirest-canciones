<?php
require_once 'APIView.php';
require_once 'APP/model/cancionesModel.php';
require_once 'configApi.php';
require_once 'APP/API/token.api.controller.php';

ini_set('display_errors', 0);
class songsApiController
{
    private $model;
    private $albumModel;
    private $view;
    private $data;
    private $token;

    public function __construct()
    {
        $this->model = new cancionesModel();
        $this->view = new APIView();
        $this->data = file_get_contents("php://input");
        $this->token = new tokenApiController;
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function getSongs()
    {
        try {
            //ordenar por el campo y direccion que eliga el usuario
            if (isset($_GET['orderBy']) && isset($_GET['orderDir'])) {
                $orderBy = $_GET['orderBy'];
                $orderDir = $_GET['orderDir'];
                //retorna la coleccion, con los parametros elegidos por el usuario
                $songs = $this->model->getAllSongs($orderBy, $orderDir);
                $this->view->response($songs, 200);
            }
            //filtro de canciones por album
            else if (isset($_GET['id_album'])) {
                $id_album = $_GET['id_album'];
                $songs = $this->model->getSongByAlbum($id_album);
                $this->view->response($songs, 200);
            }
            //si no esta seteado ni orderBy, orderDir, e id_album, entregamos la coleccion de canciones, predeterminadamente por orden de id, y de manera ascendente
            else if (!isset($_GET['orderBy']) && !isset($_GET['orderDir']) && !isset($_GET['id_album'])) {
                $orderBy = 'id';
                $orderDir = 'ASC';
                $songs = $this->model->getAllSongs($orderBy, $orderDir);
                $this->view->response($songs, 200);
            } else {
                $this->view->response(" ERROR: No hay canciones  o faltan parametros", 404);
            }

        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }
    //OBTIENE UNA CANCION POR ID
    public function getSongByid($params = null)
    {

        try {
            $id = $params[':ID'];
            $song = $this->model->getSongById($id);
            if ($song) {
                $this->view->response($song, 200);
            } else {
                $this->view->response("ERROR la cancion con ID: {$id} no existe o no pudo ser encontrada", 404);
            }


        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }

    }
    //ELEIMINA UNA CANCION
    public function deleteSong($params = null)
    {
        try {
            $id = $params[":ID"];
            $song = $this->model->getSongById($id);
            if ($song) {
                $this->model->delete($song->id);
                $this->view->response("La cancion ha sido eliminada con éxito", 200);
            } else {
                $this->view->response("ERROR la cancion con ID: {$id} no existe o no pudo ser encontrada", 404);
            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }
    //AGREGA UNA CANCION
    public function addSong($params = null)
    {
        try {
            if (!$this->token->verificarSeguridad()) {
                $this->view->response("No autorizado", 401);
            } else {
                $data = $this->getData();
                $id = $this->model->insertSong($data->nombre, $data->artista, $data->id_album);
                $song = $this->model->getSongById($id);
                if ($song) {
                    $this->view->response($song, 200);
                } else {
                    $this->view->response("ERROR la cancion no ha sido agregada.", 400);
                }
            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }

    //EDITAR UNA CANCION
    public function editSong($params = null)
    {
        try {
            if (!$this->token->verificarSeguridad()) {
                $this->view->response("No autorizado", 401);
            } else {
                $id = $params[':ID'];
                $data = $this->getData();
                $song = $this->model->getSongById($id);
                if ($song) {
                    $this->model->editSong($data->nombre, $data->artista, $data->id_album, $id);
                    $this->view->response("La cancion ha sido modificada con éxito.", 201);
                } else {
                    $this->view->response("ERROR la cancion no existe o no puede ser modificada.", 404);
                }
            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }
}
?>