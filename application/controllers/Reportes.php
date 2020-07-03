<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/reports/pesoDeBascula/PesoDeBascula.php";
require APPPATH . "/reports/incidencia/Incidencia.php";
require APPPATH . "/reports/incidenciaPorTransportista/IncidenciaPorTransportista.php";
require APPPATH . "/reports/incidenciaPorMunicipio/IncidenciaPorMunicipio.php";
require APPPATH . "/reports/incidenciaPorZona/IncidenciaPorZona.php";
require APPPATH . "/reports/toneladasEntregadas/ToneladasEntregadas.php";

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
        //filtro debe tener mes o año
        $filtro = $this->input->post('data');
        // $desde = $aux['datepickerDesde'];
        // $hasta = $aux['datepickerHasta'];
        if($filtro)
        {
            // $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            // $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $data = $this->Koolreport->getTransportistas()->transportistas->transportista;
            if(is_numeric($filtro))$url = CONSTANTE.'/incidenciaPorTransportista?anio='.$filtro;
            else $url = CONSTANTE.'/incidenciaPorTransportista?mes='.$filtro;
            foreach($data as $valor)
            {
                $aux->incidencias[$valor->nombre.''] = $this->Koolreport->getIncidenciasPorTransportista($valor->nombre,$url);
            }
            $reporte = new IncidenciaPorTransportista($aux);
            $reporte->run()->render();
        }else
        {
            $data = $this->Koolreport->getTransportistas()->transportistas->transportista;
            $url = CONSTANTE.'desde//hasta';
            foreach($data as $valor)
            {
                $aux->incidencias[$valor->nombre.''] = $this->Koolreport->getIncidenciasPorTransportista($valor->nombre,$url);
            }
            $reporte = new IncidenciaPorTransportista($aux);
            $reporte->run()->render();
        }
    }

    public function filtroIncidenciaPorTransportista()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIAPORTRANSPORTISTA|');
        // $data['calendarioDesde'] = true;
        // $data['calendarioHasta'] = true;
        $data = $this->Koolreport->getFiltroMyA();
        $data->funcion = 'incidenciaPorTransportista';
        $this->load->view('reportes/filtro',$data);
    }

    public function incidenciaPorMunicipio()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#INCIDENCIAPORMUNICIPIO|');
        //debe traer el mes y el año
        $filtro = $this->input->post('data');
        // $desde = $aux['datepickerDesde'];
        // $hasta = $aux['datepickerHasta'];

        if($desde || $hasta)
        {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            $data = $this->Koolreport->getMunicipios()->departamentos->departamento;
            if(is_numeric($filtro))$url = CONSTANTE.'/incidenciaPorMunicipio?anio='.$filtro;
            else $url = CONSTANTE.'/incidenciaPorMunicipio?mes='.$filtro;
            foreach($data as $valor)
            {
                $aux->incidencias[$valor->nombre.''] = $this->Koolreport->getIncidenciasPorMunicipio($valor->nombre,$url);
            }
            $reporte = new IncidenciaPorMunicipio($aux);
            $reporte->run()->render();
        }else
        {
            $data = $this->Koolreport->getMunicipios()->departamentos->departamento;
            $url = CONSTANTE.'desde//hasta';
            foreach($data as $valor)
            {
                $aux->incidencias[$valor->nombre.''] = $this->Koolreport->getIncidenciasPorMunicipio($valor->nombre,$url);
            }
            $reporte = new IncidenciaPorMunicipio($aux);
            $reporte->run()->render();
        }
    }

    public function filtroIncidenciaPorMunicipio()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIAPORMUNICIPIO|');
        $data = $this->Koolreport->getFiltroMyA();
        $data->funcion = 'incidenciaPorMunicipio';
        $this->load->view('reportes/filtro',$data);
    }

    public function incidenciaPorZona()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#INCIDENCIAPORZONA|');
        //filtro puede traer mes o año
        $filtro = $this->input->post('data');
        if($filtro)
        {
            $data = $this->Koolreport->getZonas()->zonas->zona;
            if(is_numeric($filtro))$url = CONSTANTE.'/incidenciaPorZona?anio='.$filtro;
            else $url = CONSTANTE.'/incidenciaPorZona?mes='.$filtro;
            foreach($data as $valor)
            {
                $aux->incidencias[$valor->nombre.''] = $this->Koolreport->getIncidenciasPorZona($valor->nombre,$url);
            }
            $reporte = new IncidenciaPorZona($aux);
            $reporte->run()->render();
        }else
        {
            $data = $this->Koolreport->getZonas()->zonas->zona;
            $url = CONSTANTE.'desde//hasta';
            foreach($data as $valor)
            {
                $aux->incidencias[$valor->nombre.''] = $this->Koolreport->getIncidenciasPorZona($valor->nombre,$url);
            }
            $reporte = new IncidenciaPorZona($aux);
            $reporte->run()->render();
        }
    }

    public function filtroIncidenciaPorZona()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#FILTROINCIDENCIAPORZONA|');
        $data = $this->Koolreport->getFiltroMyA();
        $data->funcion = 'incidenciaPorZona';
        $this->load->view('reportes/filtro',$data);
    }

    public function toneladasEntregadas()
    {
        log_message('INFO', '#RECIDUOS| #REPORTES.PHP|#REPORTES|#TONELADASENTREGADAS|');
        //filtro puede traer mes o año
        $filtro = $this->input->post('data');

        if($filtro)
        {
            $data = $this->Koolreport->getZonas()->zonas->zona;
            if(is_numeric($filtro))$url = CONSTANTE.'/toneladasEntregadas?anio='.$filtro;
            else $url = CONSTANTE.'/toneladasEntregadas?mes='.$filtro;
            $data = $this->Koolreport->getToneladasEntregadas($url);
            $reporte = new ToneladasEntregadas($data);
            $reporte->run()->render();
        }else
        {
            $url = CONSTANTE.'desde//hasta';
            $data = $this->Koolreport->getToneladasEntregadas($url);
            $reporte = new ToneladasEntregadas($data);
            $reporte->run()->render();
        }
    }

    public function toneladasPorGenerador()
    {
        
    }

}
