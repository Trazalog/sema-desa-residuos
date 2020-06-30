<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad Contenedores
*
* @autor SLedesma
*/
class OrdenesMuniMasivas extends CI_Model
{       /**
    * Constructor de Clase
    * @param 
    * @return 
    */
    function __construct()
    {
        parent::__construct();
    }
     /**
        * Obtiene el tipo de carga del contenedor 
        * @param 
        * @return array tipo
        */
    function obtener_Tipo_Carga(){
    log_message('INFO','#TRAZA|Contenedores|obtener_Tipo_Carga() >> '); 
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
    }
    
    /**
        * Trae listado de Todos loas zonas
        * @param 
        * @return string data
     */
    function obtener_Zona()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerZona() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/zonas");
        $aux =json_decode($aux["data"]);
        return $aux->zonas->zona;
    }

    /**
        * Trae listado de Todos los Circuitos
        * @param 
        * @return string data
     */
    function obtener_Circuito()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerCircuito() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/circuitos");
        $aux =json_decode($aux["data"]);
        return $aux->circuitos->circuito;
    }
}