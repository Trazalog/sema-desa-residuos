<div id="lista_cont">
<div id="tabla">
        <div>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>" class="form-control" required>
        </div>
<table id="tabla_contenedores" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">
        <th><span class="glyphicon glyphicon-ok" aria-hidden="true" id="select"></span></th>
        <th>Acciones</th>
        <th>Zona</th>
        <th>Circuito</th>
        <th>Movilidad</th>
        <th>Chofer</th>
        <th>Transportista</th>
        <th>Tipo de RSU</th>
        <th>Nro OT</th>
        <th>Estado</th>
        


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
        <?php
                    if($templates)
                    {
                        foreach($templates as $fila)
                        {
                            
                            
                            echo "<tr data-json='".json_encode($fila)."'>";
                            echo    '<td>';
                             if($fila->ortr_id == null){
                            echo    '<input type="checkbox">&nbsp';
                             }
                            echo    '</td>';
                            echo    '<td>';
                            echo    '<button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp';
                                
                            echo   '</td>';
                            echo    '<td>'.$fila->zona.'</td>';
                            echo    '<td>'.$fila->circuito.'</td>';
                            echo    '<td>'.$fila->equipo.'</td>';
                            echo    '<td>'.$fila->nombre_chofer.'</td>';
                            echo    '<td>'.$fila->transportista.'</td>';
                            echo    '<td>'.$fila->tipo_carga.'</td>';
                            echo    '<td>'.$fila->teot_id.'</td>';
                            if($fila->ortr_id != null){
                            echo '<td>Ejecutada</td>';
                             }
                            if($fila->ortr_id == null){
                            echo '<td>Sin Ejecutar</td>';
                            }
   
                            echo '</tr>';


                         
                        }
                    }
        ?>


    </tbody>
</table>
 </div>
</div>


<!--__________________FIN TABLA___________________________-->
<script>

function llamarEjecutarOTs ($data)
{

    // var TeotId = new FormData();
    //     TeotId  = formToObject(TeotId);

    //     var cont = new FormData();
    //     cont  = formToObject(cont);
    //     cont.cont_id = d.cont_id;
    //     TeotId.fec_retiro =$("#fecha").val();
    //     TeotId.difi_id = d.difi_id;
    //     TeotId.sotr_id = 38;
    //     TeotId.equi_id =d.equi_id;
    //     TeotId.chof_id =d.chof_id;
    //     TeotId.usuario_app = "hugoDS";
    //     TeotId.teot_id = d.teot_id;
    //     TeotId.contenedores = cont;    

        $.ajax({
                type: "POST",
                data: {data: $data},
                url: "general/Estructura/OrdenMuniMasivas/EjecutarOTs",
                success: function (r) {
                    console.table(r);
                    if (r == "ok") {
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/OrdenMuniMasivas/Listar_OrdenesMuniMasivas");
                        alertify.success("Ejecutadas con exito");
                        // $("#modalEdit").modal('hide');
                       

                      

                    } else {
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/OrdenMuniMasivas/Listar_OrdenesMuniMasivas");
                        alertify.error("error al ejecutar");
                    }
                },
            });
}
 function EjecutarOTs()
{
    
    var aux = []; 
    var datoSelect = new FormData();
        datoSelect  = formToObject(datoSelect);
    $("input:checkbox:checked").each( function() { 

        var datos = $(this).parents("tr").attr("data-json");		
        var reg = $(this).parents("tr");
        if (datos != null) {	
        var d = JSON.parse(datos);
        console.table(d.teot_id);
        aux.push(d);
        }	
    });
    datoSelect.datos = aux;
    llamarEjecutarOTs(datoSelect);
}

$(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
     $("#zonainfo").val(data.zona);
     $("#dispofinalinfo").val(data.disposicion_final);
     $("#tiporesinfo").val(data.tipo_carga);
     $("#circinfo").val(data.circuito);
     $("#empinfo").val(data.transportista);
     $("#movinfo").val(data.equipo);
     $("#chofinfo").val(data.nombre_chofer);

     
    
    });

</script>

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