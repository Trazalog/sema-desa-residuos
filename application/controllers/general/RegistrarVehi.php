<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrarVehi extends CI_Controller {
    function __construct(){

      parent::__construct();
    //   $this->load->helper('condiciones_helper');

    //   $this->load->model('general/Condiciones');
   }

   function templateVehi()
   {
    //    $data['condicion'] = $this->condicion->obtener();
       $this->load->view('layout/registrar_vehiculo',$data);
   }
   
   function templateRg()
   {
       //$data['condicion'] = $this->condicion->obtener();
       $this->load->view('layout/registrar_vehiculo');
   }
}
?>
<!--_____________________________________________________________-->