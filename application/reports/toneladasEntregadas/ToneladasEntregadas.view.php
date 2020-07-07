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
                        <h2 style="text-align:center">Reporte de toneladas entregadas por transportisa</h2>
                            <!-- <h3 class="box-title">
                                <i class="fa fa-list"></i>

                                Reportes
                            </h3>-->
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
                                foreach($report->params->transportistas->transportista as $clave => $valor)
                                {
                                    echo "<br><h3>Transportista:&nbsp;$valor->nombre:&nbsp;$valor->pesajeTotal Tn</h3><br>";
                                    if($valor != null)
                                    {
                                        foreach($valor->departamentos->departamento as $key => $depa)
                                        {
                                            if($depa != null)
                                            {
                                                echo "<a onclick=\"$('#$clave$key').toggle();\"  style='font-size:15px'><i class='fa fa-plus'></i> Municipalidad: $depa->nombre, $depa->pesaje Tn </a><br><br>";
                                                // $dato = $clave . $key;
                                                // echo "<a onclick='apertura($dato)'  style='font-size:15px'><i class='fa fa-plus'></i> Municipalidad: $depa->nombre, $depa->pesaje Tn </a><br><br>";
                                                echo "<div class='collapse' id='$clave$key'>";
                                                Table::create(array(
                                                    "dataStore" => $depa->residuos->residuo,
                                                    "headers" => array(
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
                                                        "table" => "table-striped table-scroll table-hover table-responsive dataTables_wrapper form-inline table-scroll table-responsive dt-bootstrap dataTable",
                                                        "th" => "sorting"
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

		$('filtro').load('<?php echo base_url() ?>index.php/Reportes/filtroIncidenciaPorZona');
		
		// function apertura(idTabla) {
		// 	$('#' + idTabla).toggle();	
		// 	// var tabla = $('#' + idTabla);
		// 	// console.table(tabla);
		// 	// DataTable(tabla);		
		// 	// tabla.DataTable();
		// 	console.log("asd");
		// 	DataTable($('.dataTable'));
		// 	// debug();
		// }
    </script>

<!-- convierte las tablas en dataTable para utilizar buscador y filtro -->
    <script>
    // DataTable($('.dataTable'))
    </script>

</body>