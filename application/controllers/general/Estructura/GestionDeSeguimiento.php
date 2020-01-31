<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GestionDeSeguimiento extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('general/Estructura/Gestiondeseguimiento');
    }

    // ---------------- Funcion Cargar vista Generadores y Datos
    function templateGestion()
    {
        // $data['Departamentos'] = $this->Generadores->obtener_Departamento();
        // $data['Zonas'] = $this->Generadores->obtener_Zonas();
        // $data['Zonagenerador'] = $this->Infracciones->obtener_Zonas();
        // $data['Tiporesiduo'] = $this->Infracciones->obtener_Tipo_residuo();

        $this->load->view('layout/Gestion_de_seguimiento');
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Generador
    function Guardar_Gestion()
    {
        // $this->load->view('layout/registrar_infraccion');
    }
    // _________________________________________________________

    // ---------------- Funcion Crear Generador
    function Crear_Gestion()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Modificar Generador
    function Modificar_Gestion()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Generador
    function Borrar_Gestion()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Generador
    function Suspender_Gestion()
    {

    }
    // _________________________________________________________

}
?>