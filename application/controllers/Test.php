<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
  
    }

    public function index()
    {
        // $data['list'] = datos
        // $this->load->view('test', $data);
    }
    public function pp()
    {
        echo 'esto es una prueba';
    }

    public function datos()
    {
        $data['nombre'] = "Fernando";
        echo json_encode($data);
    }
}
