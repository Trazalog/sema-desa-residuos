<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrarestablecimientos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }
    
    public function guardarDatos($datos){
        $aux = $this->rest->callAPI("POST","http://localhost:3000/tablaestablecimientos", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
}