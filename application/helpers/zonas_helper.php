<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('zonas')){
    function zonas($json)
    {
        $array =  $json;
        // var_dump($array->menu);die;
        $html = '';
        foreach ($array->zonas->zona as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        }        
        return $html;
    }
}