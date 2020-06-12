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

  /**
  * Listado de circuitos
  * @param 
  * @return array listado de circuitos
  */
  function Listar_Circuitos()
  {
      log_message('INFO','#TRAZA|CIRCUITOS|Listar_Circuitos() >> ');
      $aux = $this->rest->callAPI("GET",REST."/circuitos");
      $aux =json_decode($aux["data"]);       
      return $aux->circuitos->circuito;
  }

  /**
  * Guarda Circuito nuevo
  * @param array datos circuito
  * @return int circ_id
  */
  function Guardar_Circuito($data){ 

      log_message('INFO','#TRAZA|CIRCUITOS|Guardar_Circuito($data) >> ');
      $data["usuario_app"] = userNick();
      $post["_post_circuitos"] = $data;
      log_message('DEBUG','#TRAZA|CIRCUITOS|Guardar_Circuito():$post >> '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/circuitos", $post);
      $aux =json_decode($aux["data"]);   
      return $aux;
  }

  /**
  * Guarda un punto critico nuevo
  * @param array con datos de punto critico   
  * @return int pucr_id
  */
  function Guardar_punto_critico($data){

    log_message('INFO','#TRAZA|CIRCUITOS|Guardar_punto_critico($data) >> ');
    $data["usuario_app"] = userNick();
    $post["post_puntos_criticos"] = $data;
    log_message('DEBUG','#TRAZA|CIRCUITOS|Guardar_punto_critico():$post >> '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/puntosCriticos", $post);   
    $aux =json_decode($aux["data"]);   
    return $aux;  
  }

  /**
  * Asocia uno o mas puntos criticos 
  * @param array con uno o mas puntos criticos
  * @return array data de respuesta de servicio
  */
  function Asociar_punto_critico($data){

    log_message('INFO','#TRAZA|CIRCUITOS|Asociar_punto_critico($data) >> ');  
    $arraypuntos["_post_puntoscriticos_circuito"]  = $data;  
    $post["_post_puntoscriticos_batch_req"] = $arraypuntos;    
    log_message('DEBUG','#TRAZA|CIRCUITOS|Asociar_punto_critico():$post >> '.json_encode($post));
    $aux = $this->rest->callAPI("POST",REST."/_post_puntoscriticos_circuito_batch_req", $post);   
    return $aux['status'];     
  }

  /**
  * Guarda tipos de carga asociados a cada circuito
  * @param array con uno o mas tipos de carga
  * @return array con respuesta de servicio
  */
  function Guardar_tipo_carga($data){

      log_message('INFO','#TRAZA|CIRCUITOS|Guardar_tipo_carga($data) >> ');
      $arraycargas["_post_circuitos_tipocarga"]  = $data;  
      $post["_post_circuitos_tipocarga_batch_req"]= $arraycargas;        
      log_message('DEBUG','#TRAZA|CIRCUITOS|Guardar_tipo_carga(): '.json_encode($post));
      $aux = $this->rest->callAPI("POST",REST."/_post_circuitos_tipocarga_batch_req", $post);
      return $aux['status'];          
  }

  /**
  * Actualiza la informacion basica de circuito
  * @param array con datos de circuto
  * @return string $circ_id
  */  
  function actulizaInfoCircuitos($circuitos){
    log_message('INFO','#TRAZA|CIRCUITOS|actulizaInfoCircuitos() >> ');
    $put['_put_circuitos'] = $circuitos;
    $aux = $this->rest->callAPI("PUT",REST."/circuitos",$put);
    $aux =json_decode($aux["status"]);
    return $aux;
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
  * @return bool true o false
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

  /**
  * Borra tipos de carga por circ_id
  * @param int circ_id
  * @return bool true o false
  */
  function deleteTiposCarga($circ_id)
  {     

    log_message('INFO','#TRAZA|CIRCUITOS|deleteTiposCarga($circ_id) >> ');
    $circuito_id['circ_id'] = $circ_id;    
    $data['_delete_circuitos_tipocarga'] = $circuito_id;
    log_message('DEBUG','#TRAZA|CIRCUITOS|deleteTiposCarga($data): $data >> '.json_encode($data));
    $aux = $this->rest->callAPI("DELETE",REST."/circuitos/tipoCarga", $data); 
    $aux =json_decode($aux["status"]);
    return $aux;
  }

  /**
  * Anula la relacion entre puntos criticos y un circuito
  * @param int circ_id
  * @return bool true o false
  */
  function borrar_PCriticosPorCirc($circ_id){

    log_message('INFO','#TRAZA|CIRCUITOS|borrar_PCriticosPorCirc($circ_id) >> ');    
    $circuito_id['circ_id'] = $circ_id;
    $data['_delete_circuitos_tipocarga'] = $circuito_id;
    log_message('DEBUG','#TRAZA|CIRCUITOS|borrar_PCriticosPorCirc($circ_id): $data >> '.json_encode($data));
    $aux = $this->rest->callAPI("DELETE",REST."/puntosCriticos", $data);
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
    return $aux->choferes->chofer;
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

  /**
  * Obtiene imagn guardada por id de circuito
  * @param int circ_id
  * @return bynary imagen
  */
  function obtener_Imagen($circ_id){
    $aux = $this->rest->callAPI("GET",REST."/circuitos/imagen/".$circ_id);
    $aux =json_decode($aux["data"]);
    return $aux->circuito->imagen;
  }

  /**
  * Obtiene el pucr_id de acuerdo al nombre
  * @param string nombre
  * @return int pucr_id
  */
  function ObtenerPucr_id($nombre)
  { 
    log_message('INFO','#TRAZA|CIRCUITOS|ObtenerPucr_id($nombre) >> ');
    log_message('DEBUG','#TRAZA|CIRCUITOS|ObtenerPucr_id($nombre): $nombre >> '.json_encode($nombre));
    $aux = $this->rest->callAPI("GET",REST."/puntosCriticos/nombre/".$nombre);
    $aux =json_decode($aux["data"]);
    return $aux->respuesta->pucr_id;
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

  function obtener_zonaid($zona_id)
  {
    $aux = $this->rest->callAPI("GET",REST."/zonas/$zona_id");
    $aux =json_decode($aux["data"]);
    return $aux->zona;
  }


}