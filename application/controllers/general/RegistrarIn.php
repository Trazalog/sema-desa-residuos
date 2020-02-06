<?php defined('BASEPATH') or exit('No direct script access allowed');

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
