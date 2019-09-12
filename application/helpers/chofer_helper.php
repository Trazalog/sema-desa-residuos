<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('chofer')){

    function chofer($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->chofer as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}