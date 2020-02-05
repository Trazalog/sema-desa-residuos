<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('general/Estructura/Inspectores');
    }

    // ---------------- Funcion Cargar vista Inspector y Datos
    function templateInspectores()
    {
        // $data['Departamentos'] = $this->Generadores->obtener_Departamento();
        // $data['Zonas'] = $this->Generadores->obtener_Zonas();
        // $data['Zonagenerador'] = $this->Infracciones->obtener_Zonas();
        // $data['Tiporesiduo'] = $this->Infracciones->obtener_Tipo_residuo();

        $this->load->view('layout/registrar_inspectores');
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Inspector
    function Guardar_Inspector()
    {
        // $this->load->view('layout/registrar_infraccion');
    }
    // _________________________________________________________

    // ---------------- Funcion Crear Inspector
    function Crear_Inspector()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Modificar Inspector
    function Modificar_Inspector()
    {

    }

    // ---------------- Funcion Suspender Inspector
    function Borrar_Inspector()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Inspector
    function Suspender_Inspector()
    {

    }
    // _________________________________________________________

}
?>