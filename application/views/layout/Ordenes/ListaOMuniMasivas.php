<div id="lista_cont">
<div id="tabla">
<table id="tabla_contenedores" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">
        <th><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></th>
        <th>Acciones</th>
        <th>Codigo / Registro</th>
        <th>Estado</th>
        <th>Capacidad</th>
        <th>Habilitacion</th>


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
        <?php
                    // if($contenedores)
                    // {
                        // foreach($contenedores as $fila)
                        // {
                            // echo "<tr data-json='".json_encode($fila)."' data-carga='".json_encode($carga)."'>";
                            echo    '<td>';
                            echo    '<input type="checkbox">&nbsp';
                            echo    '</td>';
                            echo    '<td>';
                            echo    '<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp';
                                
                            // echo   '</td>';
                            // echo    '<td>'.$fila->codigo.'</td>';
                            // echo    '<td>'.substr("$fila->esco_id",17).'</td>'; //funcion substr("cadena de caracteres,n° posición del carácter desde la cual se comenzará la extracción") 17 por que hay que obviar estado_contenedor (0-16)
                            // echo    '<td>'.$fila->capacidad.'</td>';
                            // echo    '<td>'.$fila->habilitacion.'</td>';
                            // echo '</tr>';


                            //----------datos de prueba------------
                            echo   '</td>';
                            echo    '<td>DATO</td>';
                            echo    '<td>DATO</td>'; 
                            echo    '<td>DATO</td>';
                            echo    '<td>DATO</td>';
                            echo '</tr>';
                    // }
                    // }
                    ?>


    </tbody>
</table>
 </div>
</div>


<!--__________________FIN TABLA___________________________-->

<script>
$('.select3').select2();
DataTable($('#tabla_contenedores'))
</script>
<script>
    //DataTable($('#tabla_zonas'));
  $('#tabla_contenedores').DataTable({
  "aLengthMenu": [ 10, 25, 50, 100 ],
  "order": [[0, "asc"]],
    "paging": false,
    "searching": false,
    "retrieve": true,
});

</script>