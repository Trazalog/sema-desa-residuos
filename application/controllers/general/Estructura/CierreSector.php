<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Representa a la Entidad CierreSector
* @autor Sledesma
*/
class CierreSector extends CI_Controller {

	/**
	 * Constructor de Clase
	* @param 
	* @return 
	*/
	function __construct(){

		parent::__construct();

		$this->load->model('general/Estructura/CierreSectores');
	}


	/**
	 *template obtiene los datos necesarios carga  la vista con ellos
	* @param 
	* @return view cierre_sector
    */  
    function templateCierreSector()
    {
                log_message('INFO','#TRAZA|CierreSector|templateCierreSector() >>'); 
                $ci =& get_instance();
                $userdata  = $ci->session->userdata();
                $user_depo_id = $userdata['depo_id'];
				// $data['Recipientes'] = $this->CierreSectores->Lista_Sector();  // llamaria a ListaSector el cual trae todos los recipientes que posee ese sector para mostrar         
                $data->TamDeposito = $this->CierreSectores->obtenerTamañoDeposito($user_depo_id); // aca iria el depo_id del usuario loguado 
                $data->Recipientes = $this->CierreSectores->obtenerRecipientes($user_depo_id);
                $data->sector = $userdata['last_name'];
                $this->load->view('layout/cierre_sector',$data);
    }

}

?>