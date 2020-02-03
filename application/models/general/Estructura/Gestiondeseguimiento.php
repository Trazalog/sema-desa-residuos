<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// HECHA POR SORETE PROGRAMER

class Gestiondeseguimiento extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

    // Funcion Listar Gestion (MODIFICAR)
    function Listar_Gestion()
    {
        $aux = $this->rest->callAPI("GET",REST."/RECURSO");
        $aux =json_decode($aux["data"]);
        return $aux->gestiondeseguimientos->gestiondeseguimiento;
    }
    // ----------------------------------------------------------------

    // Funcion Guardar Gestion
    function Guardar_Gestion($data)
    {
        $aux = $this->rest->callAPI("POST",REST."/RECURSO", $datos);
        $aux =json_decode($aux["status"]);
        return $aux;
    }
    // ----------------------------------------------------------------

  // ________________________________________________________________

  // ---------------------- FUNCIONES OBTENER ----------------------

  // Funcion Obtener Estado
  public function obtener_Estados()
  {
      $aux = $this->rest->callAPI("GET",REST."/estados");
      $aux =json_decode($aux["data"]);
      return $aux->estados->estado;
  }
  // ----------------------------------------------------------------

}
// ________________________________________________________________