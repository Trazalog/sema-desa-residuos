<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa a la Entidad Zona
*
* @autor SLedesma
*/
class Zona extends CI_Controller {
    /**
    * Constructor de Clase
    * @param 
    * @return 
    */
    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/Zonas');
     
      
      
   }


    /**
    * Carga pantalla Registrar Zona y listado   
    * @param 
    * @return view Zonas
    */
      function templateZonas()
      
      {
         log_message('INFO','#TRAZA|Zona|templateZonas() >>');
         $data['Departamentos'] = $this->Zonas->obtener_Departamentos();
        
         $this->load->view('layout/Zonas/registrar_zona',$data);
          
      }
   
     
      /**
      * Guarda zona nueva
      * @param array datos zona 
      * @return string "ok, error"
      */
      function Guardar_Zona()
      {

         {
            log_message('INFO','#TRAZA|Zona|Guardar_Zona() >>');
            $datos =  $this->input->post('datos');
            $resp = $this->Zonas->Guardar_Zona($datos);
            if($resp){
            echo "ok";
            }else{
            log_message('ERROR','#TRAZA|Zona|Guardar_Zona() >> $resp: '.$resp);
            echo "error";
            }
       }

      }
      
       /**
      * Actualiza datos de Zona
      * @param array datos zona y datos de imagen
      * @return string "error, ok"
      */
      function Actualizar_Zona(){
         log_message('INFO','#TRAZA|Zona|Actualizar_Zona() >>');
         $datos =  $this->input->post('datos');
         $datosimg = $this->input->post('datosImg');
         $resp = $this->Zonas->Actualizar_Zona($datos);
         $respimg = $this->Zonas->Actualizar_Zona_Img($datosimg);
         if($resp){
            if($respimg){
               echo "ok";
            }else{
               log_message('ERROR','#TRAZA|Zona|Actualizar_Zona() >> $respimg: '.$respimg);
               echo "error";
               }
         
         }else{
            log_message('ERROR','#TRAZA|Zona|Actualizar_Zona() >> $resp: '.$resp);
            echo "error";
            }
         
      }
   
      /**
      * Tabla con listado de todos las Zonas
      * @param 
      * @return view Lista_zona
      */
       function Listar_Zona()
      {
         log_message('INFO','#TRAZA|Zona|Listar_Zona() >>');
         $data["zonas"] = $this->Zonas->Listar_Zonas();         
         $this->load->view('layout/Zonas/Lista_zona',$data);
         
      }

      /**
      * Tabla con listado de todos las Zonas para actualizar la anterior
      * @param 
      * @return view Lista_zona_tabla
      */
      function Listar_Zona_Tabla()
      {
         log_message('INFO','#TRAZA|Zona|Listar_Zona_Tabla() >>');
         $data["zonas"] = $this->Zonas->Listar_Zonas();       
         $this->load->view('layout/Zonas/Lista_zona_tabla',$data);
         
      }

      /**
      * Obtiene los departamentos para mostrarlos en el modal editar
      * @param 
      * @return json departamentos
      */
      function MostrarModalEditar(){
         log_message('INFO','#TRAZA|Zona|MostrarModalEditar() >>'); 
         $dato["dep"]= $this->Zonas->obtener_Departamentos();
         echo json_encode($dato);
       
      }

      /**
      * Obtiene la imagen de una zona en especifico
      * @param string id de la zona
      * @return json departamentos
      */
      function GetImagen(){
         log_message('INFO','#TRAZA|Zona|GetImagen() >>'); 
         $id = $this->input->post("zona_id");
         $dato= $this->Zonas->obtenerImagen_Zona_Id($id);  
         echo json_encode($dato);
      }

      /**
      * Elimina una zona en especifico
      * @param array datos de la zona
      * @return string "error, ok"
      */
      function Eliminar_Zona()
      {
         log_message('INFO','#TRAZA|Zona|Eliminar_Zona() >>'); 
         $resp = $this->Zonas->eliminar_Zona($this->input->post('datos'));
         if($resp){
            echo "ok";
            }else{
            log_message('ERROR','#TRAZA|Zona|Eliminar_Zona() >> $resp: '.$resp);
            echo "error";
            }
      }

      /**
      * Obtiene zonas por departamentos
      * @param string id del departamento
      * @return json zonas
      */
      function obtenerDeptoPorZona(){
         log_message('INFO','#TRAZA|Zona|obtenerDeptoPorZona() >>'); 
         $depa_id = $this->input->post('idDepto');
         $resp = $this->Zonas->Asignar_Zona($depa_id);
         echo json_encode($resp);
      }
       
   

}
?>