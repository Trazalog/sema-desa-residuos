<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Hecha por Jose Roberto el mas vergas */
class Registrar extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('zona_generadores_helper');
      $this->load->helper('tipo_helper');
      $this->load->helper('departamento_helper');

      $this->load->model('general/Zonag');
      $this->load->model('general/TipoG');
      $this->load->model('general/Dpto');
   }

   function registrarT()
   {
       $data['Zonag'] = $this->Zonag->obtener();
       $data['TipoG'] = $this->TipoG->obtener();
       $data['Dpto'] = $this->Dpto->obtener();
       $this->load->view('layout/registrar_generadores', $data);
   }
   
   function templateRg()
   {
       $data['Zonag'] = $this->Zonag->obtener();
       $data['TipoG'] = $this->TipoG->obtener();
       $data['Dpto'] = $this->Dpto->obtener();
       $this->load->view('layout/registrar_generadores',$data);
       
   }
}
?>