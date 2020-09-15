<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class testModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerEmpresas()
    {
        $url = "http://127.0.0.1:8080/Empresas";
        $rsp = $this->rest->callAPI("GET",$url);
        return $rsp;
    }

    public function filtrarEmpresas($fechas)
    {
        $desde = $fechas[0];
        $hasta = $fecha[1];
        $resourse = 'http://127.0.0.1:8080/Empresas/'.$desde.'/'.$hasta;
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }
}