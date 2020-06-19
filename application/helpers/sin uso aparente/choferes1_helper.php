<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('choferes')){
    function choferes($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->choferes->chofer as $i) {
            $html .= '<option>'.$i->nombre.'</option>';
        } 
        return $html;
    }
}