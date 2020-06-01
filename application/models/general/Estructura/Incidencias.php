<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Representa a la Entidad Incidencias
*
* @autor SLedesma
*/
class Incidencias extends CI_Model
{       /**
    * Constructor de Clase
    * @param 
    * @return 
    */
    function __construct()
    {
        parent::__construct();
    }

    public function guardarDatos($datos)
    {
      $aux = $this->rest->callAPI("POST","http://localhost:3000/tablaprocesoproductivo", $datos);
      $aux =json_decode($aux["status"]);
      return $aux;
    }

}