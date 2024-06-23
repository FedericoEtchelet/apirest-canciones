<?php
require_once 'APIView.php';
require_once 'APP/model/albumModel.php';

class albumApiController
{

    private $model;
    private $view;
    private $data;

    public function __construct()
    {
        $this->model = new albumModel();
        $this->view = new APIView();
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }


    public function getAlbums($params = null)
    {
        $albums = $this->model->getAllAlbum();
        $this->view->response($albums, 200);
    }

    public function getAlbumByid($params = null)
    {
        $id = $params[':ID'];
        $album = $this->model->getAlbumId($id);
        if ($album) {
            $this->view->response($album, 200);
        } else {
            $this->view->response("ERROR el album con el id: {$id} no existe o no pudo ser encontrado", 404);
        }
    }

    public function deleteAlbum($params = null)
    {
        $id = $params[':ID'];
        $album = $this->model->getAlbumId($id);
        if ($album) {
            $this->model->deleteAlbum($album->id);
            $this->view->response("El album fue eliminado con éxito.", 200);
        } else {
            $this->view->response("ERROR el album con ID: {$id} no existe o no pudo ser encontrado", 404);
        }
    }

    public function addAlbum($params = null)
    {
        $data = $this->getData();
        $id = $this->model->insertAlbum($data->album, $data->imagen);
        $album = $this->model->getAlbumId($id);
        if ($album) {
            $this->view->response($album, 200);
        } else {
            $this->view->response("ERROR el album no pudo ser insertado.", 400);
        }
    }

    public function editAlbum($params = null)
    {
        $id = $params[':ID'];
        $data = $this->getData();
        $album = $this->model->getAlbumId($id);
        if ($album) {
            $this->model->editAlbum($data->nombre, $id);
            $this->view->response("El album fue editado con éxito.", 201);
        } else {
            $this->view->response("ERROR el album con el id: {$id} no pudo ser editado.", 404);
        }
    }
}
?>