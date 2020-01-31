<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "/views/reportes/Reporte_Camiones.php";

class Reportes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('koolreport/Koolreport');
        $this->load->model('koolreport/Opciones_Filtros');
    }

    // public function index()
    // {
    //     $url = REST . 'articulos';
    //     $json = $this->Koolreport->depurarJson($url)->materias->materia;

    //     $primerreporte = new Primer_Reporte($json);
    //     $primerreporte->run()->render();
    // }

    // public function panelFiltroEjemplo()
    // {
    //     $url['unidades_medida'] = REST . 'parametros/unidades_medida';
    //     $url['estados'] = 'http://localhost:3000/estados';
    //     $valores['unidades_medida'] = $this->Koolreport->depurarJson($url['unidades_medida'])->parametros->parametro;
    //     $valores['estados'] = $this->Koolreport->depurarJson($url['estados'])->estados->estado;

    //     $data['filtro'] = $this->Opciones_Filtros->ejemplo($valores);
    //     $data['numero'] = 'Stock'; //cambiar el campo de valor numerico para filtrado
    //     $data['desde'] = true;
    //     $data['hasta'] = true;
    //     $data['calendarioDesde'] = true;
    //     $data['calendarioHasta'] = true;
    //     $data['op'] = 'produccion';

    //     $this->load->view('layout/Filtro', $data);
    // }

    public function reporteCamiones()
    {

        $data = $this->input->post('data');

        $producto = $data['producto'];
        $etapa = $data['etapa'];
        $desde = $data['datepickerDesde'];
        $hasta = $data['datepickerHasta'];

        if ($producto || $etapa || $desde || $hasta) {
            $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : null;
            $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : null;
            // var_dump('Desde: ' . $desde . '  Hasta: ' . $hasta);
            log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODUCCION| #ETAPA: >>' . $etapa . '#DESDE: >>' . $desde . '#HASTA: >>' . $hasta);
            $url = REST_TDS . 'productos/etapa/' . $etapa . '/desde/' . $desde . '/hasta/' . $hasta . '/producto/' . $producto;
            $json = $this->Koolreport->depurarJson($url)->productos->producto;
            $reporte = new Produccion($json);
            $reporte->run()->render();
            //echo json_encode(["fals"=>$etapa]);
        } else {
            // $reporte->run()->render();
            // echo json_encode($etapa);
            log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODUCCION| #INGRESO');
            $url = REST_TDS . 'productos/etapa//desde//hasta//producto/';
            $json = $this->Koolreport->depurarJson($url)->productos->producto;
            log_message('DEBUG', '#TRAZA| #REPORTES.PHP|#REPORTES|#PRODRESPONSABLE| #JSON: >>' . $json);
            $reporte = new Produccion($json);
            $reporte->run()->render();
            //echo json_encode(["hola"=>$etapa]);
        }
    }

    public function filtroProduccion()
    {
        log_message('INFO', '#TRAZA| #REPORTES.PHP|#REPORTES|#FILTROPRODUCCION| #INGRESO');
        // $url['responsables'] = '';
        $url['productos'] = REST_TDS . 'productos/list';
        // $url['unidades_medida'] = '';
        $url['etapas'] = REST_TDS . 'etapas/all/list';

        // $valores['responsables'] = $this->Koolreport->depurarJson($url['responsables'])->responsables->responsable;
        $valores['productos'] = $this->Koolreport->depurarJson($url['productos'])->productos->producto;
        // $valores['unidades_medida'] = $this->Koolreport->depurarJson($url['unidades_medida'])->unidades->unidad;
        $valores['etapas'] = $this->Koolreport->depurarJson($url['etapas'])->etapas->etapa;

        $data['filtro'] = $this->Opciones_Filtros->filtrosProduccion($valores);
        // $data['filtro'] = $this->Opciones_Filtros->filtrosProduccion();
        // $data['numero'] = 'Cantidad'; //cambiar el campo de valor numerico para filtrado
        // $data['desde'] = true;
        // $data['hasta'] = true;
        $data['calendarioDesde'] = true;
        $data['calendarioHasta'] = true;
        $data['op'] = "produccion";

        $this->load->view('layout/Filtro', $data);
    }
}
