<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('userId')){

    function userId()
    {
        return 402;//402 401
        //return 301;//!HARDCODE

        $ci =& get_instance();			
        $userdata  = $ci->session->userdata('user_data');
		return  $userdata[0]['userBpm'];
    }
}

if(!function_exists('userNick')){
    
    function userNick()
    {
        return 'transportista1'; //!HARDCODE transportista1 hugoDS generador1
        $ci =& get_instance();			
        $userdata  = $ci->session->userdata('user_data');
		return  $userdata[0]['usrNick'];
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
        if(empty($userdata)) redirect(base_url().'Login');
    }

}