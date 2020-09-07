<?php
class tasas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tasasModel');
    }

    public function reporteTasas()
    {
        $rsp['contribuyentes'] = $this->tasasModel->obtenerContribuyentes();
        $rsp['reciduos'] = $this->tasasModel->obtenerTDR();
        $rsp['estados'] = $this->tasasModel->obtenerEstados();
        $this->load->view('tasasView',$rsp);
    }

    public function obtenerToneladasLiquidadas()
    {
        $toneladasLiquidadas = $this->tasasModel->obtenerToneladasLiquidadas();
        echo json_encode($toneladasLiquidadas);
    }

    public function toneladasPorContribuyente($contribuyente)
    {
        $rsp = $this->tasasModel->toneladasPorContribuyente($contribuyente);
        echo json_encode($rsp);
    }

    public function toneladasPorReciduo($reciduo)
    {
        $rsp = $this->tasasModel->toneladasPorReciduo($reciduo);
        echo json_encode($rsp);
    }

    public function toneladasPorEstado($estado)
    {
        $rsp = $this->tasasModel->toneladasPorEstado($estado);
        echo json_encode($rsp);
    }

    public function toneladasPorFecha()
    {
        $rsp = $this->input->post();
        $fechas = explode(" - ",$rsp['fechas']);
        $rsp = $this->tasasModel->toneladasPorFecha($fechas);
    }
}