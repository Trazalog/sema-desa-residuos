<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Generador extends CI_Controller {


    function __construct(){

      parent::__construct();
   }




  

   // ---------------- Funcion Cargar vista Generadores y Datos

   function templateGeneradores()
   {
    
          // $data['Departamento'] = $this->Infracciones->obtener_Departamento();
          // $data['Tipogenerador'] = $this->Infracciones->obtener_Tipo_Generador();
          // $data['Zonagenerador'] = $this->Infracciones->obtener_Zonas();
          // $data['Tiporesiduo'] = $this->Infracciones->obtener_Tipo_residuo();
    
          $this->load->view('layout/registrar_generadores');
       
   }

    // ---------------- Funcion Registrar Generador

    function Guardar_Generador()
    {
        // $this->load->view('layout/registrar_infraccion');
    }

    // ---------------- Funcion Crear Generador

   function Crear_Generador()
   {
       
       
   }

   // ---------------- Funcion Modificar Generador

   function Modificar_Generador()
   {
       
       
   }

    // ---------------- Funcion Suspender Generador

    function Borrar_Generador()
    {
        
        
    }

    

    // ---------------- Funcion Suspender Generador

   function Suspender_Generador()
   {
       
       
   }

}
?>
