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
   
    
    
    
    

  // ---------------- Funciones SOLICITUD RETIRO DE CONTENEDOR desde aqui va en controlador Solicitud_Pedido --------------------------------//


    // ---------------- Funcion Cargar vista Solicitud retiroy Datos
    function templateSolicitudRetiro()
    {
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();
      $data['transportista'] = $this->Contenedores->obtener_Transportista();
      $data['nuevo_sore_id'] = $this->Contenedores->solicitudRetiroProx();
      //$data[''] = $this->Contenedores->obtener_();
      $this->load->view('layout/Contenedores/solicitud_retiro', $data);
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Solicitud de Retiro
    function Guardar_SolicitudRetiro()
    {
      $solicitud = $this->input->post('datos_contenedor');
      var_dump($solicitud);
      
      $usuario['usuario_app'] = 'hugoDS';

      $sore_id = $this->Contenedores->Guardar_SolicitudRetiro();
        
    }
    //___________________________________________________________

    // ---------------- Funcion Listar 
    function Listar_SolicitudesRetiro()
    {
      // $data["solicitudes_retiros"] = $this->Contenedores->Listar_Solicitudes_retiro();
      $this->load->view('layout/Contenedores/Lista_solicitudes_retiro',$data);
    }
    // _________________________________________________________

    function Listar_Residuos()
    {
      // $data["residuos"] = $this->Contenedores->Listar_Solicitudes_retiro();
      // $this->load->view('layout/Contenedores/Lista_solicitudes_retiro',$data); 
    }
    // _________________________________________________________
    // ---------------- Funciones Obtener --------------------------------//

      // ----- Funcion Obtener tipo residuo de contenedores entregados a generador
      function obtener_Tipo_residuo()
      {
        $response = $this->Contenedores->obtener_Tipo_residuo($this->input->post('tran_id'));
        echo json_encode($response);
      }
      // _________________________________________________________

      // ---------------- Funcion obtener contenedor
      function Obtener_contendor()
      {

      }

      // "/**",
			// 	"*Obtener_estados",
			// 	"* null ",
			// 	"* todos los estados",
			// "*/"
      // function Obtener_estados(){
      //   $data['Estados'] = $this->Contenedores->obtener_Estados();
      //   echo ($data);
      // }
      // _________________________________________________________

  // ---------------- Funciones SOLICITUD PEDIDO DE ORDEN CONTENEDOR --------------------------------//

    // ---------------- Funcion Cargar vista Solicitud retiro y Datos
    function templateSolicitudPedido()
    {
      //  $data[''] = $this->Contenedores->obtener_();
      //  $data[''] = $this->Contenedores->obtener_();
      //  $data['Empresas'] = $this->Contenedores->Obtener_empresas();
      //  $data['residuos'] = $this->Contenedores->Listar_Residuos();
      //  $data['contenedores'] = $this->Contenedores->obtener_();
      //  $data["residuos"] = $this->Contenedores->Listar_Residuos();

      $this->load->view('layout/Contenedores/solicitud_pedido'); 
    }

    // ---------------- Funcion Registrar Solicitud Pedido
    //  function Guardar_SolicitudPedido()
    //  {

    //  }

    // ---------------- Funcion Crear Solicitud Pedido
    //  function Crear_SolicitudPedido()
    //  {

    //  }

    // ---------------- Funcion Listar Solicitud Pedido
    function Listar_SolicitudesPedido()
    {
    // $data["solicitudes"] = $this->Contenedores->Listar_Solicitudes_pedido();
    $this->load->view('layout/Contenedores/Lista_solicitudes_pedidos');
    }
    // _________________________________________________________

    // ---------------- Funciones Obtener --------------------------------//

    // ---------------- Funcion Obtener tipo residuo
    // function Obtener_empresas()
    // {

    // }
    // _________________________________________________________

    // ---------------- Funcion obtener contenedor
    // function Obtener_contendor()
    // {

    // }
    // _________________________________________________________

    // ---------------- Funciones ENTREGA CONTENEDOR --------------------------------//

      // ---------------- Funcion Cargar vista Entrega contenedor y Datos
      function templateEntregacontenedor()
      {
        // $data[''] = $this->Contenedores->obtener_();
        // $data[''] = $this->Contenedores->obtener_();
        // $data['residuos'] = $this->Contenedores->Listar_Residuos();
        // $data['contenedores'] = $this->Contenedores->obtener_();

        //  $data["residuos"] = $this->Contenedores->Listar_Residuos();

        $this->load->view('layout/Contenedores/Entrega_contenedor');
      }

      // ---------------- Funcion Registrar Solicitud Pedido
      //  function Guardar_SolicitudPedido()
      //  {

      //  }

      // ---------------- Funcion Crear Solicitud Pedido
      //  function Crear_SolicitudPedido()
      //  {

      //  }

      // ---------------- Funcion Listar Solicitud Pedido
      function Listar_entregas()
      {
        $this->load->view('layout/Contenedores/Lista_entrega');
      }

      // ---------------- Funciones Obtener --------------------------------//

      // ---------------- Funcion Obtener tipo residuo

      // function Obtener_tipo_residuo()
      // {

      // }

      // ---------------- Funcion obtener contenedor

      //  function Obtener_contendor()
      //  {

      //  }

}
?>