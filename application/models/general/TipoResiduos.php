<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TipoResiduos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

    public function obtener(){
         $aux = $this->rest->callAPI("GET","http://localhost:8080/tiporesiduos");
         $aux =json_decode($aux["data"]);
         return $aux->tipoResiduos->tipoResiduo;
    }
}