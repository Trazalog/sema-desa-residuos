<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Inspectores</h4>
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

<!---//////////////////////////////////////--- BOX 1---///////////////////////////////////////////////////////----->

<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <div class="box-tittle">
            <h5>Informacion</h5>  
        </div>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formInspectores" id="formInspectores">
            <div class="col-md-6 col-sm-6 col-xs-12">
            <!--_____________________________________________-->

            <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                    <input type="text" class="form-control" id="Nombre" name="nombre">
                    </div>
                </div>
            <!--_____________________________________________-->

            <!--Apellido-->
                <div class="form-group">
                    <label for="Apellido">Apellido:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                    <input type="text" class="form-control" id="Apellido" name="apellido">
                    </div>
                </div>
            <!--_____________________________________________-->

            <!--Direccion-->
                <div class="form-group">                    
                    <label for="Direccion">Direccion:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </div>                    
                    <input type="text" class="form-control" id="Direccion" name="descripcion">
                    </div>
                </div>
            <!--_____________________________________________-->

            <!--Email-->
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </div> 
                    <input type="text" class="form-control" id="Email" name="email">
                    </div>
                </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <!--DNI-->
                <div class="form-group">
                    <label for="DNI">DNI:</label>
                    <input type="text" class="form-control" id="DNI" name="dni">
                </div>
            <!--_____________________________________________-->

            <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto">Departamento:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                        <select class="form-control select2 select2-hidden-accesible" name="Departamento" id="Dpto">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($Departamentos as $i) {
                                    echo '<option  value="'.$i->depa_id.'">'.$i->nombre.'</option>';
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label for="Departamento">Departamento:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </div> 
                    <input type="text" class="form-control" id="Departamento" name="departamento">
                    </div>
                </div>-->
            <!--_____________________________________________-->

            <!--Movilidad Asignada-->
                <div class="form-group">
                    <label for="vehiculo">Movilidad asignada:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="vehiculo"  name="vehiculo">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                            foreach ($vehiculo as $i) {
                                echo '<option  value="'.$i->equi_id.'">'.$i->descripcion.'</option>';
                                }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-12"><hr> </div>

            <!--Boton de guardado-->
                <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
                </div>
            <!--_____________________________________________-->

        </form>
    </div>
</div>

<!---//////////////////////////////////////--- FIN BOX 1---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---BOX 2 DATATBLE ---///////////////////////////////////////////////////////----->

<div class="box box-primary">

    <!--__________________TABLA___________________________-->

    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-scroll">

                    <!--__________________HEADER TABLA___________________________-->
                    <table id="tabla_inspectores" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Movilidad Asignada</th>
                        </thead>
                        <!--__________________BODY TABLA___________________________-->
                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                            </td>
                            <td>DATO</td>
                            <td>DATO</td>
                            <td>DATO</td>
                        </tr>
                        </tbody>
                    </table>
                    <!--__________________FIN TABLA___________________________-->

                </div>
            </div>

<!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Inspector</h5>
            </div>
            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmInspecotresEdit" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <!--_____________________________________________-->

                                <!--Nombre-->
                                <div class="form-group">
                                    <label for="Nombre">Nombre:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    <input type="text" class="form-control" id="E_Nombre" name="e_nombre">
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Apellido-->
                                <div class="form-group">
                                    <label for="Apellido">Apellido:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    <input type="text" class="form-control" id="E_Apellido" name="e_apellido">
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Direccion-->
                                <div class="form-group">
                                    <label for="Direccion">Direccion:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-map-marker"></i>
                                        </div>                    
                                    <input type="text" class="form-control" id="E_Direccion" name="e_descripcion">
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Email-->
                                <div class="form-group">
                                    <label for="Email">Email:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div> 
                                    <input type="text" class="form-control" id="E_Email" name="e_email">
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <!--Departamento-->
                                <div class="form-group">
                                    <label for="Departamento">Departamento:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-map-marker"></i>
                                        </div>
                                    <input type="text" class="form-control" id="E_Departamento" name="e_departamento">
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Movilidad Asignada-->
                                <div class="form-group">
                                    <label for="vehiculo">Movilidad asignada:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="vehiculo"  name="vehiculo">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php
                                            foreach ($vehiculo as $i) {
                                            echo '<option  value="'.$i->equi_id.'">'.$i->descripcion.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--_____________________________________________-->

                                <!--DNI--> 
                                <div class="form-group">
                                    <label for="DNI">Documento:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-credit-card"></i>
                                        </div>
                                    <input type="text" class="form-control" id="E_DNI" name="e_dni">
                                    </div>                                
                                </div>
                                <!--_____________________________________________-->
                            </div>
                        </div>
                    </div>
                </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>

            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Inspector</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmInspecotresInfo" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                                <!--_____________________________________________-->

                                <!--Nombre-->
                                <div class="form-group">
                                    <label for="Nombre">Nombre:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    <input type="text" class="form-control" id="I_Nombre" name="i_nombre" readonly>
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Apellido-->
                                <div class="form-group">
                                    <label for="Apellido">Apellido:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    <input type="text" class="form-control" id="I_Apellido" name="i_apellido" readonly>
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Direccion-->
                                <div class="form-group">
                                    <label for="Direccion">Direccion:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-map-marker"></i>
                                        </div>                    
                                    <input type="text" class="form-control" id="I_Direccion" name="i_descripcion" readonly>
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Email-->
                                <div class="form-group">
                                    <label for="Email">Email:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div> 
                                    <input type="text" class="form-control" id="I_Email" name="i_email" readonly>
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <!--Departamento-->
                                <div class="form-group">
                                    <label for="Departamento">Departamento:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-map-marker"></i>
                                        </div> 
                                    <input type="text" class="form-control" id="I_Departamento" name="i_departamento" readonly>
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--Movilidad Asignada-->
                                <div class="form-group">
                                     <label for="MovAsignada">Movilidad Asignada:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-bus"></i>
                                        </div> 
                                    <input type="text" class="form-control" id="I_MovAsignada" name="i_movilidadasignada" readonly>
                                    </div>
                                </div>
                                <!--_____________________________________________-->

                                <!--DNI--> 
                                <div class="form-group">
                                    <label for="DNI">DNI:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                    <input type="text" class="form-control" id="I_DNI" name="i_dni" readonly>
                                    </div>                                
                                </div>
                                <!--_____________________________________________-->
                            </div>
                        </div>
                    </div>
                </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>

            <div class="modal-footer">
                <div class="form-group text-right">
                    <!-- <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button> -->
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->
<!-- script modal -->

<script>
$("#btnview").on("click", function() {
    $("#btnadd").removeClass("active");
    $("#btnview").addClass("active");
    $("#tablamodal").show();
    $("#formadd").hide();
    $("#btnsave").hide();
});

$("#btnadd").on("click", function() {
    $("#btnadd").addClass("active");
    $("#btnview").removeClass("active");
    $("#formadd").show();
    $("#tablamodal").hide();
    $("#btnsave").show();
});
</script>


<!---/////////////////////////--- FUNCIONES - AJAX ---/////////////////////////----->

<!--_____________________________________________________________-->
<!-- Script Agregar datos de registrar_inspector-->

<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formInspectores').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formInspectores').serialize();
    console.log(datos);
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarinspector/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formInspectores')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formInspectores')[0].reset();
                        alertify.error("error al agregar");
                    }
                },
                complete: function() {
                    me.data('requestRunning', false);
                }
            });            
    });    
}
</script>


<!---/////////////////////////--- FUNCIONES - FIN AJAX ---/////////////////////////----->


<!---/////////////////////////--- BOOTSRAP VALIDATOR---/////////////////////////----->


<!--_____________________________________________________________-->
<!--Script Bootstrap Validacion. FORMULARIO GENERAl-->

<script>
    $('#formInspectores').bootstrapValidator({
    message: 'This value is not valid',
    /*feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },*/
    fields: {
            nombre: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            apellido: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            email: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            dni: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            departamento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            vehiculo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
        }
    }).on('success.form.bv', function(e){
        e.preventDefault();
        //guardar();
    });
</script>
<!--_____________________________________________________________-->
<!--Script Bootstrap Validacion. MODAL EDITAR-->

<script>
    $('#frmInspecotresEdit').bootstrapValidator({
    message: 'This value is not valid',
    /*feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },*/
    fields: {
            e_nombre: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            e_apellido: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            e_descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            e_email: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            e_dni: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /^(0|[1-9][0-9]*)$/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            e_departamento: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada no debe ser un numero entero'
                    }
                }
            },
            e_vehiculo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
        }
    }).on('success.form.bv', function(e){
        e.preventDefault();
        //guardar();
    });
</script>

<!---/////////////////////////--- FIN BOOTSRAP VALIDATOR---/////////////////////////----->

<!--_____________________________________________________________-->

<!-- script que muestra box de datos al dar click en boton agregar -->

<script>
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);

        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();

    });
</script>

<script>
    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });
</script>
<!--_____________________________________________________________-->

<!-- script Datatables -->
<script>
    DataTable($('#tabla_inspectores'))
</script>          