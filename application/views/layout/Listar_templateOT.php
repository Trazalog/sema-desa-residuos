<table id="tabla_vehiculos" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Zona</th>
        <th>Circuito</th>
        <th>Transportista</th>
        <th>Movilidad</th>
        <th>Chofer</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
        <?php
        // if($templateOT)
        // {
            // foreach($templateOT as $fila)
            // {
            // echo "<tr data-json='".json_encode($fila)."'>";
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                
            echo   '</td>';
            // echo    '<td>'.$fila->zona_id.'</td>';   
            // echo    '<td>'.$fila->circ_id.'</td>';
            // echo    '<td>'.$fila->tran_id.'</td>';                       
            // echo    '<td>'.$fila->equi_id.'</td>';  
            // echo    '<td>'.$fila->chof_id.'</td>';     
            echo    '<td>DATO</td>';   
            echo    '<td>DATO</td>';
            echo    '<td>DATO</td>';                       
            echo    '<td>DATO</td>';  
            echo    '<td>DATO</td>';                    
            echo   '</tr>';
        // }
        // }
        ?>
        </tbody>
    </table>

<script>
//Modal Editar
$(".btnEditar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $("#zonaedit").val();
    $("#tiporesiduoedit").val();
    $("#dispfinaledit").val();
    $("#circuitoedit").val();
    $("#empedit").val();
    $("#choferedit").val();
    traerMovilidad();

    
    // $(".titulo").text('Editar Vehiculo');
    // $(".textTransinfo").attr("style","display:none"); 
    // $(".ocultaTransedit").removeAttr("style"); 
    // $('#btnsave_e').show(); 
    // $(".habilitar").removeAttr("readonly");
    // $("#div_ver").attr("style","display:none");
    // $("#tran_ver").attr("style","display:none");
    // $(".ocultar").removeAttr("style");
    // $("#e_descripcion").val( data.descripcion);
    // $("#e_marca").val(data.marca); 
    // $("#e_dominio").val(data.dominio);
    // $("#e_codigo").val(data.codigo);
    // $("#e_ubicacion").val(data.ubicacion);
    // $("#e_fechaingreso").val(data.fecha_ingreso);
    // $("#e_equi_id").val(data.equi_id);
    // $("#id_fecha_ingreso").val(data.fecha_ingreso);
    // console.table($("#id_fecha_ingreso").val());
    // var tranid = data.tran_id; 
    // $("#e_tran_id").val(tranid); 
     });

//Modal Info
$(".btnInfo").click(function(e){
    // var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    // console.table(data);
    DatosparaInfo("sfsf");
    // $(".titulo").text('Informacion Vehiculo');
    // $('#btnsave_e').hide();
    // $(".habilitar").attr("readonly","readonly"); 
    // $("#div_ver").removeAttr("style");
    // $("#tran_ver").removeAttr("style");
    // $("#tran_ver").attr("readonly","readonly");
    // $(".ocultar").attr("style","display:none");
    // $("#e_descripcion").val( data.descripcion);
    // $("#e_marca").val(data.marca); 
    // $("#e_dominio").val(data.dominio);
    // $("#e_codigo").val(data.codigo);
    // $("#e_ubicacion").val(data.ubicacion);
    // $("#e_fechaingreso").val(data.fecha_ingreso);
    // $("#id_fecha_ingreso").val(data.fecha_ingreso);
    // $("#tran_id_info").attr("readonly","readonly"); 
    // console.table($("#id_fecha_ingreso").val());
    // var tranid = data.tran_id; 
    // $("#e_tran_id").val(tranid); 
    // $(".ocultaTransedit").attr("style","display:none"); 
    // $(".textTransinfo").removeAttr("style"); 
    // //para asiganrle nombre del transportista al input tipo text 
    // $("#e_equi_id").val(data.equi_id); 
    // var tranid = data.tran_id; 
    // $("#e_tran_id").val(tranid); 
    // $sel = $("#e_tran_id"); 
    // for(var j=0; j<= $sel[0].length-1; j++){ 
 
    //     if(data.tran_id == $sel[0][j].value) 
    //     { 
    //         $("#tran_id_info").val($sel[0][j].text); 
    //     } 
    // } 
    });


function traerMovilidad()
{
    var empresa_id = $("#empinfo").val();
    var resp;
    $.ajax({
        type: "POST",
        data: {id_empresa: empresa_id},
        dataType: 'json',
        url: "general/Orden/ObtenerVehixtran_id",
        success: function($respuesta) {
          debugger;
        //   var respuesta = JSON.parse($respuesta);
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
        }

    });
}
function DatosparaInfo($data)
{
    // var datos = new FormData();
    // datos = formToObject(datos);
    // datos.zona_id = $data.zona_id;
    // datos.tica_id = $data.tica_id;
    // datos.difi_id = $data.difi_id;
    // datos.circ_id = $data.circ_id;
    // datos.tran_id = $data.tran_id;
    // datos.equi_id = $data.equi_id;
    // datos.chof_id = $data.chof_id;
    // console.table(datos);

    //             zona_id:datos.zona_id,
    //             circ_id:datos.circ_id,
    //             tran_id:datos.tran_id,
    //             equi_id:datos.equi_id,
    //             chof_id:datos.chof_id
    $.ajax({
        type: "POST",
        data: { zona_id:"6",
                circ_id:"9",
                tran_id:"7",
                equi_id:"6",
                chof_id:"4"},
        dataType: 'json',
        url: "general/Orden/getDatosparaInfo",
        success: function($respuesta) {
          debugger;
        //   var respuesta = JSON.parse($respuesta);
          resp = $respuesta;
        //   console.table(resp[0].equi_id);
        //   console.table(resp.length);
      
        },
        error: function() {
                                
        },
        complete: function() {
            // for(var i=0; i<resp.length; i++){
            //   $('#selecmov').append("<option value='" + resp[i].equi_id + "'>" +"Marca: "+resp[i].marca+" Dominio: "+resp[i].dominio+"</option");
            // }
        }

    });


}
</script>

<script>
    DataTable($('#tabla_vehiculos'))
</script>
