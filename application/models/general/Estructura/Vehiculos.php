<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Representa a la Entidad Vehiculos
*
* @autor Ze Roberto Basañes
*/
class Vehiculos extends CI_Model
    {
        /**
        * Constructor de Clase
        * @param 
        * @return 
        */
        function __construct()
        {
            parent::__construct();
        }

            /**
            * Trae listado de Todos los Vehiculos
            * @param 
            * @return 
            */
            function Listar_Vehiculo()
            {
                $aux = $this->rest->callAPI("GET",REST."/vehiculos");
                $aux =json_decode($aux["data"]);
                return $aux->vehiculos->vehiculo;
            }

        // Funcion Guardar Vehiculo
            function Guardar_Vehiculo($data)
            {
                $post["post_vehiculo"] = $data;
                log_message('DEBUG','#Vehiculos/Guardar_Vehiculo:'.json_encode($post));
                $aux = $this->rest->callAPI("POST",REST."/vehiculos", $post);
                $aux =json_decode($aux["status"]);
                return $aux;
            }
        //________________________________________________________

        // ---------------------- FUNCIONES OBTENER ----------------------

        // Funcion Obtener condicion vehiculo
        public function obtener_Condicion()
        {
            $aux = $this->rest->callAPI("GET",REST."/transportistas");
            $aux =json_decode($aux["data"]);
            return $aux->condiciones->condicion;
        }
    }
?>