<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('condicion')){
    function condicion($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->condicion->condicion as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        return $html;
    }
}