<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad Incidencias
*
* @autor SLedesma
*/
class Incidencias extends CI_Model
{       /**
    * Constructor de Clase
    * @param 
    * @return 
    */
    function __construct()
    {
        parent::__construct();
    }

    public function guardarIncidencias($datos)
    {
      $post["incidencia"] = $datos;
      $aux = $this->rest->callAPI("POST","/incidencias", $post);
      $aux =json_decode($aux["status"]);
      return $aux;
    }
    function ObtenerOT($nro)
    {
      $aux = $this->rest->callAPI("GET",REST."/ordenesTransporte/lista/$nro");
      $aux =json_decode($aux["data"]);
      return $aux->ordenTransporte->ordenesTransporte;
    }

    function getTipoResiduos()
    {
      log_message('INFO','#TRAZA|Contenedores|obtener_Estado() >> '); 
      $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
      $aux =json_decode($aux["data"]);
      return $aux->valores->valor;
    }

    function getDispFinal(){
      log_message('INFO','#TRAZA|Contenedores|obtener_Estado() >> '); 
      $aux = $this->rest->callAPI("GET",REST."/tablas/disposicion_final");
      $aux =json_decode($aux["data"]);
      return $aux->valores->valor;
    }

    function getIncidencia()
    {
      log_message('INFO','#TRAZA|Contenedores|obtener_Estado() >> '); 
      $aux = $this->rest->callAPI("GET",REST."/tablas/tipos_incidencia");
      $aux =json_decode($aux["data"]);
      return $aux->valores->valor;
    }

    function ObtenerProximoID()
    {
      $aux = $this->rest->callAPI("GET",REST."/ordenTransporte/prox");
      $aux =json_decode($aux["data"]);
      return $aux->respuesta;
    }

}