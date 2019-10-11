<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarT extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('rsu_helper');

      $this->load->model('general/Rsu');
   }

   function registrarT()
   {
       $data['Rsu'] = $this->Rsu->obtener();
       $this->load->view('layout/registrar_transportista', $data);
   }
   function templateRt()
   {
       $data['Rsu'] = $this->Rsu->obtener();
       $this->load->view('layout/registrar_transportista', $data);
       
   }
}
?>