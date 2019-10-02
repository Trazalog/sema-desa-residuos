<?php defined('BASEPATH') OR exit('No direct script access allowed');

class registrarZ extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('departamento_helper');
      $this->load->helper('circuitos_recorridos_helper');
      $this->load->model('general/Dpto');
      $this->load->model('general/CircR');
   }

   function registrarZ()
   {
       $data['Dpto'] = $this->Dpto->obtener();
       $data['CircR'] = $this->CircR->obtener();
       $this->load->view('layout/registrar_zona', $data);
   }
   function templateRz()
   {
       $data['Dpto'] = $this->Dpto->obtener();
       $data['CircR'] = $this->CircR->obtener();
       $this->load->view('layout/registrar_zona',$data);
       
   }
}
?>