<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrartransportistas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    } 
    
    public function guardarDatos($datos){
        $aux = $this->rest->callAPI("POST","http://localhost:3000/tablatransportistas", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

    public function obtener_RSU(){
        $aux = $this->rest->callAPI("GET","/tablas/tipo_carga");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }
}