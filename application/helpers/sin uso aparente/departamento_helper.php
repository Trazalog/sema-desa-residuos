<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('Dpto')){
    function Dpto($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->Dpto->Dpto as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}