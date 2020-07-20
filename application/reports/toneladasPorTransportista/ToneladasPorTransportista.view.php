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
                        <h2 class="col-md-12" style="text-align:center">Reporte de toneladas entregadas por transportisa</h2>
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
                            foreach($report->params->transportistas->transportista as $clave => $valor)
                            {
                                echo "<br><h4><strong>Transportista:&nbsp;$valor->nombre:&nbsp;$valor->pesajeTotal Tn</strong></h4><br>";
                                if($valor != null)
                                {
                                    foreach($valor->departamentos->departamento as $key => $depa)
                                    {
                                        if($depa != null)
                                        {
                                            echo "<a class='prueba' onclick=\"$('#$clave$key').toggle();  $('th').click();\"  style='font-size:17px'><i class='fa fa-minus'></i> <p style='color:black; display:inline'>Municipalidad: $depa->nombre, $depa->pesaje Tn</p></a><br><br>";
                                            echo "<div id='$clave$key'>";
                                            Table::create(array(
                                                "dataStore" => $depa->residuos->residuo,
                                                "headers" => array(
                                                    array(
                                                    )
                                                ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                                                "columns" => array(
                                                    "tipo_carga" => array(
                                                        "label" => "Tipo de residuo"
                                                    ),
                                                    "fecha" => array(
                                                        "label" => "Fecha"
                                                    ),
                                                    "toneladas" => array(
                                                        "label" => "Toneladas"
                                                    )
                                                ),
                                                "cssClass" => array(
                                                    "table" => "table-striped table-scroll table-hover table-responsive"
                                                )
                                            ));
                                            echo '</div>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                        <!--_________________FIN TABLA_________________-->
                        <div class="col-md-12">
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
	$('filtro').load('<?php echo base_url() ?>index.php/Reportes/filtroToneladasPorTransportista');
    // convierte la tabla en data table para usar las funciones de ordenar por columna y buscar
    $('.table').dataTable();

    $('.prueba').click(function() {
        var ban = $(this).find('i').hasClass('fa-plus');
        $(this).find('i').remove();
        if (ban) $(this).prepend('<i class="fa fa-minus"></i>');
        else $(this).prepend('<i class="fa fa-plus"></i>');
    });
    </script>
</body>