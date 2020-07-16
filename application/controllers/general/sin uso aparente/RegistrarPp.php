<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarPp extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('etapaproceso_helper');

      //$this->load->model('general/Etapaproceso');
   }

   function RegistrarPp()
   {
       //$data['Etapaproceso'] = $this->Etapaproceso->obtener();
       $this->load->view('layout/registrar_procesoproductivo');
   }
   
   function templatePp()
   {
       //$data['Etapaproceso'] = $this->Etapaproceso->obtener();
       $this->load->view('layout/registrar_procesoproductivo');
       
   }
}
?>