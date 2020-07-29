<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa el Proceso Entrega de Orden de Transportes
*
* @autor Hugo Gallardo
*/
class EntregaOrdenTransportes extends CI_Model {
  
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
      $data['descripcion'] = 'Ingreso de contenedores a PTA';
      $aux = new StdClass();
      $aux->color = 'warning';
      $aux->texto = 'TERSU-BPM03 - Generación Orden de Transporte';
      $data['info'][] = $aux;
      return $data;
  }
  
  /**
  * Devuelve contrato de cierre tarea, ademas graba en BD lo necesario
  * @param array $tarea con info tarea BPM, $form info a guardar en BD
  * @return 
  */
  public function getContrato($tarea, $form)
  {
      log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTES|getContrato($tarea, $form) >> ');

      switch ($tarea->nombreTarea) {
          
          case 'Registra Ingreso':
          
            $resp = $this->entregaOrdenTransporte($form);
            if (!$resp) {
              log_message('ERROR','#TRAZA|ENTREGAORDENTRANSPORTES|getContrato($tarea, $form)/Registra Ingreso >> ERROR ');
              return;
              break; 
            }
            $contrato = $this->contratoIngreso($form);
            return $contrato;
            break;    
            
          
          default:
                # code...
                break;
      }
  }

  /**
  * Desplige vista unica por tarea en notificacion estandar
  * @param array con tarea de bpm
  * @return view de acuerdo a tarea especifica
  */
  function desplegarVista($tarea)
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|desplegarVista($tarea) >> ');
    switch ($tarea->nombreTarea) {

      case 'Registra Ingreso':

        log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|desplegarVista($tarea)|Registra Ingreso: $tarea >> '.json_encode($tarea));
        $tarea->infoOTransporte = $this->obtenerInFoOTransporte($tarea->caseId);
        // dataimage/jpegbase64  20 formato que trae
        // 'data:image/jpeg;base64,' formato que tomael src del tag img
        $imagen = $tarea->infoOTransporte->img_chofer;        
        $newImgChof = substr_replace($imagen, 'data:image/jpeg;base64,', 0, 20);        
        $tarea->infoOTransporte->img_chofer = $newImgChof;

        $imagen_vehi = $tarea->infoOTransporte->img_vehiculo;
        $newImgVehi = substr_replace($imagen_vehi, 'data:image/jpeg;base64,', 0, 20);
        $tarea->infoOTransporte->img_vehiculo = $newImgVehi;

        $tarea->infoContenedores = $this->obtenerContEntregados($tarea->caseId);
        $tarea->sectoresDescarga = $this->obtenerSectoresDescarga();
        $tarea->infoOT = $this->obtenerInfoOTIncidencia($tarea->caseId);
        $tarea->tipoCarga = $this->obtenerTipoCarga();
        $tarea->tipoIncidencia = $this->obtenerTipoIncidencia();
        $resp = $this->load->view('transporte-bpm/proceso/registraIngreso', $tarea, true);
        return $resp;
        break;

      case 'Certifica Vuelco':

        log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|desplegarVista($tarea)|Certifica Vuelco: $tarea >> '.json_encode($tarea));
        $tarea->infoOTransporteCont = $this->obtenerInFoOTransporteCont($tarea->caseId);
        $tarea->infoOTransporte = $this->obtenerInFoOTransporte($tarea->caseId);
        $tarea->TamDeposito = $this->obtenerTamañoDeposito($tarea->infoOTransporteCont[0]->depo_id);
        $tarea->Recipientes = $this->obtenerRecipientes($tarea->infoOTransporteCont[0]->depo_id);
        $tarea->tipoValorizado = $this->obtenerValorizado();
        $resp = $this->load->view('transporte-bpm/proceso/certificadoVuelco', $tarea, true);
        return $resp;
        break; 

      default:
        # code...
        break;
    }  
  }

  /**
  * Actualiza info encontenedores entregados
  * @param array con info de los contenedores entregados y donde
  * @return string status de servicio 
  */
  function entregaOrdenTransporte($form)
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTES|entregaOrdenTransporte() >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|entregaOrdenTransporte($form): $form >> '.json_encode($form));  
    $data['_put_contenedoresentregados_registra_ingreso'] = $form['data'];
    $aux = $this->rest->callAPI("PUT",REST."/contenedoresEntregados/registra/ingreso", $data);
    $aux =json_decode($aux["status"]);
    return $aux;
  }

  /**
  * devuelve contrato de cierre tarea registra ingreso
  * @param array datso de form enviado
  * @return array vontrato de cierre tarea registra ingreso contenedor
  */
  function contratoIngreso($form)
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|contratoIngreso($form) >> '); 
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|contratoIngreso($form): $form >> '.json_encode($form));   
    $contrato["sectorDescarga"] = $form['data']["difi_id"];
    return $contrato;
  }

  // ---------------------- FUNCIONES OBTENER ----------------------

  /**
  * Obtiene la info de la orden de transporte
  * @param string case_id
  * @return array info de orden transporte
  */
  function obtenerInFoOTransporte($caseId)
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInFoOTransporte($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInFoOTransporte($caseId): $caseId  >> '.json_encode($caseId));
    $aux = $this->rest->callAPI("GET",REST."/ordenTransporte/info/entrega/case/".$caseId);
    $aux =json_decode($aux["data"]);
    return $aux->ordenTransporte;    
  }
  
  /**
  * devuelve array con contenedores entregados 
  * @param string case_id
  * @return array con contenedores entregados
  */
  function obtenerContEntregados($caseId)
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerContEntregados($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerContEntregados($caseId): $caseId >> '.json_encode($caseId));
    $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/info/entrega/case/".$caseId);
    $aux =json_decode($aux["data"]);
    return $aux->contenedores->contenedor;    
  }

  /**
  * Devuelve sectores de descarga
  * @param   
  * @return array con sectores de descarga
  */
  function obtenerSectoresDescarga()
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerSectoresDescarga() >> ');
    $aux = $this->rest->callAPI("GET",REST."/tablas/sector_descarga");
    $aux = json_decode($aux["data"]);
    return $aux->valores->valor;
  }

  /**
  * Devuelve info de Otransporte para agregar una incidencia
  * @param string case_id 
  * @return array con info de Orden Transporte
  */
  function obtenerInfoOTIncidencia($caseId)
  {     

    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInfoOTIncidencia($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInfoOTIncidencia($caseId): $caseId  >> '.json_encode($caseId));
    $aux = $this->rest->callAPI("GET",REST."/ordenTransporte/case/".$caseId);
    $aux = json_decode($aux["data"]);
    $date = new DateTime($aux->ordenTransporte->fec_alta);
    $aux->ordenTransporte->fec_alta = $date->format('Y-m-d');  
    return $aux->ordenTransporte;
  }

  /**
  * Devuelve tipos de carga
  * @param 
  * @return array con tipos de carga
  */
  function obtenerTipoCarga()
  {   
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerTipoCarga() >> ');
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;    
  }
  
  /**
  * Devuelve tipos de incidencia 
  * @param 
  * @return array con tipos de incidencia
  */
  function obtenerTipoIncidencia()
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerTipoIncidencia() >> ');
    $aux = $this->rest->callAPI("GET",REST."/tablas/tipos_incidencia");
    $aux =json_decode($aux["data"]);
    return $aux->valores->valor;
  }

  /**
  * devuelve imagen de un contenedor entregado por id
  * @param int coen_id
  * @return base64 imagen de contenedor entregado
  */
  function obtenerImagenContenedor($coen_id)      
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerImagenContenedor($coen_id) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerImagenContenedor($coen_id): $coen_id >> '.json_encode($coen_id));     
    $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/ingreso/".$coen_id);
    $aux =json_decode($aux["data"]);
    return $aux->imag_contenedor->imagen;
  }


  function obtenerTamañoDeposito($depo_id)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerImagenContenedor($coen_id) >> ');
    $aux = $this->rest->callAPI("GET",REST_PRD."/depositos/$depo_id");
    $aux =json_decode($aux["data"]);
    return $aux->deposito;
  }
  function obtenerRecipientes($depo_id)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerImagenContenedor($coen_id) >> ');
    $aux = $this->rest->callAPI("GET",REST_PRD."/recipientes/establecimiento/1/deposito/$depo_id/estado/TODOS/tipo/TODOS/categoria/cate_recipienteBOX");
    $aux =json_decode($aux["data"]);
    return $aux->recipientes->recipiente;
  }
  function obtenerInFoOTransporteCont($caseId)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInFoOTransporte($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInFoOTransporte($caseId): $caseId  >> '.json_encode($caseId));
    $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/info/vuelco/case/".$caseId);
    $aux =json_decode($aux["data"]);
    return $aux->contenedores->contenedor;   
  }

  function CertificadoVuelco($data)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInFoOTransporte($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerInFoOTransporte($caseId): $caseId  >> '.json_encode($caseId));
    $dato[]['_put_contenedoresEntregados_descargar'] = $data['_put_contenedoresEntregados_descargar'];
    $dato[]['_post_contenedoresEntregados_descargar_recipiente'] = $data['_post_contenedoresEntregados_descargar_recipiente'];
   
    // $date['request_box'] = $dato;
    $rsp = requestBox(REST_PRD.'/', $dato);
    $aux = $rsp;
    // $aux2 = $this->rest->callAPI("POST",REST_PRD."/request_box", $date);
    // $aux1 = $this->rest->callAPI("PUT",REST_PRD."/contenedoresEntregados/descargar", $dato1);
    
    // $aux3 =json_decode($aux1["status"]);
    // $aux4 =json_decode($aux1["status"]);
       
  }

  function obtenerValorizado()
  {
        log_message('INFO','#TRAZA|EntregaOrdenTransportes|obtenerValorizado() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga_valorizado");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
  }

}

