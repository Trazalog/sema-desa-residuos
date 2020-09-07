<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class tasasModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerContribuyentes()
    {
        $resourse = 'http://127.0.0.1:8080/contribuyentes';
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function  obtenerTDR()
    {
        $resourse ='http://127.0.0.1:8080/tipoDeReciduos';
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function obtenerEstados()
    {
        $resourse = 'http://127.0.0.1:8080/estadoDeuda';
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function obtenerToneladasLiquidadas()
    {
        $resourse = 'http://127.0.0.1:8080/toneladasLiquidadas';
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function toneladasPorContribuyente($contribuyente)
    {
        $resourse = 'http://127.0.0.1:8080/toneladasLiquidadas/'.$contribuyente;
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function toneladasPorReciduo($reciduo)
    {
        $resourse = 'http://127.0.0.1:8080/toneladasLiquidadas/'.$reciduo;
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function toneladasPorEstado($estado)
    {
        $resourse = 'http://127.0.0.1:8080/toneladasLiquidadas/'.$estado;
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }

    public function toneladasPorFecha($fechas)
    {
        $desde = $fechas[0];
        $hasta = $fecha[1];
        $resourse = 'http://127.0.0.1:8080/toneladasLiquidadas/'.$desde.'/'.$hasta;
        $rsp = wso2($resourse,'GET');
        return $rsp['data'];
    }
}