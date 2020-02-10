<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Generador extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('general/Estructura/Generadores');
    }

    // ---------------- Funcion Cargar vista Generadores y Datos
    function templateGeneradores()
    {
        $data['Departamentos'] = $this->Generadores->obtener_Departamento();
        $data['Zonas'] = $this->Generadores->obtener_Zonas();
        // $data['Zonagenerador'] = $this->Infracciones->obtener_Zonas();
        // $data['Tiporesiduo'] = $this->Infracciones->obtener_Tipo_residuo();

        $this->load->view('layout/registrar_generadores', $data);
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Generador
    function Guardar_Generador()
    {
        $datos =  $this->input->post('datos');
        $resp = $this->Generador->Guardar_Generador($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
    }
    // _________________________________________________________

    // ---------------- Funcion Crear Generador
    function Crear_Generador()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Modificar Generador
    function Modificar_Generador()
    {

    }

    // ---------------- Funcion Suspender Generador
    function Borrar_Generador()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Generador
    function Suspender_Generador()
    {

    }
    // _________________________________________________________

}
?>