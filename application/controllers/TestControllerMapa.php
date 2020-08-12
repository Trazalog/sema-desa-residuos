<?php defined('BASEPATH') or exit('No direct script access allowed');

class TestControllerMapa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TestModelMapa');
    }

    public function obtener()
    {
        $data['camiones'] = $this->TestModelMapa->obtener()['data'];
        $this->load->view('TestViewMapa',$data);
    }

    public function obtenerUbicaciones()
    {
        $data = $this->input->get();
        $rsp = $this->TestModelMapa->obtenerUbicaciones();
        echo json_encode($rsp);
    }

    public function obtenerUbicacion()
    {
        $data = $this->input->get();
        $rsp = $this->TestModelMapa->obtenerUbicacion($data['dominio']);
        echo json_encode($rsp);
    }
}
