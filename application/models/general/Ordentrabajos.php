<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordentrabajos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    
    public function guardarDatos($datos){
        $aux = $this->rest->callAPI("POST",REST."tabladatos", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

    public function guardarResiduos($datos){
        $aux = $this->rest->callAPI("POST",REST."tablaresiduos", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

    public function guardarRess($datos){
        $aux = $this->rest->callAPI("POST",REST."tablares", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
}
