<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Hecha por Jose Roberto el mas vergas */
class RegistrarPp extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('estado_helper');

      //$this->load->model('general/Estados');
   }

   function RegistrarPp()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_procesoproductivo');
   }
   
   function templatePp()
   {
       //$data['Estados'] = $this->Estados->obtener();
       $this->load->view('layout/registrar_procesoproductivo');
       
   }
}
?>