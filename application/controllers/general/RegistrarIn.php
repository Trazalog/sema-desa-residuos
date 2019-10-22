<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Hecha por Jose Roberto el mas vergas */
class RegistrarIn extends CI_Controller {
    function __construct(){

      parent::__construct();
   }

   function registrarIn()
   {
       $this->load->view('layout/registrar_inspector');
   }
   function templateIn()
   {
       $this->load->view('layout/registrar_inspector');
       
   }
}
?>