<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Establecimiento extends CI_Controller {


    function __construct(){

      parent::__construct();

            
            $this->load->model('general/Estructura/Establecimientos');

            
    



   }
  


    // ------------------------ ESTABLECIMIENTOS ------------------------


      // ---------------- Funcion Cargar vista Establecimiento y Datos

      function templateEstablecimientos()
      {
        // $data['establecimientos'] = $this->Establecimientos->obtener_Establecimiento();
         // $data['Depositos'] = $this->Etsablecimientos->obtener_Deposito();
        $this->load->view('layout/Establecimiento/registrar_establecimiento',$data);
          
      }
   
       // ---------------- Funcion Registrar Establecimiento
   
    //    function Guardar_Establecimiento()
    //    {
    //         $datos =  $this->input->post();
    //         $resp = $this->Establecimientos->Guardar_Establecimiento($datos);
    //         if($resp){
    //         echo "ok";
    //         }else{
    //         echo "error";
    //         }
    //     }
   
    

      // ---------------- Funcion Listar Establecimiento
   
      function Listar_Establecimiento()
      {

        // $data["establecimientos"] = $this->Establecimientos->Listar_Establecimientos();
        $this->load->view('layout/Establecimientos/Lista_establecimientos',$data);
          
      }

   
      // ---------------- Funcion Modificar Establecimiento
   
      function Modificar_Establecimiento()
      {
          
          
      }
   
       // ---------------- Funcion Borrar Contenedor
   
       function Borrar_Establecimiento()
       {
           
           
       }
   
       
   
     

      // ---------------- Funciones OBTENER--------------------------------//
      

       // ---------------- Funcion Obtener tipo de residuo
   
       function Obtener_()
       {
           
           
       }

    




       // ------------------------ ASIGNAR RECIPIENTES------------------------

       
      // ---------------- Funcion Cargar vista ASIGNAR RECIPIENTE y Datos

      function templateAsignarEstablecimiento()
      {
        // $data['Establecimiento'] = $this->Establecimientos->obtener_Establecimiento();
        // $data['Deposito'] = $this->Establecimientos->obtener_Deposito();
        $this->load->view('layout/Establecimiento/Asignar_establecimiento',$data);
          
      }
   
       // ---------------- Funcion Registrar Recipiente
   
    //    function Guardar_Recipiente()
    //    {
    //         // $datos =  $this->input->post();
    //         // $resp = $this->Establecimientos->Guardar_Establecimiento($datos);
    //         // if($resp){
    //         // echo "ok";
    //         // }else{
    //         // echo "error";
    //         // }
    //     }
   
       // ---------------- Funcion Crear Deposito
   
    //   function Crear_Deposito()
    //   {
          
          
    //   }

    // ---------------- Funcion Crear Recipiente
   
    //   function Crear_Recipiente()
    //   {
          
          
    //   }

      // ---------------- Funcion Listar Recipientes
   
    //   function Listar_Recipientes()
    //   {

    //     // $data["etsablecimientos"] = $this->Establecimientos->Listar_Establecimientos();
    //     $this->load->view('layout/Establecimientos/Lista_asignacionestablecimiento',$data);
          
    //   }

   
      // ---------------- Funcion Modificar Establecimiento
   
    //   function Modificar_Recipiente()
    //   {
          
          
    //   }
   
       // ---------------- Funcion Borrar Recipientes
   
    //    function Borrar_Recipiente()
    //    {
           
           
    //    }

    
   
       
   

      // ---------------- Funciones OBTENER--------------------------------//
      

       // ---------------- Funcion Obtener Establecimientos
   
       function Obtener_Establecimientos()
       {
           
           
       }

       // ---------------- Funcion Obtener Establecimientos
   
       function Obtener_Deposito()
       {
           
           
       }

        

       
   

}
?>

