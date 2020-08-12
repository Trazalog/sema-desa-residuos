<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class TestModelMapa extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener()
    {
        $url = REST.'/vehiculos';
        $rsp = wso2($url);
        return $rsp;
    }

    public function obtenerUbicaciones()
    {
        $url = 'http://127.0.0.1:8080/camiones/ubicaciones/ultima/TODOS';
        $rsp = wso2($url);
        $rsp = $rsp['data'];
        return $rsp;
    }

    public function obtenerUbicacion($dominio)
    {
        $url = 'http://127.0.0.1:8080/camiones/ubicaciones/ultima/{dominio}';
        $rsp = wso2($url);
        $rsp = $rsp['data'][0];
        return $rsp;
    }

}