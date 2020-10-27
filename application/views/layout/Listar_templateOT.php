<table id="tabla_vehiculos" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Circuito</th>
        <th>Transportista</th>
        <th>Movilidad</th>
        <th>Chofer</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
        <?php
        if($templateot)
        {
            foreach($templateot as $fila)
            {
            echo "<tr data-json='".json_encode($fila)."'>";
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                
            echo   '</td>';  
            echo    '<td>'.$fila->circuito.'</td>';
            echo    '<td>'.$fila->transportista.'</td>';                       
            echo    '<td>'.$fila->equipo.'</td>';  
            echo    '<td>'.$fila->nombre_chofer.'</td>';     
          
        }
        }
        ?>
        </tbody>
    </table>

<script>
//Modal Editar
$(".btnEditar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $("#tiporesiduoedit").val(data.tica_id);
    $("#dispfinaledit").val(data.difi_id);
    $("#circuitoedit").val();
    $("#empedit").val(data.tran_id);
    $("#choferedit").val(data.chof_id);
    $("#teot_id").val(data.teot_id);
    $("#obsedit").val(data.observaciones);
    $("#circuitoedit").val(data.circ_id);
    traerMovilidad(data.equi_id);
    
     });

//Modal Info
$(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    if(data.zona != null)
    {$("#zonainfo").val(data.zona);}else{
        $("#zonainfo").val("Circuito - "+data.circuito+" - no posee zona asociada ");
    }
     
     $("#dispofinalinfo").val(data.disposicion_final);
     $("#tiporesinfo").val(data.tipo_carga);
     $("#circinfo").val(data.circuito);
     $("#empinfo").val(data.transportista);
     $("#movinfo").val(data.equipo);
     $("#chofinfo").val(data.nombre_chofer);
     $("#obseinfo").val(data.observaciones);

     
    
    });
$(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $("#id_templateot").val(data.teot_id);
});

function traerMovilidad($id_equipoo)
{
    var empresa_id = $("#empedit").val();
    var resp;
    $.ajax({
        type: "POST",
        data: {id_empresa: empresa_id},
        dataType: 'json',
        url: "general/Orden/ObtenerVehixtran_id",
        success: function($respuesta) {
          resp = $respuesta;
          console.table(resp[0].equi_id);
          console.table(resp.length);
      
        },
        error: function() {
                                
        },
        complete: function() {
            for(var i=0; i<resp.length; i++){
              $('#movedit').append("<option value='" + resp[i].equi_id + "'>" +"Marca: "+resp[i].marca+" Dominio: "+resp[i].dominio+"</option");
            }
            $("#movedit").val($id_equipoo);
        }

    });
}
</script>

<script>
    DataTable($('#tabla_vehiculos'))
</script>
