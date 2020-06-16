<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/reports/pesoDeBascula/PesoDeBascula.php";
require APPPATH . "/reports/incidencia/Incidencia.php";

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

    public function incidencia()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#INCIDENCIA|');
        $aux = $this->input->post('data');
        $desde = $aux['datepickerDesde'];
        $hasta = $aux['datepickerHasta'];
        $municipio = $aux['municipio'];
        $zona = $aux['zona'];
        $tipoIncidencia = $aux['tipoIncidencia'];
        $generador = $aux['generador'];
        $transportista = $aux['transportista'];
        $estado = $aux['estado'];
        if($desde || $hasta || $municipio  || $zona || $tipoIncidencia || $generador || $transportista || $estado || $destino)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/ordenTrabajo?desde='.$desde.'&hasta='.$hasta.'&municipio='.$municipio.'&zona='.$zona.'&tipoIncidencia='.$tipoIncidencia.'&generador='.$generador.'&transportista='.$transportista.'&estado='.$estado;
            $data = $this->Koolreport->getIncidencias($url)->incidencias->incidencia;
            $reporte = new Incidencia($data);
            $reporte->run()->render();

        }else
        {
            $url = CONSTANTE .'desde//hasta//municipio//zona//tipoIncidencia//generador//transportista//estado';
            $data = $this->Koolreport->getIncidencias($url)->incidencias->incidencia;
            $reporte = new Incidencia($data);
            $reporte->run()->render();
        }
    }

    public function returnCantidadIncidencias()
    {
        return ($this->getCantidadIncidencias());
    }

    public function returnCantidadMunicipalidades($data)
    {
        return($data);
    }
    
    public function filtroIncidencia()
    {
        log_message('INFO', '#RESIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIA|');
        $data = $this->Koolreport->getFiltrosIncidencias();
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $this->returnCantidadMunicipalidades($data['cantidadMunicipios']);
        $this->load->view('reportes/filtro', $data);
    }


}
