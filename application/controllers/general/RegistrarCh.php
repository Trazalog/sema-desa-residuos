<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarCh extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('carnet_helper');

      //$this->load->model('general/Carnet');
   }

   function templateCh()
   {
       //$data['carnet'] = $this->carnet->obtener();
       $this->load->view('layout/registrar_chofer');
   }
   
   function templateRg()
   {
       //$data['carnet'] = $this->carnet->obtener();
       $this->load->view('layout/registrar_chofer');
   }
}
?>
<!--_____________________________________________________________-->