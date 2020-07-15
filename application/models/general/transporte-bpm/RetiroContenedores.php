<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa el Proceso de Retiro de Contenedores
*
* @autor Hugo Gallardo
*/
class RetiroContenedores extends CI_Model {
  /**
  * Constructor de Clase
  * @param 
  * @return 
  */
  function __construct(){
    parent::__construct();
  }

 
  /**
  * configuracion de la info que muestra la bandeja de entradas por PROCESO
  * @param array $tarea info de tarea en BPM  
  * @return array con info de configuracion de datos para la bandeja de entrada
  */
  public function map($tarea)
  {
      $data['descripcion'] = 'soy una descripcion';

      $aux = new StdClass();
      $aux->color = 'warning';
      $aux->texto = 'yayayayaya';
      $data['info'][] = $aux;
      return $data;
  }

  /**
 * Devuelve contrato para cierre de tarea en BPM y actualiza info en BD 
 * @param array $tarea con datos de tarea en BPM y $form con info para actualizar la BD
 * @return array $contrato con contrato para cierre dee area en BPM 
 */
  public function getContrato($tarea, $form)
  {
    switch ($tarea->nombreTarea) {
        
      case 'Retira contenedores':
        
            $resp = $this->actualizarContenedores($form);
            log_message('DEBUG','#TRAZA|RETIROCONTENEDORES|getContrato($tarea, $form)/Retira contenedores: $resp >> '.json_encode($resp));
            $contrato = $this->contratoRetiro($form);
            log_message('DEBUG','#TRAZA|RETIROCONTENEDORES|getContrato($tarea, $form)/Retira contenedores: $contrato >> '.json_encode($contrato));
            return $contrato;           
            break;       
            
      default:
              # code...
              break;
    }
  }

   /**
  * Despliega datos de tareas en maquetacion segun tarea especifica, para completar en notificacion estandar
  * @param array con info de tarea  
  * @return view vista (maquetacion y datos) de la tarea especifica
  */
  function desplegarVista($tarea)
  {           

    switch ($tarea->nombreTarea) {

      case 'Retira contenedores':

        log_message('INFO','#TRAZA|PEDIDOCONTENEDORES|desplegarVista($tarea): $tarea >> '.json_encode($tarea));
        $data['contenedores'] = $this->obtenerContenedoresARetirar($tarea->caseId);
        $data['vehiculos'] = $this->obtenerVehiculos();
        
        $resp = $this->load->view('transporte-bpm/proceso/retiraContenedores',$data, true);
        return $resp;
        break;
      
      default:
        # code...
        break;
    }    
  }

  /**
  * Actualiza los contenedores entregados
  * @param array id contenedores y dominio de vehiculos
  * @return string status de respuesta del servicio
  */
  function actualizarContenedores($form)
  {     
    log_message('INFO','#TRAZA|RETIROCONTENEDORES|actualizarContenedores($form) >> ');
  
    $temp["_put_contenedoresentregados_vehiculo"] = $form['contAsign'];
    $data["_put_contenedoresentregados_vehiculo_batch_req"] = $temp;

    $aux = $this->rest->callAPI("PUT",REST."/_put_contenedoresentregados_vehiculo_batch_req", $data);
    $aux =json_decode($aux["status"]);
    return $aux;    
  }

  /**
  * Devuelve contratoparacerrar tarea en BPM
  * @param array con info de contratos entregados
  * @return array contrato de cierre de tareas
  */
  function contratoRetiro($form)
  {     
    log_message('INFO','#TRAZA|RETIROCONTENEDORES|contratoRetiro($form) >> ');    
    $contrato = $form['retiro'];
    log_message('DEBUG','#TRAZA|RETIROCONTENEDORES|contratoRetiro($form): $contrato  >> '.json_encode($contrato));
    return $contrato;
  }
  

  // ---------------------- FUNCIONES OBTENER ----------------------

  /**
  * Devuelve listado de contenedores entregados para su retiro
  * @param string case_id
  * @return array contenedores entregados
  */
  function obtenerContenedoresARetirar($case_id)
  {     
    log_message('INFO','#TRAZA|| >> ');
    $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/case/".$case_id);
    $aux =json_decode($aux["data"]);
    return $aux->contenedoresEntregados->contenedor;    
  }

  /**
  * Devuelve vehiculos de una transportista logueado
  * @param 
  * @return array listado decamiones de un transportista
  */
  function obtenerVehiculos()
  {     
    //FIXME: DESHARDCODEAR USER NICK
    //$usuario_app = userNick();
    $usuario_app = 'hugoDS';

    log_message('INFO','#TRAZA|RETIROCONTENEDORES|obtenerVehiculos() >> ');
    log_message('DEBUG','#TRAZA|RETIROCONTENEDORES|$usuario_app >> '.json_encode($usuario_app));
    $aux = $this->rest->callAPI("GET",REST."/vehiculos/transp/usr/".$usuario_app);
    $aux =json_decode($aux["data"]);
    return $aux->vehiculos->vehiculo;
    
  }

}