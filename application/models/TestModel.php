<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class testModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerEstablecimientos($esta_id)
    {
        // $url = REST_PRD . "establecimientos/$esta_id"; //asi debe ser, por ahora uso el 1
        $url = REST . '/establecimientos';
        // $url = 'http://10.142.0.7:8280/services/PRDDataService/establecimientos/1';
      $rsp = $this->rest->callApi("GET", $url);
      $rsp = json_decode($rsp['data']);
      return $rsp;
    }

    public function obtenerRecipientesDeposito($data = null)
    {
      $rsp = '{
        "tipos":{
          "tipo":[
            {"nombre":"DEPOSITO"},
            {"nombre":"PRODUCTIVO"},
            {"nombre":"TRANSPORTE"}
            ]
        }
      }';
      return json_decode($rsp);
    }



    // public function getDepositos()
    // {
    //     // $url = REST_PRD.'depositos_establecimiento/1';
    //     $rsp = $this->rest->callAPI("GET",REST_PRD."/depositos_establecimiento/1");
    //     return $rsp;
    // }

    // public function getRecipientes($depo_id)
    // {
    //     $url = REST_PRD."/recipientes/establecimiento/1/deposito/$depo_id/estado/TODOS/tipo/TODOS/categoria/cate_recipienteBOX";
    //     $aux['data'] = wso2($url)['data'];
    //     $url = REST_PRD."/depositos/$depo_id";
    //     $a = $this->rest->callApi('GET',$url);
    //     $b = json_decode($a['data']);
    //     $aux['col'] = $b->deposito->col;
    //     $aux['row'] = $b->deposito->row;
    //     return $aux;
    // }

    public function setRecipiente($data)
    {
        $url = REST_ALM.'/updateRecipiente';
        $aux['reci_tipo'] = $data['tipo'];
        $aux['reci_nombre'] = $data['nombre'];
        $aux['reci_id'] = $data['reci_id'];
        $rsp['_put_updaterecipiente'] = $aux;
        $rsp = wso2($url,'POST',$rsp);
        return $rsp;
    }

}