<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/reports/pesoDeBascula/PesoDeBascula.php";
require APPPATH . "/reports/incidencia/Incidencia.php";
require APPPATH . "/reports/incidenciaPorTransportista/IncidenciaPorTransportista.php";
require APPPATH . "/reports/incidenciaPorMunicipio/IncidenciaPorMunicipio.php";
require APPPATH . "/reports/incidenciaPorZona/IncidenciaPorZona.php";
require APPPATH . "/reports/toneladasPorTransportista/ToneladasPorTransportista.php";
require APPPATH . "/reports/toneladasPorGenerador/ToneladasPorGenerador.php";
require APPPATH . "/reports/toneladasPorResiduo/ToneladasPorResiduo.php";

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

    public function incidenciaPorTransportista()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#INCIDENCIAPORTRANSPORTISTA|');
        $filtro = $this->input->post('data');
        $desde = $filtro['datepickerDesde'];
        $hasta = $filtro['datepickerHasta'];
        if($hasta || $desde)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/incidenciaPorTransportista?desde='.$desde.'&hasta'.$hasta;
            $data = $this->Koolreport->getIncidenciaPorTransportista($url)->transportistas->transportista;
            $reporte = new IncidenciaPorTransportista($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $data = $this->Koolreport->getIncidenciasPorTransportista($url)->transportistas->transportista;
            $reporte = new IncidenciaPorTransportista($data);
            $reporte->run()->render();
        }
    }

    public function filtroIncidenciaPorTransportista()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIAPORTRANSPORTISTA|');
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['reporte'] = 'incidenciaPorTransportista';
        $this->load->view('layout/Filtro',$data);
    }

    public function incidenciaPorMunicipio()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#INCIDENCIAPORMUNICIPIO|');
        $filtro = $this->input->post('data');
        $desde = $filtro['datepickerDesde'];
        $hasta = $filtro['datepickerHasta'];
        if($hasta || $desde)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/incidenciaPorMunicipio?desde='.$desde.'&hasta'.$hasta;
            $data = $this->Koolreport->getIncidenciasPorMunicipio($url)->departamentos->departamento;
            $reporte = new IncidenciaPorMunicipio($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $url = CONSTANTE.'/incidenciaPorMunicipio?desde='.$desde.'&hasta'.$hasta;
            $data = $this->Koolreport->getIncidenciasPorMunicipio($url)->departamentos->departamento;
            $reporte = new IncidenciaPorMunicipio($data);
            $reporte->run()->render();
        }
    }

    public function filtroIncidenciaPorMunicipio()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIAPORMUNICIPIO|');
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['reporte'] = 'incidenciaPorMunicipio';
        $this->load->view('layout/Filtro',$data);
    }

    public function incidenciaPorZona()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#INCIDENCIAPORZONA|');
        $filtro = $this->input->post('data');
        $desde = $filtro['datepickerDesde'];
        $hasta = $filtro['datepickerHasta'];
        if($hasta || $desde)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/incidenciaPorZona?desde='.$desde.'&hasta'.$hasta;
            $data = $this->Koolreport->getIncidenciasPorZona($url)->zonas->zona;
            $reporte = new IncidenciaPorZona($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $data = $this->Koolreport->getIncidenciasPorZona($url)->zonas->zona;
            $reporte = new IncidenciaPorZona($data);
            $reporte->run()->render();
        }
    }

    public function filtroIncidenciaPorZona()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIAPORZONA|');
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['reporte'] = 'incidenciaPorZona';
        $this->load->view('layout/Filtro',$data);
    }

    public function toneladasPorTransportista()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#TONELADASPORTRANSPORTISTA|');
        $filtro = $this->input->post('data');
        $desde = $filtro['datepickerDesde'];
        $hasta = $filtro['datepickerHasta'];
        if($hasta || $desde)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/toneladasPorTransportista?desde='.$desde.'&hasta'.$hasta;
            $data = $this->Koolreport->getToneladasPorTransportista($url);
            $reporte = new ToneladasPorTransportista($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $data = $this->Koolreport->getToneladasPorTransportista($url);
            $reporte = new ToneladasPorTransportista($data);
            $reporte->run()->render();
        }
    }

    public function filtroToneladasPorTransportista()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROTONELADASPORTRANSPORTISTA|');
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['reporte'] = 'toneladasPorTransportista';
        $this->load->view('layout/Filtro',$data);
    }

    public function toneladasPorGenerador()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#TONELADASPORGENERADOR|');
        $filtro = $this->input->post('data');
        $desde = $filtro['datepickerDesde'];
        $hasta = $filtro['datepickerHasta'];
        if($hasta || $desde)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/toneladasPorGenerador?hasta='.$hasta.'&desde'.$desde;
            $data = $this->Koolreport->getToneladasPorGenerador($url);
            $reporte = new ToneladasPorGenerador($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $data = $this->Koolreport->getToneladasPorGenerador($url);
            $reporte = new ToneladasPorGenerador($data);
            $reporte->run()->render();
        }
    }

    public function filtroToneladasPorGenerador()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROTONELADASPORGENERADOR|');
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['reporte'] = 'toneladasPorGenerador';
        $this->load->view('layout/Filtro',$data);
    }

    public function toneladasPorResiduos()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#TONELADASPORRESIDUOS|');
        $filtro = $this->input->post('data');
        $desde = $filtro['datepickerDesde'];
        $hasta = $filtro['datepickerHasta'];
        if($filtro)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $url = CONSTANTE.'/toneladasPorResiduo?desde='.$desde.'&hasta'.$hasta;
            $data = $this->Koolreport->getToneladasPorResiduo($url)->tiposDeCarga->tipoDeCarga;
            $reporte = new ToneladasPorResiduo($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $data = $this->Koolreport->getToneladasPorResiduo($url)->tiposDeCarga->tipoDeCarga;
            $reporte = new ToneladasPorResiduo($data);
            $reporte->run()->render();
        }
    }

    public function filtroToneladasPorResiduo()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROTONELADASPORRESIDUOS|');
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['reporte'] = 'toneladasPorResiduos';
        $this->load->view('layout/Filtro',$data);
    }
}
