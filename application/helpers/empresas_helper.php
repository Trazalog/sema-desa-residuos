<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('empresas')){

    function empresas($json)
    {
        $array =  $json;
       // var_dump($array->menu);die;
        $html = '';
        foreach ($array->empresas->empresa as $i) {
            $html .= '<option class="emp" data-json=\''.json_encode($i).'\'>'.$i->nom->nom_emp.'</option>';
        }
        
        return $html;
    }
}