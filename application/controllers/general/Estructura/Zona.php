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


   
   

   // --------------------------------- CIRCUITOS ----------------------------------

   // ---------------- Funcion Cargar vista CIRCUITOS y Datos

   function templateCircuitos()
   {
      
      $data['tipoResiduos'] = $this->Zonas->obtener_RSU();
      // $data['puntos_criticos'] = $this->Zonas->obtener_Punto_Critico();
      $data['Departamentos'] = $this->Zonas->obtener_Departamentos();
      // $data['zonas_departamento'] = $this->Zonas->obtener_Zona_departamento(); 
      $data['Vehiculo'] = $this->Zonas->obtener_Vehiculo();   
      $data['Chofer'] = $this->Zonas->obtener_Chofer();     
      
      
      $this->load->view('layout/Zonas/registrar_circuitos',$data);
   }
   

   // ---------------- Funcion Registrar Circuito
   function Guardar_Circuito()
   {

       // datos de la vista  
      $datos_circuitos =  $this->input->post('datos_circuito');    
      $datos_puntos_criticos =  $this->input->post('datos_puntos_criticos');
      $datos_tipo_carga =  $this->input->post('datos_tipo_carga'); 
      
       //------------------------------------------------------------------
      // 1 guarda circuito 
      $circ_id = $this->Zonas->Guardar_Circuito($datos_circuitos)->respuesta->circ_id;


       // Operacion de validacion circuito

      if ($circ_id == 0) {
            echo "Circuito no registrado"; return;
      } 
      
      //------------------------------------------------------------------
       // 2 recorro  array puntos agregando id de circ y guardando de a uno     
       for ($i=0; $i < count($datos_puntos_criticos); $i++) { 
        
         $aux[$i]['circ_id'] = $circ_id;
         $aux[$i]['pucr_id'] = $this->Zonas->Guardar_punto_critico($datos_puntos_criticos[$i])->respuesta->pucr_id;
      }
      
      // asociar Id circuito a punto critico
      $resp = $this->Zonas->Asociar_punto_critico($aux);
      if(!$resp['status']){
         echo "punto no asociado";return;
         }
         
      
      // 3  con id circ  agregar a array tipo de carga armar batch  /_post_circuitos_tipocarga_batch_req  
      foreach ($datos_tipo_carga as $key => $carga) {
        
         $tipocarga[$key]['circ_id'] = $circ_id;
         $tipocarga[$key]['tica_id'] = $carga;
      
      }

      $resp = $this->Zonas->Guardar_tipo_carga($tipocarga);

      // Operacion de validacion tipo carga
    
      if (!$resp['status']) {
         echo "tipo carga no asociado";return;
       }
      
      //-------------------------------------------------------------
      

      echo 'ok';
     


   }

   
   

    // ---------------- Funcion Asignar Circuito
    
   function Asignar_Circuito()
   {
        $datos =  $this->input->post('datos');
        $resp = $this->Zonas->Asignar_Zona($datos);
        if($resp){
        echo "ok";
        }else{
        echo "error";
        }
   }

   

   


    

   // ---------------- Funcion Listar Zona
   function Listar_Circuitos()
   {
      $data["circuitos"] = $this->Zonas->Listar_Circuitos();
      $data['puntos_criticos'] = $this->Zonas->obtener_Punto_Critico();
      // $data['Departamentosxzona'] = $this->Zonas->obtener_Departamentoss();
      
      $this->load->view('layout/Zonas/Lista_Circuitos',$data);
   }
   // _________________________________________________________

   //___________________________________________________________//
   //---------------------Funcion Lista Circuito de una Zona en epecifico
   function Listar_Circuito_X_Zona(){
      $zona_id = $this->input->post('zona_id');
      $dato["circuito"] = $this->Zonas->obtener_Id_Circuito($zona_id);
      $aux = $dato["circuito"].cir_id;
      echo json_encode($dato);

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