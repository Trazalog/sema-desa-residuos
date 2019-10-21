<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrarcircuitos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    public function guardarDatos($datos){
        $aux = $this->rest->callAPI("POST","http://localhost:3000/tablacircuitos", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
}