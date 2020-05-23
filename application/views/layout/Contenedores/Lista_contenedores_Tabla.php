<table id="tabla_contenedores" class="table table-bordered table-striped">
  <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>Codigo / Registro</th>
    <th>Estado</th>
    <th>Capacidad</th>
    <th>Habilitacion</th>


  </thead>

  <!--__________________BODY TABLA___________________________-->

  <tbody>
    <?php
                    if($contenedores)
                    {
                        foreach($contenedores as $fila)
                        {
                            echo "<tr data-json='".json_encode($fila)."' data-carga='".json_encode($carga)."'>";
                            echo    '<td>';
                            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                                
                            echo   '</td>';
                            echo    '<td>'.$fila->codigo.'</td>';
                            echo    '<td>'.substr("$fila->esco_id",17).'</td>'; //funcion substr("cadena de caracteres,n° posición del carácter desde la cual se comenzará la extracción") 17 por que hay que obviar estado_contenedor (0-16)
                            echo    '<td>'.$fila->capacidad.'</td>';
                            echo    '<td>'.$fila->habilitacion.'</td>';
                            echo '</tr>';
                    }
                    }
                    ?>


  </tbody>
</table>

<script>
$(".btnEliminar").click(function(e) {
  var data = JSON.parse($(this).parents("tr").attr("data-json"));
  $('#btndelete').show();
  $("#id_contenedor").val(data.cont_id);
});
//--------------------------------------------------------------------
$(".btnInfo").click(function(e) {
  var data = JSON.parse($(this).parents("tr").attr("data-json"));
  var datacarga = JSON.parse($(this).parents("tr").attr("data-carga"));
  $(".habilitar").attr("readonly", "readonly");
  $(".selectores").attr("style", "display:none");
  $(".ocultarInfo").removeAttr("style");
  $('#btnsave').hide();
  $("#Codigo").val(data.codigo);
  $("#Descripcion").val(data.descripcion);
  $("#Capacidad").val(data.capacidad);
  $("#Añoelab").val(data.anio_elaboracion);
  $("#Tara").val(data.tara);
  $("#estadoInfo").val(data.esco_id.substr(17, 30));
  $("#cargaInfo").val();
  $("#habilitacionInfo").val(data.habilitacion);
  $(".titulo").text('Informacion Contenedor');
  $("#estadoInfo").attr("readonly", "readonly");
  $("#habilitacionInfo").attr("readonly", "readonly");

  $("#tic_id").find('option').remove();


  var tipo = data.tipos_carga.tipoCarga;
  var aux = 0;

  for (var i = 0; i <= datacarga.length - 1; i++) {
    aux = 0;
    for (var j = 0; j <= tipo.length - 1; j++) {
      if (datacarga[i].valor == tipo[j].rsu) {
        $("#tic_id").append("<option selected value= '" + datacarga[i].tabl_id + "'> " + datacarga[i].valor +
          "</option>");
        aux = 1;
        j = tipo.length + 1;
      }
    }
    if (aux == 0) {
      $("#tic_id").append("<option value= '" + datacarga[i].tabl_id + "' >" + datacarga[i].valor + "</option>");
    }

  }

});


//-------------------------------------------------------------------------
$(".btnEditar").click(function(e) {
  var data = JSON.parse($(this).parents("tr").attr("data-json"));
  var datacarga = JSON.parse($(this).parents("tr").attr("data-carga"));
  //para seguimiento despues borrar
  console.table(data);
  console.table(data.tipos_carga.tipoCarga);
  console.table(datacarga[0].valor);
  $(".habilitar").removeAttr("readonly");
  $(".selectores").removeAttr("style");
  $(".ocultarInfo").attr("style", "display:none");
  $(".titulo").text('Editar Contenedor');
  $('#btnsave').show();
  //--------------------------------------
  $("#Codigo").val(data.codigo);
  $("#Descripcion").val(data.descripcion);
  $("#Capacidad").val(data.capacidad);
  $("#Añoelab").val(data.anio_elaboracion);
  $("#Tara").val(data.tara);
  $("#cont_id").val(data.cont_id);
  $("#Estados")[0][0].selected = "false";
  $("#Estados")[0][0].text = data.esco_id.substr(17, 30);
  $("#Estados")[0][0].value = data.esco_id;
  $("#Habilitacion")[0][0].selected = "false";
  $("#Habilitacion")[0][0].text = data.habilitacion;
  $("#Habilitacion")[0][0].value = data.habil_id;


  $("#tic_id").find('option').remove();
  var tipo = data.tipos_carga.tipoCarga;
  var aux = 0;

  for (var i = 0; i <= datacarga.length - 1; i++) {
    aux = 0;
    for (var j = 0; j <= tipo.length - 1; j++) {
      if (datacarga[i].valor == tipo[j].rsu) {
        $("#tic_id").append("<option selected value= '" + datacarga[i].tabl_id + "'> " + datacarga[i].valor +
          "</option>");
        aux = 1;
        j = tipo.length + 1;
      }
    }
    if (aux == 0) {
      $("#tic_id").append("<option value= '" + datacarga[i].tabl_id + "' >" + datacarga[i].valor + "</option>");
    }

  }

});
</script>
<script>
//DataTable($('#tabla_zonas'));
$('#tabla_contenedores').DataTable({
  "aLengthMenu": [10, 25, 50, 100],
  "order": [
    [0, "asc"]
  ],
});
</script>