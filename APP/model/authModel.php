<?php
require_once "model.php";
class authModel extends model
{

    function getUser($username)
    {
        $db = $this->createConexion();
        $sentencia = $db->prepare('SELECT * FROM usuario WHERE username = ?');
        $sentencia->execute([$username]);
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    
}

?>