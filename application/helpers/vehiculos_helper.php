<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('vehiculos')){

    function vehiculos($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->vehiculos->vehiculos as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}