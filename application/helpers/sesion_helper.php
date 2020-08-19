<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('userId')){

    function userId()
    {
                // return 502; //descarga
                        //return 501; // bascula
        //  return 401;// generador
                //   return 402;// transportista           !HARDCODE

        $ci =& get_instance();			
        $userid  = $ci->session->userdata('id');
		return  $userid;
    }
}

if(!function_exists('userNick')){

    function userNick()
    {
        //    return'descarga';
                //   return 'bascula';
            // return 'generador1';
                      //return 'transportista1';
        $ci =& get_instance();
        $usernick  = $ci->session->userdata('usernick');
		return  $usernick;
    }
}

/**
* Devuelve coincidencia de deposito con usuario de deposito
* @param
* @return bool true o false
*/
if(!function_exists('filtrarbyDepo')){

	function filtrarbyDepo($nombreTarea, $depo_id = null)
	{
		$ci =& get_instance();
    $userdata  = $ci->session->userdata();

		$mostrar = true;

		// si usuario es usuario de deposito
		if (($nombreTarea == "Certifica Vuelco")) {

				$user_depo_id = $userdata['depo_id'];
				//no coincide usuario deposito con deposito asignado
				if (!($user_depo_id == $depo_id)) {
					$mostrar = false;
				}
		}

		return $mostrar;
	}
}

if(!function_exists('userPass')){

    function userPass()
    {
        return BPM_USER_PASS;
    }
}

if(!function_exists('empresa')){

    function empresa(){
        return 1; //!HARDCODE
        $ci =& get_instance();
        $userdata  = $ci->session->userdata('user_data');
		return  empresa();
    }
}

if(!function_exists('validarSesion')){

    function validarSesion(){
        $ci = &get_instance();
        $userdata = $ci->session->userdata('user_data');
        if(empty($userdata['email'])) redirect(base_url().'login/main/logout/'); 
    }

}