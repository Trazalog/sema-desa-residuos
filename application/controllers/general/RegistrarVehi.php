<!--Controller Pantalla Registrar Chofer-->

<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Hecha por Jose Roberto el mas vergas */
class RegistrarVehi extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->helper('condiciones_helper');

      //$this->load->model('general/Condiciones');
   }

   function templateVehi()
   {
       //$data['condicion'] = $this->condicion->obtener();
       $this->load->view('layout/registrar_vehiculo');
   }
   
   function templateRg()
   {
       //$data['condicion'] = $this->condicion->obtener();
       $this->load->view('layout/registrar_vehiculo');
   }
}
?>
<!--_____________________________________________________________-->