<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Camiones extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

// ----------------------- VEHICULOS ----------------------

// Funcion Listar Vehiculos (MODIFICAR)
function Listar_Vehiculos()
{
    $aux = $this->rest->callAPI("GET",REST."/vehiculos");
    $aux =json_decode($aux["data"]);       
    return $aux->vehiculos->vehiculo;
}
//________________________________________________________

// Funcion Guardar Vehiculo
function Guardar_Vehiculo($data)
{
    $aux = $this->rest->callAPI("POST",REST."/vehiculos", $data);
    $aux =json_decode($aux["status"]);
    return $aux;
}
//________________________________________________________

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener condicion vehiculo
public function obtener_Condicion()
{
    $aux = $this->rest->callAPI("GET",REST."/transportistas");
    $aux =json_decode($aux["data"]);    
    return $aux->condiciones->condicion;
}
//________________________________________________________

// ---------------------- CHOFERES ----------------------

// Funcion Listar Choferes (MODIFICAR)
function Listar_Choferes()
{
    $aux = $this->rest->callAPI("GET",REST."/choferes");
    $aux =json_decode($aux["data"]);       
    return $aux->choferes->chofere;
}
//________________________________________________________

// Funcion Guardar Vehiculo
function Guardar_Choferes($data)
{
    $aux = $this->rest->callAPI("POST",REST."/choferes", $data);
    $aux =json_decode($aux["status"]);
    return $aux;
}
//________________________________________________________

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener condicion vehiculo
public function obtener_Carnet()
{
    $aux = $this->rest->callAPI("GET",REST."/transportistas");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}
//________________________________________________________

}