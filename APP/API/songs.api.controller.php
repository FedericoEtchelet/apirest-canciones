<?php
require_once 'APIView.php';
require_once 'APP/model/cancionesModel.php';

class songsApiController
{

    private $model;
    private $albumModel;
    private $view;
    private $data;

    public function __construct()
    {
        $this->model = new cancionesModel();
        $this->view = new APIView();
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function getSongs($params = null)
    {
        $songs = $this->model->getAllSongs();
        $this->view->response($songs, 200);
    }

    public function getSongByid($params = null)
    {
        $id = $params[':ID'];
        $song = $this->model->getSongById($id);
        if ($song) {
            $this->view->response($song, 200);
        } else {
            $this->view->response("ERROR la cancion con ID: {$id} no existe o no pudo ser encontrada", 404);
        }
    }

    public function deleteSong($params = null)
    {
        $id = $params[":ID"];
        $song = $this->model->getSongById($id);
        if ($song) {
            $this->model->delete($song);
        } else {
            $this->view->response("ERROR la cancion con ID: {$id} no existe o no pudo ser encontrada", 404);
        }
    }

    public function addSong($params = null)
    {
        $data = $this->getData();
        $id = $this->model->insertSong($data->nombre, $data->artista, $data->id_album);
        $song = $this->model->getSongById($id);
        if ($song) {
            $this->view->response($song, 200);
        } else {
            $this->view->response("ERROR la cancion no ha sido agregada.", 500);
        }
    }

    public function editSong($params = null)
    {
        $id = $params[':ID'];
        $data = $this->getData();
        $song = $this->model->getSongById($id);
        if ($song) {
            $this->model->editSong($data->nombre, $data->artista, $data->id_album, $data->$id);
            $this->view->response("La cancion ha sido modificada con éxito.", 200);
        } else {
            $this->view->response("ERROR la cancion no existe o no puede ser modificada.", 404);
        }
    }
}
?>