<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Camiones extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }




    // ----------------------- VEHICULOS ------------------------------------

// Funcion Listar Vehiculos (MODIFICAR)

    function Listar_Vehiculos()
    {
        
        $aux = $this->rest->callAPI("GET",REST."RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Vehiculos->Vehiculo;
    }
    
// Funcion Guardar Vehiculo

function Guardar_Vehiculo($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;	

}


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener condicion vehiculo

public function obtener_Condicion(){
    $aux = $this->rest->callAPI("GET",REST."/transportistas");
    $aux =json_decode($aux["data"]);    
    return $aux->condiciones->condicion;
}


    // ----------------------- CHOFERES ------------------------------------

// Funcion Listar Choferes (MODIFICAR)

function Listar_Choferes()
{
    
    $aux = $this->rest->callAPI("GET",REST."RECURSO");
    $aux =json_decode($aux["data"]);       
    return $aux->Choferes->Chofer;
}

// Funcion Guardar Vehiculo

function Guardar_Choferes($data){

$aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	

}


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener condicion vehiculo

public function obtener_Carnet(){
$aux = $this->rest->callAPI("GET",REST."/transportistas");
$aux =json_decode($aux["data"]);    
return $aux->carnets->carnet;
}


}