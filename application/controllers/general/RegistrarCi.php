<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */
class RegistrarCi extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('choferes1_helper');
      //$this->load->helper('choferes1_helper');

      //$this->load->model('general/Choferes');
      //$this->load->model('general/Choferes');
   }

   function registrarCi()
   {
       //$data['Chofer'] = $this->Chofer->obtener();
       //$data['Chofer'] = $this->Chofer->obtener();
       $this->load->view('layout/registrar_circuitos');
   }
   function templateRci()
   {
       //$data['Chofer'] = $this->Chofer->obtener();
       //$data['Chofer'] = $this->Chofer->obtener();
       $this->load->view('layout/registrar_circuitos');
       
   }
}
?>