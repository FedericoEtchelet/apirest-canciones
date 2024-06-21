<?php
require_once "APP/model/cancionesModel.php";
require_once "APP/view/songsView.php";
require_once "APP/helper/authHelper.php";
require_once 'APP/model/authModel.php';
require_once "APP/model/albumModel.php";
class sonsgController
{
    protected $authModel;
    protected $authHelper;
    protected $songModel;
    protected $albumModel;
    protected $view;

    public function __construct()
    {
        $this->authHelper = new authHelper();
        $this->songModel = new cancionesModel();
        $this->albumModel = new albumModel();
        $this->view = new sonsgView();
        $this->authModel = new authModel();
    }

    function showHome()
    {
        if ($this->authHelper->checkLoggedIn()) {
            $this->view->adminHome();
        } else {
            $this->view->home();
        }
    }

    //PARTE ALBUM
    function showAlbumForm()
    {
        $this->view->albumForm();
        die();
    }

    function insertAlbum()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['album_name'])) {
                $album_name = $_POST['album_name'];
                $albums = $this->albumModel->getAllAlbum();
                $verificar = $this->encontrarOcurrencia($album_name, $albums);
                if ($verificar == 0) {
                    if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                        $this->albumModel->insertAlbum($album_name, $_FILES['imagen']);
                        header("location: " . BASE_URL . "showAlbums");
                        die();
                    }
                } else {
                    $this->view->showError("Album existente");
                }
            }
        }
    }

    function encontrarOcurrencia($album_name, $albums)
    {
        $contador = 0;
        foreach ($albums as $album) {
            if ($album_name == $album->album) {
                $contador += 1;
            }
        }
        return $contador;
    }

    function mostrarAlbums()
    {
        if ($this->authHelper->checkLoggedIn()) {
            $albums = $this->albumModel->getAllAlbum();
            $this->view->showAlbumsAdmin($albums);

        } else {
            $albums = $this->albumModel->getAllAlbum();
            $this->view->showAlbums($albums);
        }
    }

    function deleteAlbum($id_album)
    {
        $this->albumModel->deleteAlbum($id_album);
        header("Location:" . BASE_URL . "showAlbums");
        die();
    }

    function mostrarEditorAlbum($album_id){
        $album = $this->albumModel->getAlbumId($album_id);
        $this->view->editarAlbum($album);
    }

    function finalizarEditAlbum($idAlbum){
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            if(!empty($_POST["nombre"])){
                $nombre = $_POST['nombre'];
                $this->albumModel->editAlbum($nombre,$idAlbum);
                header("Location:".BASE_URL."showAlbums");
                die();
            }
            else{
                echo "faltan campos";
            }
        }
    }

    //PARTE ALBUM

    //PARTE SONGS
    function showSongForm()
    {
        $this->view->songForm();
    }

    function mostrarCanciones()
    {
        if ($this->authHelper->checkLoggedIn()) {
            $cancion = $this->songModel->getAllSongs();
            $this->view->showSongsByAdmin($cancion);
        } else {
            $cancion = $this->songModel->getAllSongs();
            $this->view->showSongs($cancion);
        }
    }

    function mostrarCancionesPorAlbum($id_album)
    {
        if ($this->authHelper->checkLoggedIn()) {
            $album = $this->albumModel->getAlbumId($id_album);
            $songs = $this->songModel->getSongByAlbum($id_album);
            $this->view->showSongsByAlbumAdmin($songs, $album);
        } else {
            $album = $this->albumModel->getAlbumId($id_album);
            $songs = $this->songModel->getSongByAlbum($id_album);
            $this->view->showSongsByAlbum($songs, $album);
        }

    }

    function deleteSongs($id)
    {
        $this->songModel->delete($id);
        header("Location:" . BASE_URL . "showAllSongs");
    }

    function deleteSongsByAlbum($id)
    {
        $song = $this->songModel->getSongById($id);
        $album = $this->albumModel->getAlbumId($song->id_album);
        $this->songModel->delete($id);
        header("Location:" . BASE_URL . "album/$album->id_album");
    }

    function deleteAllSongs($id_album)
    {
        $this->songModel->deleteAllSongsByAlbum($id_album);
        header("Location:" . BASE_URL . "deleteAlbum/$id_album");
        die();
    }

    function insertSongInAlbum($id_album)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['nombre']) && !empty($_POST['artista'])) {

                $nombre = $_POST['nombre'];
                $artista = $_POST['artista'];

                $this->songModel->insertSong($nombre, $artista, $id_album);
                header("location:" . BASE_URL . "album/$id_album");
            } else {
                $this->view->showError("Campos obligatorios vacios");
            }
        }
    }

    //PARTE SONGS

    function mostrarEditor($cancionId)
    {
        if ($this->authHelper->checkLoggedIn()) {
            $cancion = $this->songModel->getSongById($cancionId);
            $this->view->editarSongs($cancion);
        }

    }

    function finalizarEdicion($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['nombre']) && !empty($_POST['artista']) && !empty($_POST['id_album'])) {
                $nombre = $_POST['nombre'];
                $artista = $_POST['artista'];
                $id_album = $_POST['id_album'];
                $this->songModel->editSong($nombre, $artista, $id_album, $id);
                header("Location:" . BASE_URL . "showAllSongs");
                die();
            } else {
                $this->view->showError("Campos obligatorios vacíos");
            }
        }

    }
    
}

?>