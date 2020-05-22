<!--__________________HEADER TABLA__________________-->


<table id="tabla_transportistas" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

    <th>Acciones</th>
    <th>Nombre / Razon social</th>
    <th>Departamento</th>
    <th>Registro</th>
    <!-- <th>Tipo</th> -->

    </thead>

    <!--__________________BODY TABLA__________________-->

    <tbody>
    <?php
        if($generadores)
        {
            foreach($generadores as $fila)
            {
            echo "<tr data-json='".json_encode($fila)."'>";
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';                            
            echo   '</td>';
            echo    '<td>'.$fila->razon_social.'</td>';
            echo    '<td>'.$fila->zona_id.'</td>';
            echo    '<td>'.$fila->num_registro.'</td>';                       
            echo '</tr>';
        }
        }
        ?>
    </tbody>
</table>

<!--__________________FIN TABLA__________________-->


<script>

$(".btnEditar").click( function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $("#E_Nombre_Razon_social").val(data.razon_social);
    $("#E_CUIT").val(data.cuit);
    $("#E_Numero_registro").val(data.num_registro);
    $("#E_Domicilio").val(data.domicilio);
    $("#E_lat").val(data.lat);
    $("#E_long").val(data.lng);
    $("#id_gen").val(data.sotr_id);
    $(".titulo").text('Editar Generador');
    $(".habilitar").removeAttr("readonly");
    $('#btnsave_e').show(); 
    var tipozona = data.zona_id;
    $("#E_Zonag").val(tipozona);
    var tipores = data.tica_id;
    $("#E_TipoResiduo").val(tipores);
    var tipogen = data.tist_id;
    $("#E_TipoG").val(tipogen);
    var tiporubro = data.rubr_id;
    $("#E_TipoR").val(tiporubro);



});
$(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $("#E_Nombre_Razon_social").val(data.razon_social);
    $("#E_CUIT").val(data.cuit);
    $("#E_Numero_registro").val(data.num_registro);
    $("#E_Domicilio").val(data.domicilio);
    $("#E_lat").val(data.lat);
    $("#E_long").val(data.lng);
    $("#id_gen").val(data.sotr_id);
    $(".titulo").text('Informacion Generador');
    $(".habilitar").attr("readonly","readonly"); 
    $('#btnsave_e').hide();
    var tipozona = data.zona_id;
    $("#E_Zonag").val(tipozona);
    var tipores = data.tica_id;
    $("#E_TipoResiduo").val(tipores);
    var tipogen = data.tist_id;
    $("#E_TipoG").val(tipogen);
    var tiporubro = data.rubr_id;
    $("#E_TipoR").val(tiporubro);
 
              
       

});

$(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $('#btndelete').show();    
    $("#id_generador").val(data.sotr_id);
});

</script>

<!--Script Bootstrap Validacion.FORMULARIO MODAL EDITAR -->
<script>
    // $('#formGeneradoresEdit').bootstrapValidator({
    //     message: 'This value is not valid',
    //     /*feedbackIcons: {
    //         valid: 'glyphicon glyphicon-ok',
    //         invalid: 'glyphicon glyphicon-remove',
    //         validating: 'glyphicon glyphicon-refresh'
    //     },*/
    //     //excluded: ':disabled',
    //     fields: {
    //         e_nombre_razon: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 },
    //                 regexp: {
    //                     regexp: /[A-Za-z]/,
    //                     message: 'la entrada no debe ser un numero entero'
    //                 }
    //             }
    //         },
    //         e_cuit: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 },
    //                 regexp: {
    //                     regexp: /^(0|[1-9][0-9]*)$/,
    //                     message: 'la entrada debe ser un numero entero'
    //                 }
    //             }
    //         },
    //         e_zonag: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 }
    //             }
    //         },
    //         e_rubro: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 },
    //                 regexp: {
    //                     regexp: /[A-Za-z]/,
    //                     message: 'la entrada no debe ser un numero entero'
    //                 }
    //             }
    //         },
    //         e_tipo: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 }
    //             }
    //         },
    //         e_omicilio: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 },
    //                 regexp: {
    //                     regexp: /[A-Za-z]/,
    //                     message: 'la entrada no debe ser un numero entero'
    //                 }
    //             }
    //         },
    //         e_departamento: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 }
    //             }
    //         },
    //         e_numero_registro: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 },
    //                 regexp: {
    //                     regexp: /^(0|[1-9][0-9]*)$/,
    //                     message: 'la entrada debe ser un numero entero'
    //                 }
    //             }
    //         },
    //         e_tipo_Residuo: {
    //             message: 'la entrada no es valida',
    //             validators: {
    //                 notEmpty: {
    //                     message: 'la entrada no puede ser vacia'
    //                 },
    //                 regexp: {
    //                     regexp: /[A-Za-z]/,
    //                     message: 'la entrada no debe ser un numero entero'
    //                 }
    //             }
    //         }
    //     }
    // }).on('success.form.bv', function(e) {
    //     e.preventDefault();
    //     //guardar();
    // });
</script>

<script>
    DataTable($('#tabla_transportistas'));
    // DataTable($('#tabla_'));
</script>