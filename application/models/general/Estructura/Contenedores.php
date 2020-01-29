<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Contenedores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }


    // ---------------- Funciones  CONTENEDOR --------------------------------//

// Funcion Listar Contenedores (MODIFICAR)

    function Listar_Contenedor()
    {
        
        $aux = $this->rest->callAPI("GET",REST."/contenedores");
        $aux =json_decode($aux["data"]);       
        return $aux->contenedores->contenedor;
    }
    
// Funcion Guardar Contenedor

function Guardar_Contenedor($data){

        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Estados

public function obtener_Estados(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->estados->estado;
}


// ---------------- Funciones  SOLICITUD PEDIDO--------------------------------//

// Funcion Listar SOLICITUD PEDIDO (MODIFICAR)

function Listar_Solicitudes_pedido()
{
    
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);       
    return $aux->solicitudes->solicitud;
}

// Funcion Guardar  SOLICITUD PEDIDO

function Guardar_Solicitud_pedido($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	

}


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Contenedores

public function obtener_Contenedores(){
$aux = $this->rest->callAPI("GET",REST."/contenedores");
$aux =json_decode($aux["data"]);
return $aux->contenedores->contenedor;
}

// Funcion Obtener Tipo residuos

// public function obtener_tiporesiduos(){
//     $aux = $this->rest->callAPI("GET",REST."/RECURSO");
//     $aux =json_decode($aux["data"]);
//     return $aux->->;
//     }


// ---------------- Funciones  SOLICITUD RETIRO --------------------------------//


// Funcion Listar SOLICITUD RETIRO (MODIFICAR)

// function Listar_Solicitudes_retiro()
// {
    
//     $aux = $this->rest->callAPI("GET",REST."/RECURSO");
//     $aux =json_decode($aux["data"]);       
//     return $aux->->;
// }

// Funcion Guardar  SOLICITUD RETIRO

// function Guardar_Solicitud_retiro($data){

//     $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
//     $aux =json_decode($aux["status"]);
//     return $aux;	

// }


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Estados

// public function obtener_Estados(){
// $aux = $this->rest->callAPI("GET",REST."/RECURSO");
// $aux =json_decode($aux["data"]);
// return $aux->estados->estado;
// }



}



