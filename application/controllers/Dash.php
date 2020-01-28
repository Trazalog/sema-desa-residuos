<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('menu_helper');
      $this->load->helper('file');
   }
   function index(){
     

     # var_dump($this->session->userdata());die;

      $data['menu'] = menu(getJson("menu"));
    
      $this->load->view('layout/Admin',$data);
   }
}
?>