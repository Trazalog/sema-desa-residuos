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
    * Despliega cabeceras usando helpers
    * @param array $tarea con info de tarea desde BPM   
    * @return view cabeceras con info
    */
    function desplegarCabecera($tarea)
    {
      $resp = infoproceso($tarea).infoentidadesproceso($tarea);
      return $resp;
    } 

    /**
    * configuracion de la info que muestra la bandeja de entradas por PROCESO
    * @param array $tarea info de tarea en BPM  
    * @return array con info de configuracion de datos para la bandeja de entrada
    */
    public function map($tarea)
    {
        $data['descripcion'] = 'soy una descripcion';        

        $aux_sol_cont = $this->obtenerInfoSolContenedores($tarea)->solicitud;
        $aux = new StdClass();
        $aux->color = 'warning';
        $aux->texto = 'Estado: '.$aux_sol_cont->estado;
        $data['info'][] = $aux;
        
        $aux = new StdClass();
        $aux->color = 'success';
        $aux->texto = 'Fecha Solic.: '.$aux_sol_cont->fec_alta;
        $data['info'][] = $aux;
        
        $aux = new StdClass();
        $aux->color = 'primary';
        $aux->texto = 'Solicitante: '.$aux_sol_cont->razon_social;
        $data['info'][] = $aux;

        return $data;
    }

    /**
    * Atualiza info en BD y devuelve contrato para cierre de tareas segun las mismas
    * @param array $tarea y $form con info para actualizar
    * @return array $contrato para cierre de tarea en BPM
    */
    public function getContrato($tarea, $form)
    {
        switch ($tarea->nombreTarea) {

            case 'Analizar Solicitud':

                  $response = $this->actualizarSolicitud($form);
                  if (isset($form['motivo'])) {												
                    $respComentario = $this->motivoRechazo($form);
                  }
                  $contrato = $this->contratoAnalisisCont($form);
                  return $contrato;
                  break;

            case 'Confirmar pedido modificado':

                  $contrato = $this->contratoConfirmaPedido($form);
                  return $contrato;        
                  break;  

            case 'Entregar contenedores':
                  $contrato = $this->PedidoContenedores->contratoEntregaContenedor($form);
                                  
                  return $contrato;
              
                  break;     
                  
            default:
                  # code...
                  break;
        }
    }

    /**
    * Despliega datos de tareas en maquetacion segun tarea especifica, para notif estandar
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
          $info_proceso = $this->obtenerInfoSolContenedores($tarea);
          $resp = $this->load->view('transporte-bpm/proceso/analizaSolicitud', $tarea, true);
          return $resp;
          break;

        case 'Confirmar pedido modificado':

          log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
          $tarea->infoSolicitud = $this->obtenerInFoSolicitud($tarea->caseId);
          $soco_id = $tarea->infoSolicitud->soco_id; 
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
          $tarea->camion = $this->ObtenerCamiones();  // camiones por usuario logueado
          $tarea->contenedores =$this->ObtenerContenedores();
          $resp = $this->load->view('transporte-bpm/proceso/entregaContenedor', $tarea, true);
          return $resp;
          break;

        case 'Notificar no aceptación del pedido':

          log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
          $infocontsolicitados = $this->obtenerContSolicitados($tarea->caseId);
          $tarea->motivo_rechazo = $infocontsolicitados[0]->motivo_rechazo;
          $resp = $this->load->view('transporte-bpm/proceso/notificacion', $tarea, true);
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

    /**
    * Devuelve contrato de cierre tarea en BPM
    * @param array $form datos de respuesta pantalla
    * @return array $contrato de cierre con opcion elegida
    */
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

    /**
    * Devuelve informacion de Contenedores Entregados (cant entregadas hasta el momento)
    * @param string soco_id
    * @return array informacion de solicitud de contenedores entregados (cant entregada)
    */
    function obtenerContEntregados($soco_id)
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|obtenerContEntregados($soco_id): $soco_id >> '.json_encode($soco_id));
      $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/$soco_id");
      $aux =json_decode($aux["data"]);
      return $aux->contenedores->contenedor;
    }

    /**
    * Devuelve informacion de Camiones (todos los equipos)
    * @param 
    * @return array informacion de camiones (todos los equipos)
    */
    function ObtenerCamiones()
    {
      $tran_id = usrIdTransportistaByNick();
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|ObtenerCamiones()');
      $aux = $this->rest->callAPI("GET",REST."/vehiculos/transp/".$tran_id);
      $aux =json_decode($aux["data"]);
      return $aux->vehiculos->vehiculo;
    }

    /**
    * Devuelve informacion de Contenedores (del transpotista logueado)
    * @param 
    * @return array informacion de  contenedores (del transpotista logueado)
    */
    function ObtenerContenedores()
    {
      $tran_id = usrIdTransportistaByNick();
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|ObtenerContenedores()');
      log_message('DEBUG','#TRAZA|PEDIDOCONTENEDORES|ObtenerContenedores(): $tran_id >> '.json_encode($tran_id));
      $aux = $this->rest->callAPI("GET",REST."/contenedores/disponibles/transportista/".$tran_id);
      $aux =json_decode($aux["data"]);
      return $aux->contenedores->contenedor;
    }

      /**
    * Guarda informacion de Contenedores a entregar
    * @param array datos de los contenedores a entregar
    * @return json status
    */
    function GuardarContEntregados($datos)
    {
      log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|GuardarContEntregados() >> ');
      $data["_post_contenedores_entregados_entregar"] = $datos;
      $dato["_post_contenedores_entregados_entregar_batch_req"] = $data;
      $aux = $this->rest->callAPI("POST",REST."/_post_contenedores_entregados_entregar_batch_req", $dato);
      $aux =json_decode($aux["status"]);
      return $aux;
    }


    // ---------------------- FUNCIONES BANDEJA DE ENTRADA ----------------------
    
    /**
    * Devuelve info de Solicitud Contenedores para configuracion Bandeja Entrada 
    * @param array $tarea con info de tarea BPM 
    * @return array con info de solicitud de transporte
    */
    function obtenerInfoSolContenedores($tarea)
    {     
      
      $case_id = $tarea->caseId;     
      $aux_sol_cont = $this->rest->callAPI("GET",REST."/solicitudContenedores/info/".$case_id);
      $aux_sol_cont =json_decode($aux_sol_cont["data"]);
      return $aux_sol_cont;
    }

    /**
    * Develve info Generador(solicitante Transporte) para cabecera de Entidad-Proceso
    * @param $tarea con info de tarea BPM
    * @return $aux_tran con info generador
    */
    // function obtenerGenerador($tarea){

    //   $ent_case_id = $tarea->caseId;       
    //   $aux_gen = $this->rest->callAPI("GET",REST."/solicitantesTransporte/case/".$ent_case_id);
    //   $aux_gen =json_decode($aux_gen["data"]);
    //   return $aux_gen;
    // }
    
    /**
    * Devuelve info Transportista para cabecera de Entidad-Proceso
    * @param $tarea con info de tarea BPM
    * @return array $aux_tran con info transportista
    */
    // function obtenerTransportista($tarea){

    //   $ent_case_id = $tarea->caseId;
    //   $aux_tran = $this->rest->callAPI("GET",REST."/transportistas/case/".$ent_case_id);
    //   $aux_tran =json_decode($aux_tran["data"]);
    //   return $aux_tran;
    // }

}    