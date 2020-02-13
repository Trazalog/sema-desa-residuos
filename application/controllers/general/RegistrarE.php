<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarE extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('estado_helper');

      //$this->load->model('general/Estados');
   }

   function registrarE()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_establecimiento');
   }
   
   function templateEs()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_establecimiento');
       
   }
}
?>