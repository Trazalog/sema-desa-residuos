<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Representa a la Entidad Chofer
*
* @autor Ze Roberto Basañes
*/
class Camion extends CI_Controller 
{

    /**
    * Constructor de clase
    * @param 
    * @return 
    */
    function __construct()
    {
        parent::__construct();
        $this->load->model('general/Estructura/Camiones');
    }

    /**
    * Carga pantalla ABM choferes y listado
    * @param 
    * @return view choferes
    */
    function templateChoferes()
    {
        log_message('INFO','#TRAZA|CHOFER|templateChoferes() >>');
        $data['carnet'] = $this->Camiones->obtener_Carnet();
        $data['categoria'] = $this->Camiones->obtener_Categoria();
        $data['empresa'] = $this->Camiones->obtener_Empresa();
        $this->load->view('layout/Choferes/registrar_chofer',$data);
    }

    /**
    * Guarda chofer nuevo
    * @param array datos chofer
    * @return string "ok, error"
    */
    function Guardar_Chofer()
    {
        log_message('INFO','#TRAZA|CHOFER|Guardar_Chofer() >>');
        $datos =  $this->input->post('datos');
        $resp = $this->Camiones->Guardar_Chofer($datos);
        if($resp){
        echo "ok";
        }else{
        log_message('ERROR','#TRAZA|Camion|Guardar_Chofer() >> $resp: '.$resp);
        echo "error";
        }
    }

    /**
    * Tabla con listado de todos los Choferes
    * @param 
    * @return view Lista_choferes
    */
    function Listar_Chofer()
    {
        log_message('INFO','#TRAZA|CHOFER|Listar_Chofer() >>');
        $data["choferes"] = $this->Camiones->Listar_Chofer();
        $data['carnet'] = $this->Camiones->obtener_Carnet();
        $data['categoria'] = $this->Camiones->obtener_Categoria();
        $data['empresa'] = $this->Camiones->obtener_Empresa();
        $this->load->view('layout/Choferes/Lista_choferes',$data);
    }
    // _________________________________________________________

    /**
    * Actualiza datos choferes
    * @param array datos choferes
    * @return string "error, ok"
    */
    function Modificar_Chofer()
    {
        log_message('INFO','#TRAZA|CHOFER|Modificar_Chofer() >> ');
        $chofer = $this->input->post('chofer');
        $carnet = $chofer['carnet'];
        $categoria = $chofer['categoria'];
        $empresa = $chofer['empresa'];
        // actualiza datos chofer
        $response = $this->Camiones->Modificar_Chofer($chofer, $carnet, $categoria, $empresa); 
        
        if(!$response){
            log_message('ERROR','#TRAZA|CHOFER|Modificar_Chofer() >> $response: '.$response);
            echo "error_chofer";
            return;
          }else{          
            $response = $this->Camiones->Borrar_TiposCarga($chof_id);
            foreach ($tipo_carga as $i=>$tipo_carga) {              
                $data[$i]['chof_id'] = $chof_id;
                $data[$i]['tica_id'] = $tipo_carga;             
            }
            $resp = $this->Camiones->asociarTipoCarga($data);   
            if($resp){
              log_message('ERROR','#TRAZA|CHOFER|Modificar_Chofer() >> $resp: '.$resp);
              echo "ok";
            }else{
              echo "error";
            }          
          } 
    }

    /**
    * Borrado de Choferes
    * @param string id de chofer
    * @return json status servicio
    */
    function Borrar_Chofer()
    {
        log_message('INFO','#TRAZA|Camion|Borrar_Chofer() >>');
        // $chof_id = $this->input->post('chof_id');       
        // $response = $this->Camiones->Borrar_Chofer($chof_id);
        // echo json_encode($response);

        $resp = $this->Camiones->Borrar_Chofer($this->input->post('datos'));
        if($resp){
           echo "ok";
           }else{
           log_message('ERROR','#TRAZA|Camion|Borrar_Chofer() >> $resp: '.$resp);
           echo "error";
           }
    }
}
?>