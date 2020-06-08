<table id="tabla_incidencia" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Descripcion</th>
        <th>fecha</th>
        <th>tipo de incidencia</th>
        <th>numero de acta</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
        <?php
        if($incidencia)
        {
            foreach($incidencia as $fila)
            {
            echo "<tr data-json='".json_encode($fila)."'>";
            echo    '<td>';
            echo     '<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                      <button type="button" title="anular" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalaviso"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button>&nbsp';
                
            echo   '</td>';
            echo    '<td>'.$fila->descripcion.'</td>';   
            echo    '<td>'.$fila->fecha.'</td>';
            echo    '<td>'.$fila->tipo_incidencia.'</td>';                       
            echo    '<td>'.$fila->num_acta.'</td>';                        
            echo   '</tr>';
          }
        }
        ?>
        </tbody>
      
    </table>
<script>
$(".btnInfo").click(function(e){
  var data = JSON.parse($(this).parents("tr").attr("data-json")); 
  console.table(data);
  $("#inci_descripcion").val(data.descripcion); 
  $("#inci_numacta").val(data.num_acta); 
  $("#inci_incidencia").val(data.tipo_incidencia); 
  $("#inci_residuos").val(data.tipo_carga); 
  $("#inci_disposicion").val(data.disposicion_final); 
  $("#inci_fecha").val(data.fecha);  
});
$(".btnEliminar").click(function(e){
  var data = JSON.parse($(this).parents("tr").attr("data-json")); 
  console.table(data);
  $("#id_incidencia").val(data.inci_id); 
  
});

</script>
<script>
    DataTable($('#tabla_incidencia'));
</script>