<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Zona extends CI_Controller {

    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/Zonas');
     
      
      
   }

// --------------------------------- ZONAS ----------------------------------
  
   // ---------------- Funcion Cargar vista Zonas y Datos
      
      function templateZonas()
      
      {
         $data['Departamentos'] = $this->Zonas->obtener_Departamentos();
         $data['CircuitosAsignados'] = $this->Zonas->obtener_Circuitos_Asignados();
         // $this->load->view('layout/Zonas/Lista_zona',$data);
         $this->load->view('layout/Zonas/registrar_zona',$data);
          
      }
   
      // ---------------- Funcion Registrar Zona
   
      function Guardar_Zona()
      {

         {
            $datos =  $this->input->post('datos');
            $resp = $this->Zonas->Guardar_Zona($datos);
            if($resp){
            echo "ok";
            }else{
            echo "error";
            }
       }

      }
      //------------------funcion Actualizar Zona
      function Actualizar_Zona(){
         $datos =  $this->input->post('datos');
         $datosimg = $this->input->post('datosImg');
         $resp = $this->Zonas->Actualizar_Zona($datos);
         $respimg = $this->Zonas->Actualizar_Zona_Img($datosimg);
         if($resp){
            if($respimg){
               echo "ok";
            }else{
               echo "error";
               }
         
         }else{
            echo "error";
            }
         
      }
   
      // ---------------- Funcion Listar Zona
   
      function Listar_Zona()
      {
         $data["zonas"] = $this->Zonas->Listar_Zonas();         
         $this->load->view('layout/Zonas/Lista_zona',$data);
         
      }
      function Listar_Zona_Tabla()
      {
         $data["zonas"] = $this->Zonas->Listar_Zonas();       
         $this->load->view('layout/Zonas/Lista_zona_tabla',$data);
         
      }
      function MostrarModalEditar(){
          
         $dato["dep"]= $this->Zonas->obtener_Departamentos();
         //$this->load->view('layout/Zonas/registrar_zona',$dato);
         echo json_encode($dato);
       
      }
      function GetImagen(){

         $id = $this->input->post("zona_id");
         $dato= $this->Zonas->obtenerImagen_Zona_Id($id);  
        
         //$this->load->view('layout/Zonas/registrar_zona',$dato);
         echo json_encode($dato);
      }
      function Eliminar_Zona()
      {
        
         $resp = $this->Zonas->eliminar_Zona($this->input->post('datos'));
         if($resp){
            echo "ok";
            }else{
            echo "error";
            }
      }


   
   

   // ---------------- Funciones Obtener ---------------- //

   

      // ---------------- Funcion Obtener Puntos Criticos
      function obtenerDeptoPorZona(){
         $depa_id = $this->input->post('idDepto');
         $resp = $this->Zonas->Asignar_Zona($depa_id);
         echo json_encode($resp);
      }
       
   

}
?>