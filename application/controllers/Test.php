<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
<<<<<<< Updated upstream
        $this->load->model('TestModel');
=======
        $this->load->model('testModel');
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
    public function obtenerEstablecimientos()
    {
      $esta_id = $this->input->get("esta_id");
      $rsp = $this->TestModel->obtenerEstablecimientos($esta_id)->establecimientos->establecimiento;
      if (isset($rsp)) {
        $this->load->view('test2',$rsp);
        // echo json_encode($rsp);
      } else {
        echo "No existen depositos";
      }
    }

    public function obtenerRecipientesDeposito()
    {
      $data = $this->input->get();
      $rsp = $this->TestModel->obtenerRecipientesDeposito($data)->tipos->tipo;
      if ($rsp) {
        echo json_encode($rsp);
      } else {
        echo "No existen recipientes";
      }
    }

    // public function altaDeposito()
    // {
    //     log_message('INFO','#TRAZA|Deposito|altaDeposito() >>');
    //     $data = $this->TestModel->getDepositos();
    //     $data['depositos'] = json_decode($data['data'])->depositos->deposito;
    //     $this->load->view('test2',$data);
    // }

    // public function obtenerRecipientes($depo_id)
    // {
    //     $rsp = $this->TestModel->getRecipientes($depo_id);
    //     $rsp = $this->load->view('gridRecipientes',$rsp);
    //     return($rsp);
    // }
    public function llenarDeposito()
    {
        $data = $this->input->post();
        $data = $this->TestModel->setRecipiente($data);
=======
    //REPORTE DE INTERNO

    public function reporteInterno()
    {
        $this->load->view('test2');
    }

    public function obtenerEmpresas()
    {
        $rsp = $this->testModel->obtenerEmpresas();
        $rsp = $rsp['data'];
        $rsp = json_decode($rsp);
        $rsp = json_encode($rsp->empresas->empresa);
        echo $rsp;
    }

    public function filtrarEmpresas()
    {
        $rsp = $this->input->post();
        $fechas = explode(" - ",$rsp['fechas']);
        $rsp = $this->tasasModel->FiltrarEmpresas($fechas);
>>>>>>> Stashed changes
    }
}
