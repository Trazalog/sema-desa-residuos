<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TestModel');
    }

    public function index()
    {
        $this->load->view('test1');
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

    public function altaDeposito()
    {
        log_message('INFO','#TRAZA|Deposito|altaDeposito() >>');
        $data = $this->TestModel->getDepositos();
        $data['depositos'] = json_decode($data['data'])->depositos->deposito;
        $this->load->view('test2',$data);
    }

    public function obtenerRecipientes($depo_id)
    {
        $rsp = $this->TestModel->getRecipientes($depo_id);
        $rsp = $this->load->view('gridRecipientes',$rsp);
        return($rsp);
    }
}
