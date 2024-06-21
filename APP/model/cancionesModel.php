<?php
require_once "APP/model/model.php";
class cancionesModel extends model
{

    function getAllSongs()
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM cancion");
        $sentencia->execute();
        $cancion = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $cancion;
    }

    function getSongById($id)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM cancion WHERE id = ?");
        $sentencia->execute([$id]);
        $cancion = $sentencia->fetch(PDO::FETCH_OBJ);
        return $cancion;
    }

    function getSongByAlbum($id_album)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare('SELECT * FROM cancion WHERE id_album = ?');
        $sentencia->execute([$id_album]);
        $cancion = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $cancion;
    }

    function insertSong($nombre, $artista, $id_album)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("INSERT INTO cancion(nombre,artista,id_album) VALUES (?,?,?)");
        $sentencia->execute([$nombre, $artista, $id_album]);
    }

    function delete($id)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("DELETE FROM cancion  WHERE id =  ?");
        $sentencia->execute([$id]);
    }
    function deleteAllSongsByAlbum($id_album)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("DELETE FROM cancion  WHERE id_album =  ?");
        $sentencia->execute([$id_album]);
    }

    function editSong($nombre, $artista, $id_album, $id)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare("UPDATE cancion SET nombre =?,artista=?,id_album=? WHERE id = ?");
        $sentencia->execute([$nombre, $artista, $id_album, $id]);
    }
}
?>