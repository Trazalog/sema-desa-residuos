<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('general/Estructura/Inspectores');
    }

    // ---------------- Funcion Cargar vista Inspector
    function templateInspectores()
    {
        $data['vehiculo'] = $this->Inspectores->obtener_Movilidad();
        $data['Departamentos'] = $this->Inspectores->obtener_Departamento();

        $this->load->view('layout/registrar_inspector', $data);
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
    // _________________________________________________________

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