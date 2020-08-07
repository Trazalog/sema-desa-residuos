<?php defined('BASEPATH') or exit('No direct script access allowed');

class TestControllerMapa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TestModelMapa');
    }

    public function obtenerMapa()
    {
        $this->load->view('TestViewMapa');
    }
}
