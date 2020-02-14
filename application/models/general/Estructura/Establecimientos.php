<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Establecimientos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }




    // ---------------------- ESTABLECIMIENTOS----------------------


// Funcion Listar Establecimiento (MODIFICAR)

    function Listar_Establecimiento()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->establecimientos->establecimiento;
    }
    
// Funcion Guardar Establecimiento

function Guardar_Establecimiento($data){

        $post["post_establecimiento"] = $data;
        log_message('DEBUG','#Establecimientos/Guardar_Establecimiento: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
        
        }


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Establecimientos

public function obtener_Establecimiento(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->establecimientos->establecimiento;
}

// Funcion Obtener Depositos

public function obtener_Deposito(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->depositos->deposito;
}

// ---------------------- ASIGNAR ESTABLECIMIENTOS----------------------


// Funcion Listar Recipientes (MODIFICAR)

function Listar_Recipientes()
{
    
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);       
    return $aux->recipientes->recipientes;
}

// Funcion Guardar Recipientes

// function Guardar_Recipientes($data){

//     $post["post_recipiente"] = $data;
//     log_message('DEBUG','#Establecimientos/Guardar_Recipientes: '.json_encode($post));
//     $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
//     $aux =json_decode($aux["status"]);
//     return $aux;
    
//     }


}



