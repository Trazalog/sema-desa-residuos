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
        $data['camiones'] = $this->TestModelMapa->obtener()['data'];
        $this->load->view('TestViewMapa',$data);
    }

    public function obtenerCamion()
    {
        $data = $this->input->get();
        $rsp = $this->TestModelMapa->obtenerUbicacionCamion($data['dominio']);
        echo json_encode($rsp);
    }
}
