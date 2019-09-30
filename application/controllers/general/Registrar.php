<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrar extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('zona_generadores_helper');
      $this->load->helper('tipo_helper');
      $this->load->helper('departamento_helper');

      $this->load->model('general/Zonas');
      $this->load->model('general/Circuitos');
      $this->load->model('general/DisposisionesFinales');
      $this->load->model('general/TipoResiduos');
      $this->load->model('general/Empresas');
   }

   function registrarT()
   {
       $data['tipo'] = $this->tipo->obtener();
       $data['zonag'] = $this->zonag->obtener();
       $data['dpto'] = $this->dpto->obtener();
       $this->load->view('layout/registrar_generadores', $data);
   }
   function templateOt()
   {
       $data['tipo'] = $this->tipo->obtener();
       $data['zonag'] = $this->zonag->obtener();
       $data['dpto'] = $this->dpto->obtener();
       //$this->load->view('layout/template_ot',$data);
       
   }
}
?>