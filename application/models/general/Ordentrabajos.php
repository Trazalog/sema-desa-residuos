<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordentrabajos extends CI_Model
{
	function __construct()
	{
		parent::__construct();
    }

    public function guardarInfos($datos){
        echo "ok";
        //$this->REST->callAPI("")
    }
    
    public function guardarTransps($datos){

        //echo implode(", ",$datos);
        echo "ok";
    }

    public function guardarResiduos($datos){

        //echo implode(", ",$datos);
        echo "ok";
    }
}
