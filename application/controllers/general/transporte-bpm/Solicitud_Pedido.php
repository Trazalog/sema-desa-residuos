<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa a la Entidad Solicitud_pedido
*
* @autor SLedesma
*/
class Solicitud_Pedido extends CI_Controller {
    /**
    * Constructor de Clase
    * @param 
    * @return 
    */
   function __construct(){

      parent::__construct();

      $this->load->helper('empresas_helper');
      $this->load->helper('zonas_helper');
      $this->load->helper('tipo_residuos_helper');
      $this->load->helper('circuitos_helper');
      $this->load->helper('disposiciones_finales_helper');
      $this->load->model('general/Zonas');
      $this->load->model('general/Circuitos');
      $this->load->model('general/DisposisionesFinales');
      $this->load->model('general/TipoResiduos');
      $this->load->model('general/Empresas');
      $this->load->model('general/Sectoresdescarga');
      $this->load->model('general/transporte-bpm/SolicitudPedidos');
   }

  
   
   /**
		* carga pantalla solicitud_Pedido
		* @param 
		* @return view Lista solicitud_pedido
		*/
   function templateSolicitudPedidos()
   {
        
        log_message('INFO','#TRAZA|Solicitud_Pedido|templateSolicitudPedidos() >> ');                                                   
        $data['transportista'] = $this->SolicitudPedidos->obtenerTransportista();
        $data['tipocarga'] = $this->SolicitudPedidos->obtener_Tipo_Carga();
        $this->load->view('transporte-bpm/solicitud-pedidos/solicitud_pedido',$data);
       
   }

     /**
		* obtiene los tipos de residuos 
		* @param  string tran_id
		* @return json tipos de residuos
		*/        
   function obtenerTipoRes()
   {
      log_message('INFO','#TRAZA|Solicitud_Pedido|obtenerTipoRes() >> '); 
      $tran_id = $this->input->post('id_transportista');
      $resp = $this->SolicitudPedidos->obtenerTipoResiduos($tran_id);
      echo json_encode($resp);
   }

   /**
		* Lista las solicitudes de pedidos / la tabla que esta fuera del modal agregar
		* @param 
		* @return view Lista_solicitudes_pedidos
		*/  
   function Listar_SolicitudesPedido()
   {
   log_message('INFO','#TRAZA|Solicitud_Pedido|Listar_SolicitudesPedido() >> '); 
   $data['transportista'] = $this->SolicitudPedidos->obtenerTransportista();
   $data["solicitudes"] = $this->SolicitudPedidos->Listar_Solicitudes_pedido();
   $this->load->view('transporte-bpm/solicitud-pedidos/Lista_solicitudes_pedidos',$data);
   }

   /**
		* Resgistra la solicitud de pedidos
		* @param 
		* @return json resp
		*/  
   function registrarSolicitud()
   {
      log_message('INFO','#TRAZA|Solicitud_Pedido|registrarSolicitud() >> '); 
      $resp = $this->SolicitudPedidos->RegistrarContenedor($this->input->post('datos'));
      if(!$resp){
         echo json_encode($resp);
      }
      else{
         log_message('ERROR','#TRAZA|Solicitud|Eliminar_Zona() >> $resp: '.$resp);
         echo 'error';
      }
   }
   
   /**
		* Obtiene todos los tipos de residos 
		* @param 
		* @return json tipos de residuos
		*/  
   function obtenerTipoResTodos()
   {
      
      log_message('INFO','#TRAZA|Solicitud_Pedido|obtenerTipoResTodos() >> '); 
      $resp=$this->SolicitudPedidos->obtener_Tipo_Carga();
      echo json_encode($resp);
   }

}
?>
