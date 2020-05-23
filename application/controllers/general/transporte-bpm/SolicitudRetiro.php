<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Represent a Solicitud de REtiro de Contenedores
*
* @autor Hugo Gallardo
*/
class SolicitudRetiro extends CI_Controller {

  /**
  * Constructor de Clase
  * @param 
  * @return 
  */
  function __construct()
  {        
    parent::__construct();
    $this->load->model('general/transporte-bpm/SolicitudesRetiro');
  }

  /**
  * Carga pantalla ABM Solicitud retiro y listado general
  * @param 
  * @return 
  */
  function templateSolicitudRetiro()
  {
    $data['transportista'] = $this->SolicitudesRetiro->obtener_Transportista();
    $data['nuevo_sore_id'] = $this->SolicitudesRetiro->solicitudRetiroProx();
    $this->load->view('transporte-bpm/SolicitudRetiro/Registrar_solicitud_retiro', $data);
  }
   
 
  function Guardar_SolicitudRetiro()
  {
    $solicitud = $this->input->post('datos_contenedor');
    var_dump($solicitud);
    
    $usuario['usuario_app'] = 'hugoDS';

    $sore_id = $this->Contenedores->Guardar_SolicitudRetiro();
      
  }
    
  
  function Listar_SolicitudesRetiro()
  {
    // $data["solicitudes_retiros"] = $this->Contenedores->Listar_Solicitudes_retiro();
    $this->load->view('layout/Contenedores/Lista_solicitudes_retiro',$data);
  }
    

 // ---------------- Funciones Obtener --------------------------------//

  /**
  * Devuelve tipos de carga autorizados por transportista
  * @param int tran_id
  * @return array tipos de carga autorizados de un transportista
  */
  function obtener_Tipo_residuo()
  {
    $response = $this->SolicitudesRetiro->obtener_Tipo_residuo($this->input->post('tran_id'));
    echo json_encode($response);
  }
      

     
  

    

      

}