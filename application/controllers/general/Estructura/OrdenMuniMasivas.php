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
      // $data['Carga'] = $this->OrdenesMuniMasivas->obtener_Tipo_Carga();
      // $data['Zona'] = $this->OrdenesMuniMasivas->obtener_Zona();
      // //$data['Estado'] = $this->OrdenesMuniMasivas->obtener_Estado();
      // $data['Circuito'] = $this->OrdenesMuniMasivas->obtener_Circuito();
      $this->load->view('layout/Ordenes/OMuniMasivas'); 
    }

     /**
      * Tabla con listado de todos los conteneodres
      * @param array datos
      * @return view Lista_contenedores
      */
      function Listar_OrdenesMuniMasivas()
      {
        log_message('INFO','#TRAZA|Contenedor|Listar_Contenedor() >>');
        $data["templates"] = $this->OrdenesMuniMasivas->Listar_OT();
        $data['fecha'] = date('Y-m-d');
        $this->load->view('layout/Ordenes/ListaOMuniMasivas',$data);   
      }
      function EjecutarOTs()
      {
        $data = $this->input->post('data');
        $aux = 0;
        foreach ($data["datos"] as $valor)
        {
          $masivas["difi_id"] = $valor["difi_id"];
          $masivas["sotr_id"] = $valor["sotr_id"];
          $masivas["equi_id"] = $valor["equi_id"];
          $masivas["chof_id"] = $valor["chof_id"];
          $masivas["usuario_app"] = "hugoDS";
          $masivas["teot_id"] = $valor["teot_id"];
          $cont["cont_id"] = $valor["cont_id"];
          $masivas["contenedores"] = $cont;
          $masivas["fec_retiro"] =  date('d-m-Y');
          $resp = $this->OrdenesMuniMasivas->Ejecutar_OT($masivas);
          $aux =$aux + $resp;
        }
        if($aux != 0)
        {echo "ok";}
        else
        {echo "error";}
        // log_message('INFO','#TRAZA|Contenedor|Listar_Contenedor() >>');
        // $resp = $this->OrdenesMuniMasivas->Ejecutar_OT($data);
      }
      // function ListartemplateporFiltros()
      // {
      //   log_message('INFO','#TRAZA|Contenedor|Borrar_Contenedor() >>');
      //   $data['templates'] = $this->OrdenesMuniMasivas->Templatefiltradas($this->input->post('datos'));
      //   //$this->load->view('layout/Ordenes/ListaOMuniMasivas'); 
      // }

}
?>