<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('empresas')){

    function empresas($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->empresas as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }
        
        return $html;
    }
}