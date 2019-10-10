<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarIn extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('estado_helper');

      //$this->load->model('general/Estados');
   }

   function registrarIn()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_inspector');
   }
   function templateIn()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_inspector');
       
   }
}
?>