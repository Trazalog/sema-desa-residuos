<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Transportistas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Transportistas (MODIFICAR)

    function Listar_Transportistas()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Transportistas->Transportista;
    }
    
// Funcion Guardar Municipio

function Guardar_Transportista($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener RSU

    public function obtener(){
    $aux = $this->rest->callAPI("GET","http://localhost:3000/rsu");
    $aux =json_decode($aux["data"]);
    return $aux->Rsu->Rsu;
}







}

