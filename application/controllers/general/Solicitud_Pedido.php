<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud_Pedido extends CI_Controller {
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
   }

   // ---------------- Funcion Registrar Solicitud Pedido

   function registrarSolicitud()
   {
    //    $this->load->view('layout/');
   }

   // ---------------- Funcion Cargar vista Solicitud de Pedido
   
   function templateSolicitudPedidos()
   {
        
        
        $data['empresa'] = $this->Empresas->obtener();
        $data['disposicionFinal'] = $this->DisposisionesFinales->obtener();
        $data['tipoResiduo'] = $this->TipoResiduos->obtener();
        $data['fecha'] = date('Y-m-d');
    
        
        $this->load->view('layout/solicitud_pedido');
       
   }
}
?>
