<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
/**
* Representa Proceso de Pedido de Contenedores
*
* @autor Hugo Gallardo
*/
class Pedidos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }


    /**
    * Elige aprobar o rechazar Solicitud de retiro
    * @param array con info de tarea  
    * @return view vista (maquetacion y datos) de la tarea especifica
    */
    function desplegarVista($tarea)
    {     
      log_message('INFO','#TRAZA|PEDIDOS|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
      $tarea->infoSolicitud = $this->obtenerInFoSolicitud($tarea->caseId);
      $tarea->infoContenedores = $this->obtenerContSolicitados($tarea->caseId);
      $resp = $this->load->view('transporte-bpm/proceso/analizaSolicitud', $tarea, true);
      return $resp;
    }

    /**
    * Devuelve informacion de solicitud de contenedor
    * @param string case_id
    * @return array con informacion de todos los contenedores pedidos
    */
    function obtenerContSolicitados($case_id)
    {     
      //TODO: DESHARDCODEAR
      $case_id = 1011;
      log_message('INFO','#TRAZA|PEDIDOS|obtenerContSolicitados($case_id): $case_id >> '.json_encode($case_id));
      $aux = $this->rest->callAPI("GET",REST."/contenedoresSolicitados/case/".$case_id);
      $aux =json_decode($aux["data"]);
      return $aux->contenedores->contenedor;
    }

    /**
    * Devuelve informacion de Solicitud de Contenedor
    * @param string case_id
    * @return array informacion de solicitud de contenedores
    */
    function obtenerInFoSolicitud($case_id)
    {     
      $case_id = 1011;
      log_message('INFO','#TRAZA|PEDIDOS|obtenerInFoSolicitud($case_id): $case_id >> '.json_encode($case_id));
      $aux = $this->rest->callAPI("GET",REST."/solicitudContenedores/info/".$case_id);
      $aux =json_decode($aux["data"]);
      return $aux->solicitud;
    }



}    