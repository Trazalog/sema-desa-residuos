<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('userId')){

    function userId()
		{
				return 502; //descarga
				//return 501; // bascula
				//return 401;// generador
				//return 402;// transportista           !HARDCODE
				$ci =& get_instance();
				//TODO: REVISAR LO QUE DEVUELVE LA VARIABLE DE SESION ES LA DE LOGIN AHORA
        $userdata  = $ci->session->userdata('user_data');
				return  $userdata[0]['userIdBpm'];
    }
}

if(!function_exists('userNick')){

    function userNick()
    {
				//return 'descarga';
				//return 'bascula';
				//return 'generador1';
				return 'transportista1';
				$ci =& get_instance();
				//TODO: REVISAR LO QUE DEVUELVE LA VARIABLE DE SESION ES LA DE LOGIN AHORA
        $userdata  = $ci->session->userdata('user_data');
				return  $userdata[0]['usrNick'];
    }
}

if(!function_exists('filtrarbyDepo')){

	function filtrarbyDepo($nombreTarea, $depo_id = null)
	{
		$ci =& get_instance();
    $userdata  = $ci->session->userdata();

		$mostrar = true;

		// si usuario es usuario de deposito
		if (($nombreTarea == "Certifica Vuelco")) {
				//$userId = userId();
				$user_depo_id = $userdata['depo_id'];

				//$depo_id = 19; //FIXME: DESHARDCODEAR

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