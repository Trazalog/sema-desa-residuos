<?php

require APPPATH . "/libraries/koolreport/core/autoload.php";
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\OnlyColumn;

//Define the class
class IncidenciaPorMunicipio extends \koolreport\KoolReport
{
    use \koolreport\codeigniter\Friendship;

    function cacheSettings()
    {
        return array(
            "ttl" => 60, //determina cuántos segundos será válido el caché
        );
    }

    protected function settings()
    {
        log_message('DEBUG', '#RECIDUOS| #INCIDENCIAPORMUNICIPIO.PHP|#INCIDENCIAPORMUNICIPIO|#SETTINGS| #INGRESO');
        $json = $this->params;

        foreach($json->incidencias as $data)
        {
            $a = '';
            return array(
                "dataSources" => array(
                    "apiarray" => array(
                        "class" => '\koolreport\datasources\ArrayDataSource',
                        "dataFormat" => "associate",
                        "data" => $data,
                    )
                )
            );
        }

    }

    protected function setup()
    {
        log_message('DEBUG', '#RECIDUOS| #INCIDENCIAPORMUNICIPIO.PHP|#INCIDENCIAPORMUNICIPIO|#SETUP| #INGRESO');

        $this->src("apiarray")

        ->pipe($this->dataStore("data_incidenciaPorMunicipio_table"));
    }
}