<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {
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
      $this->load->model('general/Estructura/TemplateOrdenTP');
   }

   function ordenT()
   {
       $data['empresa'] = $this->Empresas->obtener();
       $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
       $data['tipoResiduo'] = $this->TipoResiduos->obtener();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/orden_transporte', $data);
   }

   function templateOt()
   {
       $data['empresa'] = $this->TemplateOrdenTP->obtenerEmpresa();
       $data['circuito'] = $this->TemplateOrdenTP->obtenerCircuito();
       $data['disposicionFinal'] = $this->TemplateOrdenTP->obtenerDispFinal();
       $data['tipoResiduo'] = $this->TemplateOrdenTP->obtenerTipoRes();
       $data['zona'] = $this->TemplateOrdenTP->obtenerZona();
       $data['chofer'] = $this->TemplateOrdenTP->obtenerChofer();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/template_ot',$data);
   }

   function solicitudRetiro()
   {
       $data['empresa'] = $this->Empresas->obtener();
       $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
       $data['tipoResiduo'] = $this->TipoResiduos->obtener();
       $data['fecha'] = date('Y-m-d');
       $this->load->view('layout/solicitud_retiro',$data);
   }

   function registrarRecepcionDeOrden()
   {
       $data['zonaDescarga'] = $this->Sectoresdescarga->obtener();
       $this->load->view('layout/registrar_recepcion_de_orden', $data);
   }
   function Controldedescarga()
   {
    
    $this->load->view('layout/control_descarga', $data);
   }

   function nueva()
   {
    
    $this->load->view('layout/nueva_vista', $data);
   }

   function obtenerVehixTran_id()
   {
    $resp = $this->TemplateOrdenTP->ObtenerVehixtran_id($this->input->post('id_empresa'));
    if($resp){
        echo json_encode($resp);
    }
   }
  
   
}
?>