<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class testModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDepositos()
    {
        // $url = REST_PRD.'depositos_establecimiento/1';
        $rsp = $this->rest->callAPI("GET",REST_PRD."/depositos_establecimiento/1");
        return $rsp;
    }

    public function getRecipientes($depo_id)
    {
        $url = REST_PRD."/recipientes/establecimiento/1/deposito/$depo_id/estado/TODOS/tipo/TODOS/categoria/cate_recipienteBOX";
        return wso2($url);
    }

}