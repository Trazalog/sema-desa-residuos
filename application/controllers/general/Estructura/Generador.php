<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Generador extends CI_Controller {


    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/Generadores');
   }




  

   // ---------------- Funcion Cargar vista Generadores y Datos

   function templateGeneradores()
   {
    
          $data['Departamentos'] = $this->Generadores->obtener_Departamentos();
          $data['Tipogenerador'] = $this->Generadores->obtener_Tipo_Generador();
          $data['Zonagenerador'] = $this->Generadores->obtener_Zonas();
          $data['Tiporesiduo'] = $this->Generadores->obtener_Tipo_residuo();
          $data['Rubro'] = $this->Generadores->obtener_Rubro();           
          $this->load->view('layout/Generadores/registrar_generadores',$data);
          
       
   }

    // ---------------- Funcion Registrar Generador

    function Guardar_Generador()
    {
        $datos =  $this->input->post('datos');
        $resp = $this->Generadores->Guardar_Generadores($datos);        
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
    }
    

    // ---------------- Funcion Crear Generador

   function Listar_Generador()
   {
    $data['generadores'] = $this->Generadores->Lista_generadores();
    $this->load->view('layout/Generadores/Lista_generadores',$data);



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
