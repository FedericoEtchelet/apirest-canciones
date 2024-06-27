<?php
require_once "configApi.php";
class tokenApiController{
  public function verificarSeguridadToken($token)
    {
        global $configApi;
        try {

            $itemsJWT = explode('.', $token);
            $payload = json_decode(base64_decode($itemsJWT[1]));
            $usuario = $payload->usuario;
            $clave = $payload->clave;
            if (
                ($usuario == $configApi['Bearer']['user']) &&
                ($clave == $configApi['Bearer']['pass'])
            ) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public  function verificarSeguridad()
    {
        global $configApi;
        $headers = apache_request_headers();
        $autorization = $headers['Authorization'];
        $parametros = explode(' ', $autorization);
        $tipo = $parametros[0];
        $token = $parametros[1];
        if ($tipo == 'Bearer') {
            return $this->verificarSeguridadToken($token);
        } else {
            return false;
        }
    }
}