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
      $data['transportista'] = $this->Contenedores->obtener_Transportista();
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

    // ---------------- Funcion Crear Contenedor
    function Crear_Contenedor()
    {

    }
    //___________________________________________________________

    // ---------------- Funcion Listar Contenedor
    function Listar_Contenedor()
    {
      $data["contenedores"] = $this->Contenedores->Listar_Contenedor();
      $this->load->view('layout/Contenedores/Lista_contenedores',$data);   
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

    // ---------------- Funciones SOLICITUD RETIRO DE ORDEN CONTENEDOR --------------------------------//


    // ---------------- Funcion Cargar vista Solicitud retiroy Datos
    function templateSolicitudRetiro()
    {
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();
      // $data[''] = $this->->obtener_();

      $this->load->view('layout/Contenedores/solicitud_retiro');
    }
    // _________________________________________________________

    // ---------------- Funcion Registrar Orden Transporte
    function Guardar_SolicitudRetiro()
    {
        
    }
    //___________________________________________________________

    // ---------------- Funcion Crear Orden de transporte
    function Crear_SolicitudRetiro()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion Listar OrdenTransporte
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

    // ---------------- Funcion Obtener tipo residuo
    function Obtener_tipo_residuo()
    {

    }
    // _________________________________________________________

    // ---------------- Funcion obtener contenedor
    function Obtener_contendor()
    {

    }
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