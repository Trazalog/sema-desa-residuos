<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad TempalteOrdenTP
*
* @autor Ledesma Sergio
*/
class TemplateOrdenTP extends CI_Model
{
     /**
            * Constructor de Clase
            * @param 
            * @return 
            */
	function __construct()
	{
		parent::__construct();
    }

     /**
        * Trae listado de Todos los Transportistas alias empresa
        * @param 
        * @return string data
     */
    function obtenerEmpresa()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerEmpresa() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/transportistas");
        $aux =json_decode($aux["data"]);
        return $aux->transportistas->transportista;
    }

    /**
        * Trae listado de Todos los Circuitos
        * @param 
        * @return string data
     */
    function obtenerCircuito()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerCircuito() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/circuitos");
        $aux =json_decode($aux["data"]);
        return $aux->circuitos->circuito;
    }

     /**
        * Trae listado de Todos loas Disposiciones finales
        * @param 
        * @return string data
     */
    function obtenerDispFinal()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerDispFinal() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/disposicion_final");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }

     /**
        * Trae listado de Todos los tipo de residuos
        * @param 
        * @return string data
     */
    function obtenerTipoRes()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerTipoRes() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
    }

     /**
        * Trae listado de Todos loas zonas
        * @param 
        * @return string data
     */
    function obtenerZona()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerZona() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/zonas");
        $aux =json_decode($aux["data"]);
        return $aux->zonas->zona;
    }

     /**
        * Trae listado de Todos los choferes
        * @param 
        * @return string data
     */
    function obtenerChofer()
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|obtenerChofer() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/choferes");
        $aux =json_decode($aux["data"]);
        return $aux->choferes->chofer;
    }

     /**
        * Trae listado de Todos vehiculos dado un id de transportistas
        * @param int tran_id
        * @return string data
     */
    function ObtenerVehixtran_id($tran_id)
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP| ObtenerVehixtran_id() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/vehiculos/transp/$tran_id");
        $aux =json_decode($aux["data"]);
        return $aux->vehiculos->vehiculo;
    }

     /**
        * registra nueva template ot
        * @param array datos
        * @return json status
     */
    function RegistrarTemplateOT($datos)
    {
        $usuario_app = userNick();
        $datos["usuario_app"] = $usuario_app;
        $post["_post_templatesOrdenTransporte"]= $datos;
        log_message('INFO','#TRAZA|TemplateOrdenTP|RegistrarTemplateOT() >> '); 
        log_message('DEBUG','#TemplateOrdenTP/RegistrarTemplateOT: '.json_encode($post));
        $aux = $this->rest->callAPI("POST",REST."/templatesOrdenTransporte", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

    /**
        * Lista las template ot
        * @param 
        * @return  json datos
     */
    function Listar_templateOT()
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

    /**
        * actualiza template ot
        * @param array datos
        * @return json status
     */
    function actualizar_templateOT($data)
    {
        $usuario_app = userNick();
        $data["usuario_app"] = $usuario_app;
        log_message('INFO','#TRAZA|TemplateOrdenTP|actualizar_templateOT() >> ');   
        $post["_put_templatesOrdenTransporte"] = $data;
        log_message('DEBUG','#TemplateOrdenTP/actualizar_templateOT: '.json_encode($post));
        $aux = $this->rest->callAPI("PUT",REST."/templatesOrdenTransporte", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
    
    /**
        * Elimina template ot
        * @param array datos
        * @return json status
     */
    function Eliminar_templateOT($data)
    {
        log_message('INFO','#TRAZA|TemplateOrdenTP|Eliminar_templateOT() >> ');   
        $post["_delete_templateOrdenTransporte"] = $data;
        log_message('DEBUG','#TemplateOrdenTP/Eliminar_templateOT: '.json_encode($post));
        $aux = $this->rest->callAPI("DELETE",REST."/templatesOrdenTransporte", $post);
        $aux =json_decode($aux["status"]);
        return $aux;
    }


}

