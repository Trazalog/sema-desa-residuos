<?php defined('BASEPATH') OR exit('No direct script access allowed');

    /**
    * Representa a la Entidad Vehiculo
    *
    * @autor Ze Roberto Basañes
    */
    class Vehiculo extends CI_Controller 
    {

        /**
        * Constructor de clase
        * @param 
        * @return 
        */
        function __construct()
        {
            parent::__construct();
            $this->load->model('general/Estructura/Vehiculos');
        }

        /**
        * Carga pantalla ABM vehiculos y listado
        * @param 
        * @return view vehiculos
        */
        function templateVehiculos()
        {
            log_message('INFO','#TRAZA|VEHICULO|templateVehiculos() >>');
            // $data[''] = $this->Infracciones->obtener_();
            // $data[''] = $this->Infracciones->obtener_();
            // $data[''] = $this->Infracciones->obtener_();
            // $data[''] = $this->Infracciones->obtener_();

            $this->load->view('layout/Vehiculos/registrar_vehiculo', $data);
        }

        /**
        * Guarda vehiculo nuevo
        * @param array datos vehiculo
        * @return string "ok, error"
        */
        function Guardar_Vehiculo()
        {
            log_message('INFO','#TRAZA|VEHICULO|Guardar_Vehiculo() >>');
            $datos =  $this->input->post('datos');
            $resp = $this->Vehiculos->Guardar_Vehiculo($datos);
            if($resp){
            echo "ok";
            }else{
            echo "error";
            }
        }

        /**
        * Tabla con listado de todos los Vehiculos
        * @param 
        * @return view lista_vehiculos
        */
        function Listar_Vehiculo()
        {
            $data["vehiculos"] = $this->Vehiculos->Listar_Vehiculo();
            $this->load->view('layout/Vehiculos/lista_vehiculos',$data);
        }

    }
?>