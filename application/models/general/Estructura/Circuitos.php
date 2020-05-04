<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa le entidad Circuitos
*
* @autor Hugo Gallardo
*/
class Circuitos extends CI_Model {

  function __construct()
	{
		parent::__construct();
  }


  // Funcion Listar Circuitos (MODIFICAR)
  function Listar_Circuitos()
  {
      $aux = $this->rest->callAPI("GET",REST."/circuitos");
      $aux =json_decode($aux["data"]);       
      return $aux->circuitos->circuito;
  }

  // Funcion Guardar Circuito
  //NOOOOOO TOCaaar !!!!!!!!!
  function Guardar_Circuito($data){ 
  
      $data["usuario_app"] = userNick();
      $post["_post_circuitos"] = $data;
      log_message('DEBUG','#Zonas/Guardar_Circuito: '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/circuitos", $post);
      $aux =json_decode($aux["data"]);   

      return $aux;
  }

  // Funcion Guardar Punto Critico
  /////NOOOOOOO TOCAAAARRRR  !!!!!
  function Guardar_punto_critico($data){

    $data["usuario_app"] = userNick();
      $post["post_puntos_criticos"] = $data;
      log_message('DEBUG','#Zonas/Guardar_punto_critico: '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/puntosCriticos", $post);   
      $aux =json_decode($aux["data"]);   
      return $aux;       
      
  }

  /////NOOOOOOO TOCAAAARRRR  !!!!!
  // Funcion Asociar punto critico
  function Asociar_punto_critico($data){
      
      $arraypuntos["_post_puntoscriticos_circuito"]  = $data;  
      $post["_post_puntoscriticos_batch_req"]= $arraypuntos;    
      log_message('DEBUG','#Zonas/Asociar_punto_critico: '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/_post_puntoscriticos_circuito_batch_req", $post);   
      return $aux;          
        
  }

  /////NOOOOOOO TOCAAAARRRR  !!!!!
    // Funcion Guardar Tipo de carga Circuito
  function Guardar_tipo_carga($data){

      $arraycargas["_post_circuitos_tipocarga"]  = $data;  
      $post["_post_circuitos_tipocarga_batch_req"]= $arraycargas;
        
      log_message('DEBUG','#Zonas/Guardar_tipo_carga: '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/_post_circuitos_tipocarga_batch_req", $post);
      return $aux;    
      
  }

  /**
  * Actualiza la informacion basica de circuito
  * @param array con datos de circuto
  * @return string $circ_id
  */  
  function actulizaInfoCircuitos(){
    log_message('INFO','#TRAZA|CIRCUITOS|actulizaInfoCircuitos() >> ');
    $aux = $this->rest->callAPI("GET",REST."/ / ");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
  }

  /**
  * Asigna una zona a un circuito determinado
  * @param array zona_id y circ_id
  * @return string ok o error
  */  
  function Asignar_Zona($data)
  {
    log_message('INFO','#TRAZA|CIRCUITOS|Asignar_Zona() >> ');
    $post['_put_circuitos_zonas'] = $data;
    log_message('DEBUG','#TRAZA|CIRCUITOS|Asignar_Zona() $post >> '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/circuitos/zonas ", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
  }

  /**
  * borra un circuito
  * @param int circ_id
  * @return string "ok" o "error"
  */  
  function borrar_Circuito($circ_id)
  {
    log_message('INFO','#TRAZA|CIRCUITOS|borrar_Circuito() >> ');
    $data['circ_id'] = $circ_id;
    $data['eliminado'] = "1";
    $post['_put_circuitos_delete'] = $data;
    log_message('DEBUG','#TRAZA|CIRCUITOS|borrar_Circuito->$post  >> '.json_encode($post));
    $aux = $this->rest->callAPI("PUT",REST."/circuitos/estado", $post);
    $aux =json_decode($aux["status"]);
    return $aux;
  }


// ---------------------- FUNCIONES OBTENER ----------------------

// Funcion Obtener Circuitos
function obtener_Circuitos(){
  $aux = $this->rest->callAPI("GET",REST."/circuitos/5");
  $aux =json_decode($aux["data"]);
  return $aux->zonas->zona;
}

// Funcion Obtener Punto Critico

function obtener_Punto_Critico(){
  $aux = $this->rest->callAPI("GET",REST."/puntosCriticos/1");
  $aux =json_decode($aux["data"]);
  return $aux->puntos->punto;
}

// Funcion Obtener Tipo RSU
function obtener_RSU(){

  log_message('DEBUG', 'Zonas/obtener_RSU');
  $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
  $aux =json_decode($aux["data"]);
  return $aux->valores->valor;
}

// Funcion Obtener Vehiculo
function obtener_Vehiculo(){
  $aux = $this->rest->callAPI("GET",REST."/vehiculos");
  $aux =json_decode($aux["data"]);
  return $aux->vehiculos->vehiculo;
}

// Funcion Obtener Chofer
 function obtener_Chofer(){
  $aux = $this->rest->callAPI("GET",REST."/choferes");
  $aux =json_decode($aux["data"]);
  return $aux->choferes->chofere;
}

/**
* obtiene todos los departamentos
* @param 
* @return array con info basica de departamentos
*/
 function obtener_Departamentos(){
  $aux = $this->rest->callAPI("GET",REST."/departamentos");
  $aux =json_decode($aux["data"]);
  return $aux->departamentos->departamento;
}

/**
* Devuelve zonas por un determinado departamnto
* @param int depa_id
* @return array con info basica de zonas
*/
function obtener_Zona_departamento($depa_id){
  log_message('INFO','#TRAZA|Circuitos| >> ');
  $aux = $this->rest->callAPI("GET",REST."/zonas/departamento/".$depa_id);
  $aux =json_decode($aux["data"]);
  return $aux->zonas->zona;
}



// Funcion Obtener Zona
function obtener_Zona(){
  $aux = $this->rest->callAPI("GET",REST."/zonas");
  $aux =json_decode($aux["data"]);
  return $aux->zonas->Zona;
}



// Funcion Obtener Circuitos Asignados
 function obtener_Circuitos_Asignados(){
  $aux = $this->rest->callAPI("GET",REST."/circuitos/5");
  $aux =json_decode($aux["data"]);
  return $aux->zonas->zona;
}


}