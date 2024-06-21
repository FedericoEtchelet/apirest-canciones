<?php
require_once "APP/model/model.php";
class albumModel extends model
{
    function getAllAlbum()
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare('SELECT * FROM album');
        $sentencia->execute();
        $album = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $album;
    }

    function getAlbumId($id_album)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare('SELECT * FROM album WHERE id_album = ?');
        $sentencia->execute([$id_album]);
        $album = $sentencia->fetch(PDO::FETCH_OBJ);
        return $album;
    }

    public function insertAlbum($album, $imagen = null)
    {
        $db = $this->createConexion();
        $pathImage = null;
        if ($imagen)
            $pathImage = $this->uploadImage($imagen);

        $sentencia = $db->prepare("INSERT INTO album(album,imagen) VALUES (?,?)");
        $sentencia->execute([$album, $pathImage]);
    }

    private function uploadImage($image)
    {
        $target = "img/album/" . uniqid() . "." . strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        move_uploaded_file($image['tmp_name'], $target);
        return $target;
    }

    function deleteAlbum($id_album)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("DELETE FROM album WHERE id_album = ?");
        $sentencia->execute([$id_album]);
    }

    function editAlbum($nombre, $id_album)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("UPDATE album SET album = ? where id_album = ?");
        $sentencia->execute([$nombre, $id_album]);
    }
}

?>