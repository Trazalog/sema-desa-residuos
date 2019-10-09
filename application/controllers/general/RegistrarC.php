<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarC extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('estado_helper');

      $this->load->model('general/Estados');
   }

   function registrarC()
   {
       $data['Estado'] = $this->Estado->obtener();
       $this->load->view('layout/registrar_contenedor', $data);
   }
   function templateRc()
   {
       $data['Estado'] = $this->Estado->obtener();
       $this->load->view('layout/registrar_contenedor',$data);
       
   }
}
?>