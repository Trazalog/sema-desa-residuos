    <!--__________________HEADER TABLA___________________________-->
    <table id="tabla_vehiculos" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Id</th>
        <th>Dominio</th>
        <th>Descripcion</th>
        <th>Marca</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
        <?php
        if($vehiculos)
        {
            foreach($vehiculos as $fila)
            {
            echo "<tr data-json='".json_encode($fila)."'>";
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                
            echo   '</td>';
            echo    '<td>'.$fila->equi_id.'</td>';   
            echo    '<td>'.$fila->dominio.'</td>';
            echo    '<td>'.$fila->descripcion.'</td>';                       
            echo    '<td>'.$fila->marca.'</td>';                        
            echo   '</tr>';
        }
        }
        ?>
        </tbody>
    </table>

    <!--__________________FIN TABLA___________________________-->
<script>

//Modal Editar
$(".btnEditar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $(".titulo").text('Editar Vehiculo');
    $(".textTransinfo").attr("style","display:none"); 
    $(".ocultaTransedit").removeAttr("style"); 
    $('#btnsave_e').show(); 
    $(".habilitar").removeAttr("readonly");
    $("#div_ver").attr("style","display:none");
    $("#tran_ver").attr("style","display:none");
    $(".ocultar").removeAttr("style");
    $("#e_descripcion").val( data.descripcion);
    $("#e_marca").val(data.marca); 
    $("#e_dominio").val(data.dominio);
    $("#e_codigo").val(data.codigo);
    $("#e_ubicacion").val(data.ubicacion);
    $("#e_fechaingreso").val(data.fecha_ingreso);
    $("#e_equi_id").val(data.equi_id);
    $("#id_fecha_ingreso").val(data.fecha_ingreso);
    console.table($("#id_fecha_ingreso").val());
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid); 
    });

//Modal Info
$(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $(".titulo").text('Informacion Vehiculo');
    $('#btnsave_e').hide();
    $(".habilitar").attr("readonly","readonly"); 
    $("#div_ver").removeAttr("style");
    $("#tran_ver").removeAttr("style");
    $("#tran_ver").attr("readonly","readonly");
    $(".ocultar").attr("style","display:none");
    $("#e_descripcion").val( data.descripcion);
    $("#e_marca").val(data.marca); 
    $("#e_dominio").val(data.dominio);
    $("#e_codigo").val(data.codigo);
    $("#e_ubicacion").val(data.ubicacion);
    $("#e_fechaingreso").val(data.fecha_ingreso);
    $("#id_fecha_ingreso").val(data.fecha_ingreso);
    $("#tran_id_info").attr("readonly","readonly"); 
    console.table($("#id_fecha_ingreso").val());
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid); 
    $(".ocultaTransedit").attr("style","display:none"); 
    $(".textTransinfo").removeAttr("style"); 
    //para asiganrle nombre del transportista al input tipo text 
    $("#e_equi_id").val(data.equi_id); 
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid); 
    $sel = $("#e_tran_id"); 
    for(var j=0; j<= $sel[0].length-1; j++){ 
 
        if(data.tran_id == $sel[0][j].value) 
        { 
            $("#tran_id_info").val($sel[0][j].text); 
        } 
    } 
    });


//Modal Eliminar
    $(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $('#btndelete').show();    
    $("#id_vehiculo").val(data.equi_id);
});



</script>
<script>
    DataTable($('#tabla_vehiculos'))
</script>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 