<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Representa a la Entidad  OrdenMuniMasivas
*
* @autor SLedesma
*/
class OrdenMuniMasivas extends CI_Controller {
   /**
    * Constructor de Clase
    * @param 
    * @return 
    */
  function __construct()
      {
        parent::__construct();
        $this->load->model('general/Estructura/OrdenesMuniMasivas');
  }
    /**
    * Carga pantalla Contenedores y listado
    * @param 
    * @return view Contenedores
    */
    function templateOrdenMuniMasivas()
    {
      log_message('INFO','#TRAZA|OrdenMuniMasivas|templateOrdenMuniMasivas() >>'); 
      $data['Carga'] = $this->OrdenesMuniMasivas->obtener_Tipo_Carga();
      $data['Zona'] = $this->OrdenesMuniMasivas->obtener_Zona();
      //$data['Estado'] = $this->OrdenesMuniMasivas->obtener_Estado();
      $data['Circuito'] = $this->OrdenesMuniMasivas->obtener_Circuito();
      $this->load->view('layout/Ordenes/OMuniMasivas',$data); 
    }

     /**
      * Tabla con listado de todos los conteneodres
      * @param array datos
      * @return view Lista_contenedores
      */
      function Listar_OrdenesMuniMasivas()
      {
        log_message('INFO','#TRAZA|Contenedor|Listar_Contenedor() >>');
        // $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
        $this->load->view('layout/Ordenes/ListaOMuniMasivas');   
      }

}
?>