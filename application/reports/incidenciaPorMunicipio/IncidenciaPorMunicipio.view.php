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

                        <div class="box-title"><br>
                            <h2 class="col-md-12" style="text-align:center">Reporte de incidencias por municipio</h2>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <!--_________________FILTRO_________________-->

                        <filtro></filtro>

                        <!--_________________TABLA_________________-->

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="box-body">
                            <div class="col-md-12">
                                <?php
                                foreach($report->params as $clave => $valor)
                                {
                                    echo "<a onclick=\"$('#".str_replace(" ","-",$valor->nombre)."').toggle();  $('th').click();\" style='font-size:15px;'><i class='fa fa-plus'></i> <p style='color: black; display:inline'>$valor->nombre, ".$valor->cantidadIncidencias." incidencias</p></a><br><br>";
                                    echo "<div class='collapse' id='".str_replace(" ","-",$valor->nombre)."'>";
                                    if($valor != null)
                                    {  
                                        Table::create(array(
                                            "dataStore" => $valor->incidencias->incidencia,
                                            "headers" => array(
                                            ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                                            "columns" => array(
                                                "inci_id" => array(
                                                    "label" => "Nro"
                                                ),
                                                "descripcion" => array(
                                                    "label" => "Descripción"
                                                ),
                                                "tipo_incidencia" => array(
                                                    "label" => "Tipo de incidencia"
                                                ),
                                                "fecha" => array(
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
                                                "table" => "table-striped table-scroll table-hover  table-responsive ",
                                                "th" => "sorting"
                                            )
                                        ));
                                    }
                                    echo '</div>';
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
        // convierte la tabla en data table para usar las funciones de ordenar por columna y buscar
        $('.table').dataTable();
    </script>
</body>