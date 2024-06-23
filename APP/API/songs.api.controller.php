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

    public function getSongs()
    {
        if (isset($_GET['direccion'])) {
            $direc = $_GET['direccion'];
            if ($direc == "desc") {
                $songs = $this->model->getAllSongs();
                rsort($songs);
                $this->view->response($songs, 200);
            }
            //FILTRO POR ALBUM ID
        } elseif (isset($_GET['id_album'])) {
            $id_album = $_GET['id_album'];
            $songs = $this->model->getSongByAlbum($id_album);
            $this->view->response($songs, 200);
            //FILTRO POR ARTISTA
        } elseif (isset($_GET['artista'])) {
            $artista = $_GET['artista'];
            $songs = $this->model->getSongByArtist($artista);
            $this->view->response($songs, 200);

        } else {
            $songs = $this->model->getAllSongs();
            if ($songs)
                $this->view->response($songs, 200);
            else
                $this->view->response("NO HAY CANCIONES.", 404);
        }
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
            $this->model->delete($song->id);
            $this->view->response("La cancion ha sido eliminada con éxito", 200);
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
            $this->view->response("ERROR la cancion no ha sido agregada.", 400);
        }
    }

    public function editSong($params = null)
    {
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
}
?>