<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Generadores</h4>
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

        <form class="formGeneradores" id="formGeneradores">

            <div class="col-md-6">
                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                    <input type="text" class="form-control" id="Nombre/Razon social">
                </div>
                <!--_____________________________________________-->
                <!--CUIT-->
                <div class="form-group">
                    <label for="CUIT" name="Cuit">CUIT:</label>
                    <input type="text" class="form-control" id="CUIT">
                </div>
                <!--_____________________________________________-->
                <!--Zona-->
                <div class="form-group">
                    <label for="Zonag" name="Zona">Zona:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Zonag">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Zonag as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Rubro-->
                <div class="form-group">
                    <label for="Rubro" name="Rubro">Rubro:</label>
                    <input type="text" class="form-control" id="Rubro">
                </div>
                <!--_____________________________________________-->
                <!--Tipo-->
                <div class="form-group">
                    <label for="TipoG" name="Tipo">Tipo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="TipoG">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($TipoG as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--_____________________________________________-->
            <!--Domicilio-->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Domicilio" name="Domicilio">Domicilio:</label>
                    <input type="text" class="form-control" id="Domicilio">
                </div>
                <!--_____________________________________________-->
                <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto" name="Departamento">Departamento:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Dpto">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Dpto as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Numero de registro-->
                <div class="form-group">
                    <label for="Numero de registro" name="Numero_registro">Numero de registro:</label>
                    <input type="text" class="form-control" id="Numero de registro">
                </div>
                <!--_____________________________________________-->
                <!--Tipo de residuos-->
                <div class="form-group">
                    <label for="Tipo de residuos" name="Tipo_Residuo">Tipo de residuos:</label>
                    <input type="text" class="form-control" id="Tipo de residuos">
                </div>
                <!--_____________________________________________-->
                <!--Boton de guardado-->


                <!--_____________________________________________-->
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
        </form>
    </div>
</div>
</div>






<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->





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


                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Acciones</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Nombre/Razon Social
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Engine version: activate to sort column ascending">
                                    Zona</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Departamento
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Tipo
                                </th>
                            </tr>
                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody id="tablaGeneradores">
                            <tr role="row" class="even" id="primero" hidden>
                                <td class="sorting_1">
                                <button type="button" title="editar"  class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Generador 1</td>
                                <td>Zona 1</td>
                                <td>Rivadavia</td>
                                <td>Eventual</td>

                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Generador 2</td>
                                <td>Zona 3</td>
                                <td>Santa Lucia</td>
                                <td>Regular</td>
                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Generador 12</td>
                                <td>Zona 21</td>
                                <td>Chimbas</td>
                                <td>Eventual</td>

                            </tr>
                        </tbody>
                    </table>
                    
                    <!--__________________FIN TABLA___________________________-->

                    </div>
            </div>

        </div>
    </div>
 <!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->

 

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Generador</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                <!--_____________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nro" class="form-label label-sm">Nombre/Razon social</label>
                                <input type="text" id="" name="" class="form-control input-sm" required>
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="Zonag" name="Zona">Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="Zonag">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($Zonag as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                        </div>
                <!--_____________________________________________-->
                <!--Tipo de residuo-->

                            <div class="form-group">
                                <label for="" name="N-registro">N° Registro:</label>
                                <input type="text" id="" required name="" class="form-control input-sm">
                            </div>
                         </div>

                <!--_____________________________________________-->
                <!--Departamento-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Dpto" name="Departamento">Departamento:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($Dpto as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                <!--_____________________________________________-->
                <!--Tipo-->

                            <div class="form-group">
                                <label for="TipoG" name="Tipo">Tipo:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($TipoG as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
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

<!--_____________________________________________________________-->

            <script>
            function agregarDato() {
                console.log("entro a agregar datos");
                $('#formGeneradores').on('submit', function(e) {

                    e.preventDefault();
                    var me = $(this);
                    if (me.data('requestRunning')) {
                        return;
                    }
                    me.data('requestRunning', true);

                    datos = $('#formGeneradores').serialize();
                    console.log(datos);
                    //--------------------------------------------------------------


                    $.ajax({
                        type: "POST",
                        data: datos,
                        url: "ajax/Registrargenerador/guardarDato",
                        success: function(r) {
                            if (r == "ok") {
                                //console.log(datos);
                                $('#formGeneradores')[0].reset();
                                alertify.success("Agregado con exito");
                            } else {
                                console.log(r);
                                $('#formGeneradores')[0].reset();
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

<!--_____________________________________________________________-->
<!--Script Bootstrap Validacion.-->

            
            <script>
            $('#formGeneradores').bootstrapValidator({
                message: 'This value is not valid',
                /*feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },*/
                //excluded: ':disabled',
                fields: {
                    Nombre_razon: {
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

                    Cuit: {
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

                    Zona: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }
                        }
                    },

                    Rubro: {
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

                    Tipo: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }
                        }
                    },

                    Domicilio: {
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

                    Departamento: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }
                        }
                    },

                    Numero_registro: {
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

                    Tipo_Residuo: {
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
                    }
                }
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                //guardar();
            });
            </script>





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
            $(function() {
                
                $('#example2').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true,
                    'autoFill': true,
                    'buttons': true,
                    'fixedHeader': true,
                    'colReorder': true,
                    'scroller': true,
                    'keytable': true
                })
            })
            </script>
            
 
<!---//////////////////////////////////////---DATA TABLES SCRIPT---///////////////////////////////////////////////////////----->