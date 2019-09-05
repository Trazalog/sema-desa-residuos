<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {
    function __construct(){

      parent::__construct();
      //$this->load->model('general/');
   }
   function index(){
     
   }
   function ordenT()
   {
       $this->load->view('layout/orden_transporte');
   }
   function templateOt()
   {
       $this->load->view('layout/template_ot');
   }
}
?>