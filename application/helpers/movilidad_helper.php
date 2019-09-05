<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('movilidad')){

    function movilidad($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->movilidad as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}