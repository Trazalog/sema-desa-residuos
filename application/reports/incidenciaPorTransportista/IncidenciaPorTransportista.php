<?php

require APPPATH . "/libraries/koolreport/core/autoload.php";

//Specify some data processes that will be used to process
// use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
// use \koolreport\processes\RemoveColumn;
use \koolreport\processes\OnlyColumn;

//Define the class
class IncidenciaPorTransportista extends \koolreport\KoolReport
{
    // use \koolreport\clients\Bootstrap;
    use \koolreport\codeigniter\Friendship;
    /*Filtros Avanzados*/
    /*Enlace de datos entre los parámetros del informe y los Controles de entrada */
    // use \koolreport\inputs\Bindable;
    // use \koolreport\inputs\POSTBinding;

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

        // foreach($json->incidencias as $data)
        // {
        //     $data = json_encode($json);
        //     $a = '';
        //     return array(
        //         "dataSources" => array(
        //             "apiarray" => array(
        //                 "class" => '\koolreport\datasources\ArrayDataSource',
        //                 "dataFormat" => "associate",
        //                 "data" => json_decode($data, true),
        //             )
        //         )
        //     );
        // }

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

        // $data = json_encode($json);

        // return array(
        //     "dataSources" => array(
        //         "apiarray" => array(
        //             "class" => '\koolreport\datasources\ArrayDataSource',
        //             "dataFormat" => "associate",
        //             "data" => json_decode($data, true),
        //         )
        //     )
        // );

        // $data2 = json_encode("123");
        // return array(
        //     "dataSources" => array(
        //         "apiarray2" => array(
        //             "class" => '\koolreport\datasources\ArrayDataSource',
        //             "dataFormat" => "associate",
        //             "data" => json_decode($data2, true),
        //         )
        //     )
        // );
    }

    protected function setup()
    {
        log_message('DEBUG', '#RECIDUOS| #INCIDENCIAPORTRANSPORTISTA.PHP|#INCIDENCIAPORTRANSPORTISTA|#SETUP| #INGRESO');

        $this->src("apiarray")

        ->pipe($this->dataStore("data_incidenciaPorTransportista_table"));
        
        // ->pipeTree($this->dataStore("data_incidenciaPorTransportista_table"));
    }
}