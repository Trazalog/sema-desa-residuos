<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Camion extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('general/Estructura/Camiones');
    }

// ---------------- Funcions CHOFERES ----------------

    // ---------------- Funcion Cargar vista Chofer y Datos
    function templateChoferes()
    {
        $data['carnet'] = $this->Camiones->obtener_Carnet();
        $data['categoria'] = $this->Camiones->obtener_Categoria();
        $data['empresa'] = $this->Camiones->obtener_Empresa();
        // $data[''] = $this->Chofer->obtener_();
        // log_message('DEBUG','ZEROBERTO TROLO'.json_encode($data['empresa']));

        $this->load->view('layout/Choferes/registrar_chofer',$data);
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Chofer
    function Guardar_Chofer()
    {
        $datos =  $this->input->post('datos');
        $resp = $this->Camiones->Guardar_Chofer($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
    }
    // _________________________________________________________

    // ---------------- Funcion Crear Chofer
    function Crear_Chofer()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Listar Choferes
    function Listar_Chofer()
    {
        $data["choferes"] = $this->Camiones->Listar_Chofer();
        $this->load->view('layout/Choferes/lista_choferes',$data);
    }
    // _________________________________________________________

    // ---------------- Funcion Modificar Chofer
    function Modificar_Chofer()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Borrar Chofer
    function Borrar_Chofer()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Chofer
    function Suspender_Chofer()
    {

    }
    // _________________________________________________________

// ---------------- Funciones Obtener ---------------- //

    // ---------------- Funcion Obtener tipo de residuo
    function Obtener_Residuo()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Obtener Transportista
    function Obtener_transportista()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Obtener Generador
    function Obtener_Generador()
    {

    }
    // _________________________________________________________

// ---------------- Funciones VEHICULOS ----------------

    // ---------------- Funcion Cargar vista Vehiculos y Datos
    function templateVehiculos()
    {
        // $data[''] = $this->Infracciones->obtener_();
        // $data[''] = $this->Infracciones->obtener_();
        // $data[''] = $this->Infracciones->obtener_();
        // $data[''] = $this->Infracciones->obtener_();

        $this->load->view('layout/Vehiculos/registrar_vehiculo', $data);
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Vehiculo
    function Guardar_Vehiculo()
    {
        $datos =  $this->input->post('datos');
        $resp = $this->Camiones->Guardar_Vehiculo($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
    }
    // _________________________________________________________

    // ---------------- Funcion Crear Vehiculo
    function Crear_Vehiculo()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Listar Vehiculos
    function Listar_Vehiculo()
    {
        $data["vehiculos"] = $this->Camiones->Listar_Vehiculo();
        $this->load->view('layout/Vehiculos/lista_vehiculos',$data);
    }
    // _________________________________________________________

    // ---------------- Funcion Modificar Vehiculo
    function Modificar_Vehiculo()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Borrar Vehiculo
    function Borrar_Vehiculo()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Vehiculo
    function Suspender_Vehiculo()
    {

    }
    // _________________________________________________________

// ---------------- Funciones Obtener ---------------- //

    // ---------------- Funcion Obtener tipo de carnet
    function Obtener_Carnet()
    {

    }
    // _________________________________________________________

}
?>