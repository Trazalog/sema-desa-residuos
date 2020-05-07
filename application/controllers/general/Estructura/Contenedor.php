<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contenedor extends CI_Controller {

  function __construct()
      {
        parent::__construct();
        $this->load->model('general/Estructura/Contenedores');
  }
    
  // ---------------- Funciones  CONTENEDOR --------------------------------//

    // ---------------- Funcion Cargar vista Contenedores y Datos
    function templateContenedores()
    {
      $data['Estados'] = $this->Contenedores->obtener_Estados();
      $data['Habilitacion'] = $this->Contenedores->Obtener_Habilitacion();
      $data['Carga'] = $this->Contenedores->obtener_Tipo_Carga();
     
      // $data['Recipiente'] = $this->Contenedores->Obtener_recipiente();
      // $data[''] = $this->Contenedores->obtener_();
      // $data[''] = $this->Contenedores->obtener_();
      $this->load->view('layout/Contenedores/registrar_contenedor',$data); 
    }

   
    // _________________________________________________________

    // ---------------- Funcion Registrar Contenedor
    function Guardar_Contenedor()
    {
      
        // datos de la vista  
        $datos =  $this->input->post('datos');
        $datos_tipo_carga = $this->input->post('datos_tipo_carga');
         // 1 guarda contenedor y devuelve su id
        $cont_id = $this->Contenedores->Guardar_Contenedor($datos)->respuesta->cont_id;
        
        // Operacion de validacion circuito
        if ($cont_id == 0) {
          
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
        echo "tipo carga no asociado";return;
          }

         //------------------------------------------------------------- 
        
        echo 'ok';
        
      
    }
    // _________________________________________________________

    function Actualizar_Contenedor(){
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
        echo "tipo carga no asociado";return;
      } 
       if($respcont['status']){
         echo 'ok';
        } 
        else{echo 'error';}
      
    }
    // ---------------- Funcion Crear Contenedor
    function Crear_Contenedor()
    {

    }
    //___________________________________________________________

    // ---------------- Funcion Listar Contenedor
    function Listar_Contenedor()
    {
      $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
      $data["estados"] = $this->Contenedores->obtener_Estados();
      $data["carga"] = $this->Contenedores->obtener_Tipo_Carga();
      //agregue 03-05-20
      $data["habilitacion"] = $this->Contenedores->Obtener_Habilitacion();
      //agregue 03-05-20
      $this->load->view('layout/Contenedores/Lista_contenedores',$data);   
    }

    function Listar_Contenedor_Tabla(){
      $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
      $data["estados"] = $this->Contenedores->obtener_Estados();
      $data["carga"] = $this->Contenedores->obtener_Tipo_Carga();
      $data["habilitacion"] = $this->Contenedores->Obtener_Habilitacion();
      $this->load->view('layout/Contenedores/Lista_contenedores_Tabla',$data); 
    }
    //___________________________________________________________

    // ---------------- Funcion Modificar Generador
    function Modificar_Contenedor()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Borrar Contenedor
    function Borrar_Contenedor()
    {
      $resp = $this->Contenedores->eliminar_Contenedor($this->input->post('datos'));
      if($resp){
         echo "ok";
         }else{
         echo "error";
         }
    }
    // _________________________________________________________

    // ---------------- Funcion Suspender Contenedor
    function Suspender_Contenedor()
    {

    }
    // _________________________________________________________

    // ---------------- Funciones Obtener --------------------------------//

    // ---------------- Funcion Obtener tipo de residuo
    function Obtener_Residuo()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Obtener Transportista
    function Obtener_transportista()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Obtener Generador
    function Obtener_Generador()
    {

    }
    // _________________________________________________________

  // ---------------- Funciones SOLICITUD RETIRO DE CONTENEDOR --------------------------------//


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