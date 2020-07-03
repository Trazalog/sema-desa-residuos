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
    // function obtener_Tipo_Carga(){
    // log_message('INFO','#TRAZA|Contenedores|obtener_Tipo_Carga() >> '); 
    // $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    // $aux =json_decode($aux["data"]);
    // return $aux->valores->valor;
    // }
    
    /**
        * Trae listado de Todos loas zonas
        * @param 
        * @return string data
     */
    // function obtener_Zona()
    // {
    //     log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerZona() >> '); 
    //     $aux = $this->rest->callAPI("GET",REST."/zonas");
    //     $aux =json_decode($aux["data"]);
    //     return $aux->zonas->zona;
    // }

    /**
        * Trae listado de Todos los Circuitos
        * @param 
        * @return string data
     */
    // function obtener_Circuito()
    // {
    //     log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerCircuito() >> '); 
    //     $aux = $this->rest->callAPI("GET",REST."/circuitos");
    //     $aux =json_decode($aux["data"]);
    //     return $aux->circuitos->circuito;
    // }

    // function Templatefiltradas($data)
    // {
    //     log_message('INFO','#TRAZA|Contenedores|borrar_tipo_Carga() >> '); 
    //     $post2["filtrar"] = $data;
    //     $aux= $this->rest->callAPI("PUT",REST."recurso", $post2);
    //     $aux =json_decode($aux["data"]);
    //     return $aux;
    // }

    function Listar_OT()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|Listar_templateOT() >> '); 
        $usuario_app = userNick();
        $sotr = $this->rest->callAPI("GET",REST."/solicitantesTransporte/$usuario_app");
        $sotraux =json_decode($sotr["data"]);
        $id_sotr = $sotraux->solicitantes_transporte->sotr_id;
        $aux = $this->rest->callAPI("GET",REST."/templatesOrdenTransporte/list/solicitanteTransporte/$id_sotr");
        $aux =json_decode($aux["data"]);
        return $aux->templatesOrdenTransporte->templateOrdenTransporte;
    }

    function Ejecutar_OT($data)
    {

        log_message('INFO','#TRAZA|TemplateOrdenTP|Listar_templateOT() >> ');
        $usuario_app = userNick();
        $sotr = $this->rest->callAPI("GET",REST."/solicitantesTransporte/$usuario_app");
        $sotraux =json_decode($sotr["data"]);
        $id_sotr = $sotraux->solicitantes_transporte->sotr_id;
        $data["sotr_id"]=$id_sotr;
        $data["usuario_app"] = $usuario_app;
        $post["ordenTransporte"] = $data; 
        $resp = $this->rest->callAPI("POST",API_URL."/ordenTransporte",$post);
        $aux = json_decode($resp["status"]);
        if($aux == 1)
        {return 1;}
        else{return 0;}
        
    }
}