<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarCi extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('estado_helper');

      //$this->load->model('general/Estados');
   }

   function registrarCi()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_circuitos', $data);
   }
   function templateRci()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_circuitos',$data);
       
   }
}
?>