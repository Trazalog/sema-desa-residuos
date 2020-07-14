<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
/**
* Representa a las tareas del Proceso Pedido Contenedores
*
* @autor Hugo Gallardo
*/
class PedidoContenedores extends CI_Model
{
    /**
    * Constructor de Clase
    * @param 
    * @return 
    */
    public function __construct()
    {
        parent::__construct();

    }

    /**
    * Despliega datos de tareas en maquetacion segun tarea especifica, para completar en notificacion estandar
    * @param array con info de tarea  
    * @return view vista (maquetacion y datos) de la tarea especifica
    */
    function desplegarVista($tarea)
    {           
      switch ($tarea->nombreTarea) {

        case 'Analizar Solicitud':

          log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
          $tarea->infoSolicitud = $this->obtenerInFoSolicitud($tarea->caseId);
          $tarea->infoContenedores = $this->obtenerContSolicitados($tarea->caseId);
          $resp = $this->load->view('transporte-bpm/proceso/analizaSolicitud', $tarea, true);
          
          //para probar confirma pedido modificado
          // $soco_id= $tarea->infoSolicitud->soco_id; 
          // $tarea->infoContenedores = $this->obtenerContSolicitadosConfirma($soco_id);
          // $resp = $this->load->view('transporte-bpm/proceso/confirmaPedidoModificado', $tarea, true);
         
          return $resp;
          break;

        case 'Confirmar pedido modificado':
        log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
        $tarea->infoSolicitud = $this->obtenerInFoSolicitud($tarea->caseId);  
        $soco_id= $tarea->infoSolicitud->soco_id; 
        $tarea->infoContenedores = $this->obtenerContSolicitadosConfirma($soco_id);
        $resp = $this->load->view('transporte-bpm/proceso/confirmaPedidoModificado', $tarea, true);
        return $resp;
        break;

        case 'Entregar contenedores':
        log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
        $tarea->infoSolicitud = $this->obtenerInFoSolicitud($tarea->caseId);  
        $soco_id= $tarea->infoSolicitud->soco_id;
        $tarea->infoContenedores = $this->obtenerContSolicitadosConfirma($soco_id);
        $tarea->infoContenedoresEntregados = $this->obtenerContEntregados($soco_id);
        $tarea->camion = $this->ObtenerCamiones();
        $tarea->contenedores =$this->ObtenerContenedores();
        $resp = $this->load->view('transporte-bpm/proceso/entregaContenedor', $tarea, true);
        return $resp;
        break;
        
        default:
          # code...
          break;
      }    
    }

    /**
    * Actualiza cantidades de contenedores pedidos
    * @param array contenedores propuestos, tipos residuos y soco_id
    * @return string resp servicio de actualizacion
    */
    function actualizarSolicitud($form)
    {     
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|actualizarSolicitud($form) >> ');
      
      $temp['_put_contenedoressolicitados_cantidad'] =  $form["contAcordados"];
      $data['_put_contenedoressolicitados_cantidad_batch_req'] = $temp;
      
      log_message('DEBUG','#TRAZA|PEDIDOCONTENEDORES|actualizarSolicitud($cont_prop): $data >> '.json_encode($data));
      
      $aux = $this->rest->callAPI("PUT",REST."/_put_contenedoressolicitados_cantidad_batch_req", $data);
      $aux =json_decode($aux["status"]);
      return $aux;
    }

    /**
    * Devuelve contrato para cerrartarea de acuerdo a opciones
    * @param array con opciones
    * @return array contrato respuesta a tarea anaisis de solicitud contenedor
    */
    function contratoAnalisisCont($form)
    {     
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|contratoAnalisisCont($form) >> ');
      $opcion = $form["elegido"]["opcion"]; //acepta o rechaza
      $igualCant = $form["coincideCant"]["cantIguales"]; // 1 o 0      
            
      if ($opcion == 'acepta') {
        $ejecutar = true;
      }else {
        $ejecutar = false;  
      }  
        
      if ($igualCant['cantIguales']) {            
          $modificado = true;         
      } else {           
          $modificado = false;         
      }                

      $contrato = array(
        "sePuedeEjecutar" => $ejecutar,
        "entregaSinModificaciones" => $modificado
      ); 
      return $contrato;
    }

    function contratoConfirmaPedido($form)
    {
      $opcion = $form["elegido"]["opcion"]; //acepta o rechaza
      if ($opcion == 'acepta') {
        $ejecutar = true;
      }else {
        $ejecutar = false;  
      }  
      $contrato = array(
        "confirmaPedido" => $ejecutar
      ); 
      return $contrato;

    }

    function contratoEntregaContenedor($form)
    {
      $opcion = $form["elegido"]["opcion"]; //acepta o rechaza
      if ($opcion == 'acepta') {
        $ejecutar = false;
        $contrato = array(
          "entregaPendiente" => $ejecutar
        ); 
      }
      return $contrato;
    }
    /**
    * guarda en BD el motivo de rechazo del analisis de solicitud decontenedores
    * @param string motivo de rechazo
    * @return 
    */
    function motivoRechazo($form)
    {     
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|motivoRechazo($form) >> ');

      $temp["motivo_rechazo"] = $form["motivo"]["motivo"]; 
      $temp["soco_id"] = $form["contAcordados"][0]["soco_id"]; 
      $data["_put_contenedoressolicitados_rechazados_motivo"] = $temp;

      $aux = $this->rest->callAPI("PUT",REST."/contenedoresSolicitados/rechazados/motivo", $data);
      $aux =json_decode($aux["status"]);
      return $aux;
    }


    // ---------------------- FUNCIONES OBTENER ----------------------

    /**
    * Devuelve informacion de solicitud de contenedor
    * @param string case_id
    * @return array con informacion de todos los contenedores pedidos
    */
    function obtenerContSolicitados($case_id)
    {          
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerContSolicitados($case_id): $case_id >> '.json_encode($case_id));
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
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerInFoSolicitud($case_id): $case_id >> '.json_encode($case_id));
      $aux = $this->rest->callAPI("GET",REST."/solicitudContenedores/info/".$case_id);
      $aux =json_decode($aux["data"]);
      return $aux->solicitud;
    }

    /**
    * Devuelve informacion de Solicitud de Contenedor modificados (cant propuesta)
    * @param string soco_id
    * @return array informacion de solicitud de contenedores modificados (cant propuesta)
    */
    function obtenerContSolicitadosConfirma($soco_id)
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerContSolicitadosConfirma($soco_id): $soco_id >> '.json_encode($soco_id));
      $aux = $this->rest->callAPI("GET",REST."/contenedoresSolicitados/$soco_id");
      $aux =json_decode($aux["data"]);
      return $aux->contSolicitados->contenedor;
    }
    function obtenerContEntregados($soco_id)
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerContEntregados($soco_id): $soco_id >> '.json_encode($soco_id));
      $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/$soco_id");
      $aux =json_decode($aux["data"]);
      return $aux->contenedores->contenedor;
    }
    function ObtenerCamiones()
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|ObtenerCamiones()');
      $aux = $this->rest->callAPI("GET",REST."/vehiculos");
      $aux =json_decode($aux["data"]);
      return $aux->vehiculos->vehiculo;
    }
    function ObtenerContenedores()
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|ObtenerContenedores()');
      $aux = $this->rest->callAPI("GET",REST."/contenedores");
      $aux =json_decode($aux["data"]);
      return $aux->contenedores->contenedor;
    }
    function GuardarContEntregados($datos)
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|GuardarContEntregados() >> ');
      $data["_post_contenedores_entregados_entregar"] = $datos;
      $dato["_post_contenedores_entregados_entregar_batch_req"] = $data;
      $aux = $this->rest->callAPI("POST",REST."/_post_contenedores_entregados_entregar_batch_req", $dato);
      $aux =json_decode($aux["status"]);
      return $aux;
    }


}    