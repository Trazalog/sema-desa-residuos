<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/reports/pesoDeBascula/PesoDeBascula.php";

class Reportes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('koolreport/Koolreport');
        $this->load->model('koolreport/Opciones_Filtros');
    }

    public function pesoDeBascula()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#PESODEBASCULA|');
        $aux = $this->input->post('data');
        $zona = $aux['zona'];
        $tipoDeResiduo = $aux['tipoDeResiduo'];
        $generador = $aux['generador'];
        $transportista = $aux['transportista'];
        $contenedor = $aux['contenedor'];
        $destino = $aux['destino'];
        $desde = $aux['datepickerDesde'];
        $hasta = $aux['datepickerHasta'];
        if($desde || $hasta || $zona || $tipoDeResiduo || $generador || $transportista || $contenedor || $destino)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/ordenTrabajo?desde='.$desde.'&hasta='.$hasta.'&zona='.$zona.'&tipoDeResiduo='.$tipoDeResiduo.'&generador='.$generador.'&transportista='.$transportista.'&contenedor='.$contenedor.'&destino='.$destino;
            $data = $this->Koolreport->getpesosDeBascula($url)->pesajes->pesaje;
            $reporte = new PesoDeBascula($data);
            $reporte->run()->render();

        }else
        {
            $url = CONSTANTE .'desde//hasta//zona//tipoDeResiduo//generador//transportista//contenedor//destino';
            // $data = $this->Koolreport->getpesosDeBascula($url)->pesajes->pesaje;
            $data = $this->Koolreport->getpesosDeBascula($url)->pesajes->pesaje;
            $reporte = new PesoDeBascula($data);
            $reporte->run()->render();
        }
    }

    public function filtroPesoDeBascula()
    {
        log_message('INFO', '#RESIDUOS| #REPORTES.PHP|#REPORTES|#FILTROPESODEBASCULA|');
        $data = $this->Koolreport->getFiltrosPesos();
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $this->load->view('layout/Filtro',$data);
    }
}
