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
        return 'hugoDS';
        //    return'descarga';
                //   return 'bascula';
            // return 'generador1';
                    //   return 'transportista1';
        $ci =& get_instance();
        $usernick  = $ci->session->userdata('usernick');
		return  $usernick;
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