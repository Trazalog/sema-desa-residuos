<?php

use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
use \koolreport\widgets\koolphp\Card;

?>





<body>

    <!--_________________BODY REPORTE___________________________-->

    <div id="reportContent" class="report-content">
        <div class="row">

            <div class="col-md-12">


                <div class="box box-solid">

                    <div class="box box-primary">

                        <div class="box-header">
                            <h3 class="box-title">
                                <i class="fa fa-list"></i>

                                Reportes
                            </h3>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <!--_________________FILTRO_________________-->

                        <filtro></filtro>

                        <!--_________________TABLA_________________-->

                        <div class="box-body">
                            <div class="col-md-12">
                                <?php
                                foreach($report->params->incidencias as $clave => $valor)
                                {
                                    if($valor != null)
                                    {
                                        Table::create(array(
                                            "dataStore" => $valor,
                                            "headers" => array(
                                                array(
                                                    "".$clave => array("colSpan" => 6),
                                                    // "Other Information" => array("colSpan" => 2),
                                                )
                                            ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                                            "columns" => array(
                                                "inci_id" => array(
                                                    "label" => "Nro"
                                                ),
                                                "descripcion" => array(
                                                    "label" => "Descripción"
                                                ),
                                                "tipoDeIncidencia" => array(
                                                    "label" => "Tipo de incidencia"
                                                ),
                                                "fechaHora" => array(
                                                    "label" => "Fecha y hora"
                                                ),
                                                "inspector" => array(
                                                    "label" => "Inspector"
                                                ),
                                                "transportista" => array(
                                                    "label" => "Transportista"
                                                ),
                                                "generador" => array(
                                                    "label" => "Generador"
                                                )
                                            ),
                                            "cssClass" => array(
                                                "table" => "table-striped table-scroll table-hover  table-responsive dataTables_wrapper form-inline table-scroll table-responsive dt-bootstrap dataTable",
                                                "th" => "sorting"
                                            )
                                        ));
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!--_________________FIN TABLA_________________-->


                        <div class="col-md-12">
                            <br>
                            <div class="box box-primary">
                            </div>
                        </div>

                        <!--_________________ FIN BODY REPORTE ____________________________-->

                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>

        $('tr > td').each(function() {
            if ($(this).text() == 0) {
                $(this).text('-');
                $(this).css('text-align', 'center');
            }
        });

        $('filtro').load('<?php echo base_url() ?>index.php/Reportes/filtroIncidenciaPorMunicipio');
    </script>

    <script>
        DataTable($('.dataTable'))
    </script>

</body>