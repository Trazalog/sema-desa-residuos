<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Camiones extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

// ----------------------- VEHICULOS ----------------------

// Funcion Listar Vehiculos
function Listar_Vehiculo()
{
    $aux = $this->rest->callAPI("GET",REST."/vehiculos");
    $aux =json_decode($aux["data"]);
    return $aux->vehiculos->vehiculo;
}
//________________________________________________________

// Funcion Guardar Vehiculo
function Guardar_Vehiculo($data)
{
    $post["post_vehiculo"] = $data;
    log_message('DEBUG','#Vehiculos/Guardar_Vehiculo: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/vehiculos", $post);
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

// Funcion Listar Choferes
function Listar_Choferes()
{
    $aux = $this->rest->callAPI("GET",REST."/choferes");
    $aux =json_decode($aux["data"]);
    return $aux->choferes->chofere;
}
//________________________________________________________

// Funcion Guardar Choferes
function Guardar_Choferes($data)
{
    $post["post_chofer"] = $data;
    log_message('DEBUG','#Choferes/Guardar_Chofer: '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/choferes", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
}
//________________________________________________________

// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener carnet
public function obtener_Carnet()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carnet");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}
//________________________________________________________

// Funcion Obtener categorias
public function obtener_Categoria()
{
    $aux = $this->rest->callAPI("GET",REST."/tablas/categoria_carnet");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
}
//________________________________________________________

// Funcion Obtener empresa
public function obtener_Empresa()
{
    $aux = $this->rest->callAPI("GET",REST."/transportistas");
    $aux =json_decode($aux["data"]);
    return $aux->transportistas->transportista;
}
//________________________________________________________

}