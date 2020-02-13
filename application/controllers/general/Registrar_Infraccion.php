<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Registrar_Infraccion extends CI_Controller {
    function __construct(){

      parent::__construct();
   }

   // ---------------- Funcion Registrar Infraccion

   function registrarInf()
   {
       $this->load->view('layout/registrar_infraccion');
   }

   // ---------------- Funcion Cargar vista Infracciones
   
   function templateInf()
   {
       $this->load->view('layout/registrar_infraccion');
       
   }
}
?>
