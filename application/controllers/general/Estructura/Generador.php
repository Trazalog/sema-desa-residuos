<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Representa a la Entidad Generadores
*
* @autor Sledesma
*/
class Generador extends CI_Controller {

    /**
     * Constructor de Clase
    * @param 
    * @return 
    */  
    function __construct(){

      parent::__construct();

      $this->load->model('general/Estructura/Generadores');
   }


   /**
     *template obtiene los datos necesarios carga  la vista con ellos
    * @param 
    * @return view registrar_generadores
    */  
   
   function templateGeneradores()
   {
          log_message('INFO','#TRAZA|Generador|templateGeneradores() >>'); 
          $data['departamentos'] = $this->Generadores->obtener_Departamentos();
          $data['Tipogenerador'] = $this->Generadores->obtener_Tipo_Generador();
          $data['Zonagenerador'] = $this->Generadores->obtener_Zonas();
          $data['Tiporesiduo'] = $this->Generadores->obtener_Tipo_residuo();
          $data['Rubro'] = $this->Generadores->obtener_Rubro();           
          $this->load->view('layout/Generadores/registrar_generadores',$data);
   }

    /**
     *Guarda un generador nuevo dado de alta
    * @param 
    * @return string "ok","error"
    */  
    function Guardar_Generador()
    {
        log_message('INFO','#TRAZA|Generador|Guardar_Generador() >>'); 
        $datos =  $this->input->post('datos');
        $resp = $this->Generadores->Guardar_Generadores($datos);        
        if($resp){
        echo "ok";
        }else{
        log_message('ERROR','#TRAZA|Generador|Guardar_Generador() >> $resp: '.$resp); 
        echo "error";
        }
    }
    

    /**
    *Lista los diferentes generadores que existen en la db
    * @param 
    * @return view Lista_Generadores
    */  
   function Listar_Generador()
   {
        log_message('INFO','#TRAZA|Generador|Listar_Generador() >>'); 
        $data['generadores'] = $this->Generadores->Lista_generadores();
        $this->load->view('layout/Generadores/Lista_generadores',$data);
    }

    /**
    *Actualiza un generador en especifico 
    * @param 
    * @return string "ok","error"
    */  
   function Actualizar_Generador()
   {
        log_message('INFO','#TRAZA|Generador|Actualizar_Generador() >>'); 
        $datos =  $this->input->post('generador');
        $resp = $this->Generadores->actualizar_Generador($datos);
        if($resp == 1){
            echo "ok";
        }else{
        log_message('ERROR','#TRAZA|Generador|Actualizar_Generador() >> $resp: '.$resp);
        echo "error";
        }
   }

   
  
    /**
    *Elimina un Genereador en especifico
    * @param 
    * @return string "ok","error"
    */  
    function Eliminar_Generador()
    {
        log_message('INFO','#TRAZA|Generador|Eliminar_Generador() >>');
        $resp = $this->Generadores->Borrar_Generador($this->input->post('elimina'));
        if($resp == 1){
            echo "ok";
        }else{
            log_message('ERROR','#TRAZA|Generador|Elimina_Generador() >> $resp: '.$resp); 
            echo "error";
        }

   }

}
?>
