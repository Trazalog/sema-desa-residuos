<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Contenedores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// Funcion Listar Contenedores (MODIFICAR)

    function Listar_Contenedor()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Contenedores->Contenedor;
    }
    
// Funcion Guardar Contenedor

function Guardar_Contenedor($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}
}



// class Registrarcontenedores extends CI_Model

// 	function __construct()
// 	{
// 		parent::__construct();
//     }
    
//     public function guardarDatos($datos){
//         $aux = $this->rest->callAPI("POST","http://localhost:3000/tablacontenedores", $datos);
//         $aux =json_decode($aux["status"]);
//         return $aux;
//     }
