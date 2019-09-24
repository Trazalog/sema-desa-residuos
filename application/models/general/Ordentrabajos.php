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
        $data = array('username'=>'dog','password'=>'tall');
        $aux = $this->rest->callAPI("POST","http://localhost:8080/tablatransportistas", $data);
        $aux =json_decode($aux["status"]);
        return $aux;
    }

    public function guardarResiduos($datos){

        //echo implode(", ",$datos);
        echo "ok";
    }
}
