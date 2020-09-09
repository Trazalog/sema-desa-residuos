<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Template Orden de Transporte</h4>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-2 col-lg-1 col-xs-12">
                <button type="button" id="botonAgregar" class="btn btn-primary" aria-label="Left Align">
                    Agregar
                </button><br>
            </div>
            <div class="col-md-10 col-lg-11 col-xs-12"></div>
        </div>
    </div>
</div>


<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->




<!---//////////////////////////////////////--- FIN BOX 1 ---///////////////////////////////////////////////////////----->


<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
    <h5>Informacion</h5> 
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <form id="formDatos" method="POST" autocomplete="off" class="registerForm">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nro" class="form-label">Nro:</label>
                        <input type="number" size="10" type="text" name="nro" id="nro" min="0" class="form-control"
                            required>
                    </div>
               
                    <div class="form-group">
                        <label for="tiporesiduo" class="form-label">Tipo de residuo:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tiporesiduo"
                            name="tiporesiduo" required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                            foreach ($tipoResiduo as $j) {
                                                echo '<option value="'.$j->tabl_id.'">'.$j->valor.'</option>';
                                            }
                                    ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="observaciones" class="form-label">Observaciones:</label>
                    <br>
                    <input type="text" id="obs" style="width: 52rem; height: 4rem;">
                    <input type="text" id="teot_id" style="display:none">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="fecha" class="form-label">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>" class="form-control"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="dispfinal" class="form-label">Disposicion final:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="dispfinal" name="dispfinal"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                        foreach ($disposicionFinal as $a) {
                                            echo '<option value="'.$a->tabl_id.'">'.$a->valor.'</option>';
                                            }
                                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="circuito" class="form-label">Circuito:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="circuito" name="circuito"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                            foreach ($circuito as $c) {
                                                echo '<option value="'.$c->circ_id.'">'.$c->codigo.'</option>';
                                            }
                                    ?>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <hr>





<!---//////////////////////////////////////--- FIN BOX 1 ---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////--- BOX 2 ---///////////////////////////////////////////////////////----->



            <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary ">
                            <div class="box-header with-border">
                                <h4>Transportistas</h4>
                            </div>
                        </div>
                    </div>
                <br>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="selecemp" class="form-label">Empresa:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="emp" name="empresa"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                            foreach ($empresa as $k) {
                                                echo '<option value="'.$k->tran_id.'">'.$k->razon_social.'</option>';
                                            }
                                    ?>
                        </select>
                    </div>
                   
                    <div class="form-group">
                        <label for="chofer" class="form-label">Chofer:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="chofer" name="chofer"
                            required>
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                                            foreach ($chofer as $t) {
                                                echo '<option value="'.$t->documento.'">'.$t->nombre.'</option>';
                                            }
                                    ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="selecmov" class="form-label">Movilidad:</label>
                        <select size="3" class="form-control" id="selecmov" name="movilidad" required>
                        </select>
                    </div>
                   
                </div>
            </div>

            <div class="col-md-12"><hr></div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnregistrar">Guardar</button>
                </div>
            </div>
        </div>
    </form>
  </div>
 </div>
</div>
<!--  Box 3-->
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla">
                </div>
    </div>
    </div>


<!-- Modal editar-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabell">Editar datos</h5>
            </div>
            <form id="formEditDatos" method="POST" autocomplete="off" class="registerForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                       
                            <div class="form-group">
                                <label for="tiporesiduoo" class="form-label">Tipo de residuo:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="tiporesiduoedit"
                                    name="tiporesiduo" required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                                 foreach ($tipoResiduo as $j) {
                                                                    echo '<option value="'.$j->tabl_id.'">'.$j->valor.'</option>';
                                                                }
                                                        ?>
                                </select>
                            </div>
                            <div class="form-group">
                            <label for="tiporesiduoo" class="form-label">Observaciones:</label>
                            <br>
                            <textarea  id="obsedit" cols="41" rows="5" style="border-color: #d2d6de;"></textarea>
                            <input type="text" id="teot_id"  style="display:none">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="fechaa" class="form-label">Fecha:</label>
                                <input type="date" id="fechaedit" name="fecha" value="<?php echo $fecha;?>"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="dispfinall" class="form-label">Disposicion final:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="dispfinaledit"
                                    name="dispfinal" required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                            foreach ($disposicionFinal as $a) {
                                                                echo '<option value="'.$a->tabl_id.'">'.$a->valor.'</option>';
                                                                }
                                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="circuitoo" class="form-label">Circuito:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="circuitoedit"
                                    name="circuito" required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                                 foreach ($circuito as $c) {
                                                                    echo '<option value="'.$c->circ_id.'">'.$c->codigo.'</option>';
                                                                }
                                                        ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="row">
                        <div class="box-header with-border">
                            <h4>Transportistas</h4>
                        </div>
                        <br>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="selecemp" class="form-label">Empresa:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="empedit" name="empresa"
                                 required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                         <?php
                                            foreach ($empresa as $k) {
                                                echo '<option value="'.$k->tran_id.'">'.$k->razon_social.'</option>';
                                            }
                                         ?>
                                 </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="choferr" class="form-label">Chofer:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="choferedit" name="chofer"
                                    required>
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                                                 foreach ($chofer as $t) {
                                                                    echo '<option value="'.$t->documento.'">'.$t->nombre.'</option>';
                                                                }
                                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="selecmovv" class="form-label">Movilidad:</label>
                                <select size="3" class="form-control" id="movedit" name="movilidad" required>
                                </select>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btnsavedit">Guardar</button>
                        <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal info-->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
            
                        <div class="form-group">
                            <label for="zonita" class="form-label">Zona asociada a circuito:</label>
                            <input type="text" id="zonainfo" class="form-control input-sm" readonly>
                            
                        </div>
                        <div class="form-group">
                            <label for="dispofinal" class="form-label">Disposicion final</label>
                            <input type="text" id="dispofinalinfo" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tipores" class="form-label">Tipo de residuo:</label>
                            <input type="text" id="tiporesinfo" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="circuit" class="form-label">Circuito:</label>
                            <input type="text" id="circinfo" class="form-control input-sm" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="empresita" class="form-label">Empresa:</label>
                            <input type="text" id="empinfo" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="movi" class="form-label">Movilidad:</label>
                            <input type="text" id="movinfo" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="chof" class="form-label">Chofer:</label>
                            <input type="text" id="chofinfo" class="form-control input-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tiporesiduoo" class="form-label">Observaciones:</label>
                            <br>
                            <textarea  id="obseinfo" cols="41" rows="5" style="border-color: #d2d6de;" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!---//////////////////////////////////////--- MODAL BORRAR ---///////////////////////////////////////////////////////----->
    
<div class="modal fade" id="modalBorrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"> Eliminar Template</h5>
            </div>
            <input type="text" id="id_templateot" style="display:none">
            <div class="modal-body">
            <center>
					<h4>
						<p>¿DESEA ELIMINAR EL TEMPLATE?</p>
					</h4>
			</center>
            <!--__________________ FIN FORMULARIO MODAL ___________________________-->
            </div>
            <div class="modal-footer">
                    <center>
                    <button type="submit" class="btn btn-primary" id="btndelete" onclick="deletevehiculo()">SI</button>
                    <button type="submit" class="btn btn-default" id="btncancelar" data-dismiss="modal" id="cerrar">NO</button>
                    </center>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->

<!-- script 
 muestra datos en modal edit -->
<script>
 $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Orden/Listar_templateOt");

$("#emp").change(function(){
    var empresa_id = $("#emp").val();
    var resp;
    wo();
    $.ajax({
        type: "POST",
        data: {id_empresa: empresa_id},
        dataType: 'json',
        url: "general/Orden/ObtenerVehixtran_id",
        success: function($respuesta) {
            wc();
          resp = $respuesta;
          console.table(resp[0].equi_id);
          console.table(resp.length);
      
        },
        error: function() {
             wc();                   
        },
        complete: function() {
            for(var i=0; i<resp.length; i++){
              $('#selecmov').append("<option value='" + resp[i].equi_id + "'>" +"Marca: "+resp[i].marca+" Dominio: "+resp[i].dominio+"</option");
            }
        }

    });
});

$("#empedit").change(function(){
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
        }

    });
});

$("#btnregistrar").click(function(e){
   
    var datosTemplate = new FormData();
    datosTemplate = formToObject(datosTemplate);
    datosTemplate.observaciones = $("#obs").val();
    datosTemplate.tica_id = $("#tiporesiduo").val();
    datosTemplate.difi_id = $("#dispfinal").val();
    datosTemplate.circ_id = $("#circuito").val();
    datosTemplate.equi_id = $("#selecmov").val();
    datosTemplate.chof_id = $("#chofer").val();
    console.table(datosTemplate);
    if($("#formDatos").data('bootstrapValidator').isValid())
    {
        wo();
        $.ajax({
            type: "POST",
            data: {datos: datosTemplate},
            url: "general/Orden/RegistrarTemplateOt",
            success: function(r) {
            console.table(r);
            if(r == "Ok"){
                wc();
                $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Orden/Listar_templateOt");
                alertify.success("Template Registrado con exito");
                $('#formDatos').data('bootstrapValidator').resetForm();
                $("#formDatos")[0].reset();
                $("#boxDatos").hide(500);
                $("#botonAgregar").removeAttr("disabled");
            }else{
                wc();
                alertify.error("Error al agregar Template");
            }
        
            }, 
            error: function() {
                wc();                   
            }

        });
    }else{
        alert("ATENCION! Hay campos vacios");
    }
   
});


//Funcion Editar el vehiculo

$("#btnsavedit").click(function(e){
    var datosTemEdit = new FormData();
    datosTemEdit = formToObject(datosTemEdit);
    datosTemEdit.observaciones = $("#obsedit").val();
    datosTemEdit.tica_id = $("#tiporesiduoedit").val();
    datosTemEdit.difi_id = $("#dispfinaledit").val();
    datosTemEdit.circ_id = $("#circuitoedit").val();   
    datosTemEdit.equi_id = $("#movedit").val();
    datosTemEdit.chof_id = $("#choferedit").val();
    datosTemEdit.teot_id = $("#teot_id").val();
    console.table(datosTemEdit);
        
        wo();
        $.ajax({
                type: "POST",
                data: {datosEdit: datosTemEdit},
                url: "general/Orden/ActualizarTemplateOt",
                success: function (r) {
                    wc();
                    console.table(r);
                    if (r == "ok") {
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Orden/Listar_templateOt");
                        alertify.success("Template Actualizado con exito");
                        $("#modalEdit").modal('hide');
                       

                      

                    } else {
                    
                        alertify.error("Error al Actualizar Template");
                    }
                }, 
                error: function() {
                     wc();                   
                }
            });

    });
$("#btndelete").click(function(e){
    var datosTemDelete = new FormData();
    datosTemDelete = formToObject(datosTemDelete);
    // datosTemEdit.zona_id = $("#zona").val();
    datosTemDelete.teot_id = $("#id_templateot").val();
  
        //faltaria la ubicaion, el codigo y tran_id
        wo();
        $.ajax({
                type: "POST",
                data: {datosDelete: datosTemDelete},
                url: "general/Orden/EliminarTemplateOt",
                success: function (r) {
                    wc();
                    console.table(r);
                    if (r == "ok") {
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Orden/Listar_templateOt");
                        alertify.success("Template Eliminado con exito");
                        $("#modalBorrar").modal('hide');
                       

                      

                    } else {
                        
                        alertify.error("Error al Eliminar Template");
                    }
                }, 
                error: function() {
                    wc();                   
                }
            });

});

</script>




<script>
    //este script me permite limpiar la validacion una vez cerrado el modal
    $("#modalEdit").on("hidden.bs.modal", function (e) {
        $("#formEditDatos").data('bootstrapValidator').resetForm();
    });

    $('#formDatos').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        excluded: ':disabled',
        fields: {
            nro: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            dispfinal: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            zona: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            circuito: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            tiporesiduo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            empresa: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'seleccione una opcion'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            movilidad: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'seleccione una opcion'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            chofer: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        // guardar();
    });

    // <!-- script bootstrap validator -->

    $('#formEditDatos').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        excluded: ':disabled',
        fields: {
            empresa: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'seleccione una opcion'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            },
            movilidad: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'seleccione una opcion'
                    }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        //se invoca a la funcion actualizar con el parametro auxedit que contiene el id de la fila seleccionada, a la que le vamos a actualizar los datos
        actualizar(localStorage.getItem('auxedit'));
    });



// <!-- script que cierra box con boton (x) -->

    $("#btnclose").on("click", function () {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });

// <!-- script que muestra box de datos al dar click en boton agregar -->

    $("#botonAgregar").on("click", function () {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();

    });


// <!-- Script inicia variable auxiliar gloabal -->

    $(document).ready(function () {
        localStorage.setItem('aux', 0);
      
    });

    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
    })
</script>