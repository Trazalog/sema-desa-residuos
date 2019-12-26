<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarInspectores extends CI_Controller {
    function __construct(){

      parent::__construct();
       $this->load->model('general/Zonag');
      $this->load->model('general/TipoG');
      $this->load->model('general/Dpto');
   }

   function registrarT()
   {
       $data['Zonag'] = $this->Zonag->obtener();
       $data['TipoG'] = $this->TipoG->obtener();
       $data['Dpto'] = $this->Dpto->obtener();
       $this->load->view('layout/registrar_inspectores', $data);
   }
   function templateRg()
   {
       $data['Zonag'] = $this->Zonag->obtener();
       $data['TipoG'] = $this->TipoG->obtener();
       $data['Dpto'] = $this->Dpto->obtener();
       $this->load->view('layout/registrar_inspectores',$data);
       
   }
}
?>