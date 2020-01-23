<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Zonas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }



// ---------------------- FUNCIONES ZONAS ----------------------

// Funcion Listar Zonas (MODIFICAR)

function Listar_Zonas(){
        
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->Zonas->Zona;
    }
    

// Funcion Guardar Zona

function Guardar_Zona($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	

}

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Departamentos

// public function obtener_Departamentos(){
//     $aux = $this->rest->callAPI("GET",REST."/departamentos");
//     $aux =json_decode($aux["data"]);
//     return $aux->Departamentos->Departamento;
// }

// Funcion Obtener Circuitos Asignados

public function obtener_Circuitos_Asignados(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Circuitos->Circuito;
}








// ---------------------- FUNCIONES CIRCUITOS ----------------------


// Funcion Listar Circuitos (MODIFICAR)

function Listar_Circuitos()
{
    
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);       
    return $aux->Circuitos->Circuito;
}


// Funcion Guardar Circuito

function Guardar_Circuito($data){

$aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
$aux =json_decode($aux["status"]);
return $aux;	

}

// Funcion Guardar Zona

function Guardar_Punto_Critico($data){

$aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
$aux =json_decode($aux["status"]);
return $aux;	

}

// Funcion Guardar Zona

function Asignar_Zona($data){

    $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
    $aux =json_decode($aux["status"]);
    return $aux;	

}


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Circuitos

public function obtener_Circuitos(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Ciruitos->Circuito;
}

// Funcion Obtener Punto Critico

public function obtener_Punto_Critico(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Puntos->PuntosCriticos;
}

// Funcion Obtener Tipo RSU

public function obtener_RSU(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Rsu->Rsu;
}

// Funcion Obtener Vehiculo

public function obtener_Vehiculo(){
    $aux = $this->rest->callAPI("GET",REST."/RECURSO");
    $aux =json_decode($aux["data"]);
    return $aux->Vehiculos->Vehiculo;
}

// Funcion Obtener Chofer

public function obtener_Chofer(){
    $aux = $this->rest->callAPI("GET",REST."/choferes");
    $aux =json_decode($aux["data"]);
    return $aux->Choferes->Chofer;
}

// Funcion Obtener Departamentos

public function obtener_Departamentos(){
    $aux = $this->rest->callAPI("GET",REST."/departamentos");
    $aux =json_decode($aux["data"]);
    return $aux->departamentos->departamento;
}

// Funcion Obtener Zona

public function obtener_Zona(){
    $aux = $this->rest->callAPI("GET",REST."/zonas");
    $aux =json_decode($aux["data"]);
    return $aux->zonas->Zona;
}







}



