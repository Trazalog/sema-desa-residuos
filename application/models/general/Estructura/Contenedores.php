<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contenedores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

// ---------------------- Funciones  CONTENEDOR ----------------------

    // Funcion Listar Contenedores (MODIFICAR)
    function Listar_Contenedor()
    {
        $aux = $this->rest->callAPI("GET",REST."/contenedores");
        $aux =json_decode($aux["data"]);       
        return $aux->contenedores->contenedor;
    }
    // __________________________________________________________

    // Funcion Guardar Contenedor
    function Guardar_Contenedor($data)
    {
        $post["post_contenedor"] = $data;       
        log_message('DEBUG','#Contenedores/Guardar_Contenedor'.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/contenedores", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
    // __________________________________________________________

// ---------------------- FUNCIONES OBTENER ----------------------

    // Funcion Obtener Estados
    public function obtener_Estados()
    {
        $aux = $this->rest->callAPI("GET",REST."/tablas/estado_contenedor");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }
    // __________________________________________________________

// ---------------------- Funciones  SOLICITUD PEDIDO ----------------------

    // Funcion Listar SOLICITUD PEDIDO (MODIFICAR)
    function Listar_Solicitudes_pedido()
    {
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->solicitudes->solicitud;
    }
    // __________________________________________________________

    function Listar_Residuos()
    {
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);       
        return $aux->residuos->residuo;
    }
    // __________________________________________________________

    // Funcion Guardar  SOLICITUD PEDIDO
    function Guardar_Solicitud_pedido($data)
    {
        $post["post_solicitud"] = $data;
        log_message('DEBUG','#Contenedores/Guardar_Solicitud_pedido: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
    // __________________________________________________________

// ---------------------- FUNCIONES OBTENER ----------------------

    // Funcion Obtener Contenedores
    public function obtener_Contenedores()
    {
        $aux = $this->rest->callAPI("GET",REST."/contenedores");
        $aux =json_decode($aux["data"]);
        return $aux->contenedores->contenedor;
    }
    // __________________________________________________________

    // Funcion Obtener  Tipo residuos
    public function obtener_tiporesiduos()
    {
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);
        return $aux->residuos->residuo;
    }
    // __________________________________________________________

    // Funcion Obtener  Tipo residuos
    public function Obtener_empresas()
    {
        $aux = $this->rest->callAPI("GET",REST."/transportistas");
        $aux =json_decode($aux["data"]);
        return $aux->transportistas->transportista;
    }
    // __________________________________________________________

    // Funcion Obtener  recipiente
    public function Obtener_recipiente()
    {
        $aux = $this->rest->callAPI("GET",REST."/lote/todos/deposito");
        $aux =json_decode($aux["data"]);
        return $aux->recipientes->recipiente;
    }
    // __________________________________________________________

    // Funcion Obtener  Habilitacion
    public function Obtener_Habilitacion()
    {
        $aux = $this->rest->callAPI("GET",REST."/tablas/habilitacion_contenedor");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }
    // __________________________________________________________

// ---------------------- Funciones  SOLICITUD RETIRO ----------------------

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