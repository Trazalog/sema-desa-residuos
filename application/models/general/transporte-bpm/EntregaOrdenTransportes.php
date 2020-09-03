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
  * Despliega cabeceras usando helpers
  * @param array $tarea con info de tarea desde BPM   
  * @return view cabeceras con info
  */
  function desplegarCabecera($tarea)
  {
    $resp = infoproceso($tarea).infoentidadesproceso($tarea);
    return $resp;
  } 

  // /**
  // * Despliega cabeceras usando helpers
  // * @param array $tarea con info de tarea desde BPM   
  // * @return view cabeceras con info
  // */
  // function desplegarCabecera($tarea)
  // {
  //   $resp = infoproceso($tarea).infoentidadesproceso($tarea);
  //   return $resp;
  // }

  /**
  * configuracion de la info que muestra la bandeja de entradas por PROCESO
  * @param array $tarea info de tarea en BPM
  * @return array con info de configuracion de datos para la bandeja de entrada
  */
  public function map($tarea)
  {   
    $data['descripcion'] = 'Ingreso de contenedores a PTA';

    $aux_OT = $this->obtenerInfoEntrega($tarea);
    $deposito = $this->obtenerDeposito($aux_OT->ortr_id);

    $aux = new StdClass();
    $aux->color = 'warning';
    $aux->texto = 'Estado: '.$aux_OT->estado;
    $data['info'][] = $aux;

    $aux = new StdClass();
    $aux->color = 'success';
    $aux->texto = 'Ord. Transporte: '.$aux_OT->ortr_id;
    $data['info'][] = $aux;

    $aux = new StdClass();
    $aux->color = 'primary';
    $aux->texto = 'Dominio: '.$aux_OT->dominio;
    $data['info'][] = $aux;

    $aux = new StdClass();
    $aux->color = 'primary';
    $aux->texto = 'Deposito: '.$deposito->descripcion;
    $aux->depo_id = $deposito->depo_id;
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

          case 'Certifica Vuelco':
            $contrato = $this->ContratoCertificadoVuelco($form);
            return $contrato;
            break;

          case 'Registro Salida':
            $resp = $this->ContenedoresEntrSalida($form); // escribe en DB fecha salida
            $contrato = $this->ContratoRegSalida($form);  // devuelve contrato para cerrar tarea
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
        $tarea->depositos = $this->obtenerDepositos();
        $tarea->infoOT = $this->obtenerInfoOTIncidencia($tarea->caseId);
        $tarea->tipoCarga = $this->obtenerTipoCarga();
        $tarea->tipoIncidencia = $this->obtenerTipoIncidencia();
        $resp = $this->load->view('transporte-bpm/proceso/registraIngreso', $tarea, true);
        return $resp;
        break;

      case 'Certifica Vuelco':

        log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|desplegarVista($tarea)|Certifica Vuelco: $tarea >> '.json_encode($tarea));
        $tarea->infoOTransporteCont = $this->obtenerInFoOTransporteCont($tarea->caseId);
        $tarea->infoOT = $this->obtenerInfoOTIncidencia($tarea->caseId);
        $tarea->tipoCarga = $this->obtenerTipoCarga();
        $tarea->tipoIncidencia = $this->obtenerTipoIncidencia();
        $tarea->infoOTransporte = $this->obtenerInFoOTransporte($tarea->caseId);
        $tarea->TamDeposito = $this->obtenerTamañoDeposito($tarea->infoOTransporteCont[0]->depo_id);
        $tarea->Recipientes = $this->obtenerRecipientes($tarea->infoOTransporteCont[0]->depo_id);
        $tarea->tipoValorizado = $this->obtenerValorizado();
        $tarea->depositos = $this->obtenerDepositos();
        $resp = $this->load->view('transporte-bpm/proceso/certificadoVuelco', $tarea, true);
        return $resp;
        break; 
      
      case 'Registro Salida':
        log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|desplegarVista($tarea)|Registro Salida: $tarea >> '.json_encode($tarea));
        $tarea->infoOTransporte = $this->obtenerInFoOTransporte($tarea->caseId);
        // IMAGEN
        $imagen = $tarea->infoOTransporte->img_chofer;
        $newImgChof = substr_replace($imagen, 'data:image/jpeg;base64,', 0, 20);
        $tarea->infoOTransporte->img_chofer = $newImgChof;

        $imagen_vehi = $tarea->infoOTransporte->img_vehiculo;
        $newImgVehi = substr_replace($imagen_vehi, 'data:image/jpeg;base64,', 0, 20);
        $tarea->infoOTransporte->img_vehiculo = $newImgVehi;
        $tarea->tipoCarga = $this->obtenerTipoCarga();
        $tarea->infoContenedores = $this->obtenerContEntregadosSalida($tarea->caseId);
        $tarea->infoOT = $this->obtenerInfoOTIncidencia($tarea->caseId);
        $tarea->tipoIncidencia = $this->obtenerTipoIncidencia();
        $tarea->contRestanteDescarga = $this->obtenerContRestanteDesc($tarea->caseId);
        $resp = $this->load->view('transporte-bpm/proceso/registraSalida', $tarea, true);
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
  * @return array contrato de cierre tarea registra ingreso contenedor
  */
  function contratoIngreso($form)
  {     
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|contratoIngreso($form) >> '); 
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|contratoIngreso($form): $form >> '.json_encode($form));   
    $contrato["sectorDescarga"] = $form['data']["depo_id"];
    return $contrato;
  }

  /**
  * Contrato de cierre taera Registrar Salida
  * @param array info enviada de la vista
  * @return array contrato cierre
  */
  function ContratoRegSalida($form)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|ContratoRegSalida($form) >> '); 
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|ContratoRegSalida($form): $form >> '.json_encode($form));
    $contrato["quedanContenedores"] = $form['salida']['contrato']['quedanContenedores'];
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

  function obtenerContEntregadosSalida($caseId)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerContEntregadosSalida($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerContEntregadosSalida($caseId): $caseId >> '.json_encode($caseId));
    $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/info/salida/case/".$caseId);
    $aux =json_decode($aux["data"]);
    return $aux->contenedor;    
  }
  /**
  * Devuelve sectores de descarga
  * @param   
  * @return array con sectores de descarga
  */
  function obtenerDepositos()
  { 
    //FIXME: DESHARDCODEAR ESTABLECIMEINTO 1
    $esta_id = 1;
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerSectoresDescarga() >> ');
    $aux = $this->rest->callAPI("GET",REST_PRD."/depositos_establecimiento/".$esta_id);
    $aux = json_decode($aux["data"]);
    return $aux->depositos->deposito;
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

  /**
  * Obtiene cantidad de contenedores que aun no fueron descargados en depositos por OT
  * @param string case_id
  * @return string noEntregados
  */
  function obtenerContRestanteDesc($case_id)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerContRestanteDesc($case_id) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerContRestanteDesc($caseId): $caseId  >> '.json_encode($case_id));
    $aux = $this->rest->callAPI("GET",REST."/contenedoresEntregados/restantes/descarga/case/".$case_id);
    $res =json_decode($aux["data"]);
    return $res->contenedores;
  }


   // ---------------------- FUNCIONES BANDEJA DE ENTRADA ----------------------

  /**
  * Devuelve info de Orden de Transporte para configuracion Bandeja Entrada 
  * @param array $tarea con info de tarea BPM 
  * @return array con info de solicitud de transporte
  */
  function obtenerInfoEntrega($tarea){

    $case_id = $tarea->caseId;
    $aux = $this->rest->callAPI("GET",REST."/ordenTransporte/info/entrega/case/".$case_id);
    $data =json_decode($aux["data"]);
    $aux_OT = $data->ordenTransporte;
    return $aux_OT;
  }

  /**
  * Devuelve deposito donde se descargara el contenedor (info en bandeja de entrada)
  * @param int ortr_id
  * @return array depo_id, depo_nombre
  */
  function obtenerDeposito($ortr_id)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTES|obtenerDeposito($ortr_id) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTES|obtenerDeposito($ortr_id): >> '.json_encode($ortr_id));
    $aux = $this->rest->callAPI("GET",REST."/deposito/descarga/".$ortr_id);
    $aux =json_decode($aux["data"]);
    return $aux->deposito;
    
  }

  // obtenerContEntregados($tarea)
  // $aux_cont = $this->rest->callAPI("GET",REST."/contenedoresEntregados/info/entrega/case/".$case_id);
  // $data_cont =json_decode($aux_cont["data"]);
  // $aux_cont = $data_cont->contenedores->contenedor; 

  // obtenerGenerador($tarea)
  // $aux_gen = $this->rest->callAPI("GET",REST."/solicitantesTransporte/proceso/ingreso/case/".$ent_case_id);
  // $aux_gen =json_decode($aux_gen["data"]);

  // obtenerTransportista($tarea)
  // $aux_tran = $this->rest->callAPI("GET",REST."/transportistas/proceso/ingreso/case/".$ent_case_id);
  // $aux_tran =json_decode($aux_tran["data"]); 

  function obtenerTamañoDeposito($depo_id)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerTamañoDeposito($depo_id) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerTamañoDeposito($depo_id): $depo_id  >> '.json_encode($depo_id));
    $aux = $this->rest->callAPI("GET",REST_PRD."/depositos/$depo_id");
    $aux =json_decode($aux["data"]);
    return $aux->deposito;
  }

  function obtenerRecipientes($depo_id)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerRecipientes($depo_id) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|obtenerRecipientes($depo_id): $depo_id  >> '.json_encode($depo_id));
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
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|CertificadoVuelco($caseId) >> ');
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|CertificadoVuelco($caseId): $data  >> '.json_encode($data));
    $dato[]['_put_contenedoresentregados_descargar'] = $data['_put_contenedoresEntregados_descargar'];
    $dato[]['_post_contenedoresentregados_descargar_recipiente'] = $data['_post_contenedoresEntregados_descargar_recipiente'];

    $rsp = requestBox(REST.'/', $dato);
    $aux = $rsp;
  }

  function obtenerValorizado()
  {
        log_message('INFO','#TRAZA|EntregaOrdenTransportes|obtenerValorizado() >> '); 
        $aux = $this->rest->callAPI("GET",REST."/tablas/tipo_carga_valorizado");
        $aux =json_decode($aux["data"]);
        return $aux->valores->valor;
  }

  function ContratoCertificadoVuelco($form)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|ContratoCertificadoVuelco($form) >> '); 
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|ContratoCertificadoVuelco($form): $form >> '.json_encode($form));   
    $contrato["tieneResiduosPeligrosos"] = $form['ResPeligrosos']["opcion"];
    $contrato["redirecciona"] = $form['redirecciona']["opcion"];
    return $contrato;
  }

  function MoverRecipiente($data)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|MoverRecipiente($data) >> '); 
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|MoverRecipiente($data): $data >> '.json_encode($data));   
    $aux = $this->rest->callAPI("PUT",REST_PRD."/lote/recipiente/mover",$data);
    $aux =json_decode($aux["status"]);
    return $aux;
  }
  function RedireccionarReci($data)
  {
    log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|RedireccionarReci($data) >> '); 
    log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|RedireccionarReci($data): $data >> '.json_encode($data));   
    $aux = $this->rest->callAPI("POST",REST."/contenedoresEntregados/redireccionar",$data);
    $aux =json_decode($aux["status"]);
    return $aux;
  }

  function obtenerImagen_Cont_Id($cont_id)
  {
      log_message('INFO','#TRAZA|Zonas|obtenerImagen_Zona_Id() >> ');   
      log_message('DEBUG','#Zonas/obtenerImagen_Zona_Id: '.json_encode($dato)); 
      $auxx = $this->rest->callAPI("GET",REST."/contenedores/get/imagen/$cont_id");
      $aux =json_decode($auxx["data"]);
      return $aux;
  }

  function ContenedoresEntrSalida($form)
  {
    $dato=$form['salida'];
    $data['cont_id']= $dato['cont_id'];
    $data['ortr_id']= $dato['ortr_id'];
    $post['_put_contenedoresEntregados_salida']= $data;
      log_message('INFO','#TRAZA|ENTREGAORDENTRANSPORTE|ContenedoresEntrSalida($data) >> '); 
      log_message('DEBUG','#TRAZA|ENTREGAORDENTRANSPORTE|ContenedoresEntrSalida($post): $post >> '.json_encode($post));
      $auxx = $this->rest->callAPI("PUT",REST."/contenedoresEntregados/salida",$post);
      $aux =json_decode($auxx["status"]);
      return $aux;
  }

}

