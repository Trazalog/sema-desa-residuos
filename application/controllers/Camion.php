<?php defined('BASEPATH') or exit('No direct script access allowed');

class Camion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Camiones');
    }
    /************funciones de mapa de ultimo registro *****************/
    public function obtener()
    {
        $data['camiones'] = $this->Camiones->obtener()['data'];
        $this->load->view('TestViewMapa',$data);
    }

    public function obtenerUbicaciones()
    {
        $data = $this->input->get();
        $rsp = $this->Camiones->obtenerUbicaciones();
        echo json_encode($rsp);
    }

    public function obtenerUbicacion()
    {
        $data = $this->input->get();
        $rsp = $this->Camiones->obtenerUbicacion($data['dominio']);
        echo json_encode($rsp);
    }
    /****************************************************************/
    public function test()
    {
        $data['camiones'] = $this->Camiones->obtener()['data'];
        $this->load->view('TestViewMapa',$data);
    }
}
