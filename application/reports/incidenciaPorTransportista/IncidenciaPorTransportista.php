<?php

require APPPATH . "/libraries/koolreport/core/autoload.php";

use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\OnlyColumn;

//Define the class
class IncidenciaPorTransportista extends \koolreport\KoolReport
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
        log_message('DEBUG', '#RECIDUOS| #INCIDENCIAPORTRANSPORTISTA.PHP|#INCIDENCIAPORTRANSPORTISTA|#SETTINGS| #INGRESO');
        $json = $this->params;

        foreach($json as $data)
        {
            $a = $data->incidencias->incidencia;
            return array(
                "dataSources" => array(
                    "apiarray" => array(
                        "class" => '\koolreport\datasources\ArrayDataSource',
                        "dataFormat" => "associate",
                        "data" => $a,
                    )
                )
            );
        }

    }

    protected function setup()
    {
        log_message('DEBUG', '#RECIDUOS| #INCIDENCIAPORTRANSPORTISTA.PHP|#INCIDENCIAPORTRANSPORTISTA|#SETUP| #INGRESO');

        $this->src("apiarray")

        ->pipe($this->dataStore("data_incidenciaPorTransportista_table"));

    }
}