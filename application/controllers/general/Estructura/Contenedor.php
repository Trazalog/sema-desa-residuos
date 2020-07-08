<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa a la Entidad  Contenedores
*
* @autor SLedesma
*/
class Contenedor extends CI_Controller {
   /**
    * Constructor de Clase
    * @param 
    * @return 
    */
  function __construct()
      {
        parent::__construct();
        $this->load->model('general/Estructura/Contenedores');
  }
    /**
    * Carga pantalla Contenedores y listado
    * @param 
    * @return view Contenedores
    */
    function templateContenedores()
    {
      log_message('INFO','#TRAZA|Contenedor|templateContenedores() >>'); 
      $data['Estados'] = $this->Contenedores->obtener_Estados();
      $data['Habilitacion'] = $this->Contenedores->Obtener_Habilitacion();
      $data['Carga'] = $this->Contenedores->obtener_Tipo_Carga();
      $data['transportista'] = $this->Contenedores->obtener_transportista();
      $this->load->view('layout/Contenedores/registrar_contenedor',$data); 
    }
     /**
      * Guarda contenedor nuevo
      * @param array datos contenedor
      * @return string "ok, contenedor no registrado, tipo de carga no asociado"
      */
    function Guardar_Contenedor()
    {
        log_message('INFO','#TRAZA|Contenedor|Guardar_Contenedor() >>'); 
        // datos de la vista  
        $datos =  $this->input->post('datos');
        $datos_tipo_carga = $this->input->post('datos_tipo_carga');
         // 1 guarda contenedor y devuelve su id
        $cont_id = $this->Contenedores->Guardar_Contenedor($datos)->respuesta->cont_id;
        // Operacion de validacion circuito
        if ($cont_id == 0) {
          log_message('ERROR','#TRAZA|Contenedor|Guardar_Contenedor() >> $cont_id: '.$cont_id);
          echo "contenedor no registrado"; return;
            } 
        // 3  con id circ  agregar a array tipo de carga armar batch  /_post_circuitos_tipocarga_batch_req  
        foreach ($datos_tipo_carga as $key => $carga) {
        $tipocarga[$key]['cont_id'] = $cont_id;
        $tipocarga[$key]['tica_id'] = $carga;
        }
        $resp = $this->Contenedores->Guardar_tipo_carga($tipocarga);
        // Operacion de validacion tipo carga
        if (!$resp['status']) {
        log_message('ERROR','#TRAZA|Contenedor|Guardar_Contenedor() >> $resp: '.$resp);
        echo "tipo carga no asociado";return;
          }
        echo 'ok';
    }
     /**
      * Actualiza datos de Contenedor
      * @param array datos contenedor y datos tipo carga 
      * @return string "error, ok, tipo de carga no asociado"
      */
    function Actualizar_Contenedor(){
      log_message('INFO','#TRAZA|Contenedor|Actualizar_Contenedor() >>'); 
      $datos =  $this->input->post('datos');
      $deletetipo = $this->input->post('deletetipo');
      $carga_tipo = $this->input->post('datos_tipo_carga');
      $cont_id = $this->input->post('cont_id');
      $respcont = $this->Contenedores->actualizar_Contenedor($datos);
      $respdelete =  $this->Contenedores->borrar_tipo_Carga($deletetipo);
      foreach ($carga_tipo as $key => $carga) {
        $tipocarga[$key]['cont_id'] = $cont_id;
        $tipocarga[$key]['tica_id'] = $carga;
        }
      $resptipo = $this->Contenedores->Guardar_tipo_carga($tipocarga);
      if (!$resptipo['status']) {
        log_message('ERROR','#TRAZA|Contenedor|Actualizar_Contenedor() >> $resptipo: '.$resptipo);
        echo "tipo carga no asociado";return;
      } 
       if($respcont['status']){
         echo 'ok';
        } 
        else{
          log_message('ERROR','#TRAZA|Contenedor|Actualizar_Contenedor() >> $respcont: '.$respcont);
          echo 'error';}
    }
    /**
      * Tabla con listado de todos los conteneodres
      * @param array datos
      * @return view Lista_contenedores
      */
    function Listar_Contenedor()
    {
      log_message('INFO','#TRAZA|Contenedor|Listar_Contenedor() >>');
      $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
      $data["estados"] = $this->Contenedores->obtener_Estados();
      $data["carga"] = $this->Contenedores->obtener_Tipo_Carga();
      $data["habilitacion"] = $this->Contenedores->Obtener_Habilitacion();
      $this->load->view('layout/Contenedores/Lista_contenedores',$data);   
    }
      /**
      * Tabla con listado de todos los contenedores para actualizar la anterior
      * @param 
      * @return view Lista_contenedores_Tabla
      */
    function Listar_Contenedor_Tabla(){
      log_message('INFO','#TRAZA|Contenedor|Listar_Contenedor_Tabla() >>');
      $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
      $data["estados"] = $this->Contenedores->obtener_Estados();
      $data["carga"] = $this->Contenedores->obtener_Tipo_Carga();
      $data["habilitacion"] = $this->Contenedores->Obtener_Habilitacion();
      $this->load->view('layout/Contenedores/Lista_contenedores_Tabla',$data); 
    }
     /**
      * Elimina contenedor
      * @param array datos del contenedor
      * @return string "error, ok"
      */
    function Borrar_Contenedor()
    {
      log_message('INFO','#TRAZA|Contenedor|Borrar_Contenedor() >>');
      $resp = $this->Contenedores->eliminar_Contenedor($this->input->post('datos'));
      if($resp){
         echo "ok";
         }else{
         log_message('ERROR','#TRAZA|Contenedor|Borrar_Contenedor() >> $resp: '.$resp); 
         echo "error";
         }
    }

    function GetImagen(){
         log_message('INFO','#TRAZA|Contenedores|GetImagen() >>'); 
         $id = $this->input->post("cont_id");
         $dato= $this->Contenedores->obtenerImagen_Cont_Id($id);  
         echo json_encode($dato);
    }
}
?>