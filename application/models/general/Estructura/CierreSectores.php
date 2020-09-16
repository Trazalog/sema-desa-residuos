<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad CierreSectores
*
* @autor SLedesma
*/
class CierreSectores extends CI_Model
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
    * Lista Los recipientes del sector 
    * @param 
    * @return array recipientes del sector
    */
    function Lista_Sector()
    {
        log_message('INFO','#TRAZA|CierreSectores|Lista_Sector() >> '); 
        // $aux = $this->rest->callAPI("GET",REST."/solicitantesTransporte");
        // $aux =json_decode($aux["data"]);       
        // return $aux->solicitantes_transporte->solicitante;
    }

    /**
    * Obtiene el tamaño de dicho deposito - sector de descarga
    * @param 
    * @return array  cantidad de recipientes del sector
    */
    function obtenerTamañoDeposito($depo_id)
    {
        log_message('INFO','#TRAZA|CierreSectores|obtenerTamañoDeposito($depo_id) >> ');
        log_message('DEBUG','#TRAZA|CierreSectores|obtenerTamañoDeposito($depo_id): $depo_id  >> '.json_encode($depo_id));
        $aux = $this->rest->callAPI("GET",REST_PRD."/depositos/$depo_id");
        $aux =json_decode($aux["data"]);
        return $aux->deposito;
    }
    
    /**
    * Obtiene los recipientes de ese deposito - sector de descarga
    * @param 
    * @return array recipientes del sector
    */
    function obtenerRecipientes($depo_id)
    {
        log_message('INFO','#TRAZA|CierreSectores|obtenerRecipientes($depo_id) >> ');
        log_message('DEBUG','#TRAZA|CierreSectores|obtenerRecipientes($depo_id): $depo_id  >> '.json_encode($depo_id));
        $aux = $this->rest->callAPI("GET",REST_PRD."/recipientes/establecimiento/1/deposito/$depo_id/estado/TODOS/tipo/TODOS/categoria/cate_recipienteBOX");
        $aux =json_decode($aux["data"]);
        return $aux->recipientes->recipiente;
    }
}

?>