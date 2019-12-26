<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Transportista</h4>
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



<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->



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
    <!--_________________________________________________-->

    <div class="box-body">

        <!--__________________ FORMULARIO  ___________________________-->

        <form class="formTransportistas" id="formTransportistas">

            <!--***************************************-->
            <div class="col-md-6">
                <!--_____________________________________________-->
                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                    <input type="text" class="form-control" id="Nombre/Razon social">
                </div>
                <!--_____________________________________________-->
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
                <!--_____________________________________________-->
                <!--Direccion-->
                <div class="form-group">
                    <label for="Direccion" name="Direccion">Direccion:</label>
                    <input type="text" class="form-control" id="Direccion">
                </div>
                <!--_____________________________________________-->
                <!--Telefono-->
                <div class="form-group">
                    <label for="Telefono" name="Telefono">Telefono:</label>
                    <input type="text" class="form-control" id="Telefono">
                </div>
                <!--_____________________________________________-->
                <!--Contacto-->
                <div class="form-group">
                    <label for="Contacto" name="Contacto">Contacto:</label>
                    <input type="text" class="form-control" id="Contacto">
                </div>
                
            </div>

            <!--***************************************-->
            
            <div class="col-md-6 ">
                <!--_____________________________________________-->
                <!--Resolucion-->
                <div class="form-group">
                    <label for="Resolucion" name="Resolucion">Resolucion:</label>
                    <input type="text" class="form-control" id="Resolucion">
                </div>
                <!--_____________________________________________-->
                <!--Registro-->
                <div class="form-group">
                    <label for="Registro" name="Registro">Registro:</label>
                    <input type="text" class="form-control" id="Registro">
                </div>
                <!--_____________________________________________-->
                <!--Fecha de alta-->
                <div class="form-group">
                    <label for="Fechalta" name="Fecha_de_alta" class="form-label label-sm">Fecha de alta:</label>                                              
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="fecha-alta">
                    </div>               
                </div>

                <!--_____________________________________________-->
                <!--Fecha de baja-->
                <div class="form-group">
                    <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="fecha-baja">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Tipo de RSU autorizado-->
                <div class="form-group">
                    <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Rsu">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                    foreach ($Rsu as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                ?>
                    </select>
                </div>
            </div>

            <!--***************************************-->

            <!--_______________SEPARADOR_______________ -->

            <div class="col-md-12"><hr></div>

            <!--_______________SEPARADOR_______________ -->

            
            <!--_______________ GUARDAR _______________ -->

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            </div>

            <!--_______________ GUARDAR _______________ -->


        </form>

        <!--__________________ FIN FORMULARIO MODAL ___________________________-->

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


                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                        aria-describedby="example2_info">
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
                                    Registro</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Tipo RSU
                                </th>
                                
                            </tr>
                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody id="tablaTransportista">
                            <tr role="row" class="even" id="primero">
                                <td class="sorting_1">
                                <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td></td>
                                <td></td>
                                <td></td> 
                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Transportista 1</td>
                                <td>------</td>
                                <td>Escombro</td>                           
                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Transportista 1</td>
                                <td>------</td>
                                <td>Escombro</td> 
                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                <button type="button" title="eliminar" class="btn btn-primary btn-circle" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                </td>
                                <td>Transportista 1</td>
                                <td>------</td>
                                <td>Escombro</td> 

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
                <h5 class="modal-title" id="exampleModalLabel">Editar Transportista</h5>
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
                                <label for="generador" class="form-label label-sm">Registro</label>
                                <input type="text" id="" name="" required class="form-control input-sm">
                            </div>
                <!--_____________________________________________-->
                <!--Tipo de residuo-->

                            <div class="form-group">
                                <label for="tipores" class="form-label label-sm">Tipo RSU</label>
                                <select class="form-control select2 select2-hidden-accesible" id="">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                    foreach ($Rsu as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                ?>
                    </select>
                            </div>
                         </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rectificatoria" class="form-label label-sm">Descripcion</label>
                                <input type="text" id="" required name=""
                                    class="form-control input-sm">
                            </div>

                <!--_____________________________________________-->
                <!--Resolucion-->

                            <div class="form-group">
                            <label for="cont" class="form-label label-sm">Resolucion</label>
                                <input type="text" id="" required name="" class="form-control input-sm">
                            </div>
                        </div>
                </div>

                <!--_____________________________________________-->
                <!--Fecha de Alta-->

                <div class="row">                        
                    <div class="col-md-6">
                                <label for="Fechabaja" name="Fecha_de_baja">Fecha de Alta:</label>
                             <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                <input type="date" class="form-control pull-right" id="fecha-alta">
                             </div>
                        </div>

                <!--_____________________________________________-->
                <!--Fecha de Baja-->


                        <div class="col-md-6">
                                <label for="Fechabaja" name="Fecha_de_baja">Fecha de Baja:</label>
                             <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                <input type="date" class="form-control pull-right" id="fecha-baja">
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
<!-- Script Agregar datos de registrar_transportista-->

    <script>
    function agregarDato() {
        console.log("entro a agregar datos");
        $('#formTransportistas').on('submit', function(e) {

            e.preventDefault();
            var me = $(this);
            if (me.data('requestRunning')) {
                return;
            }
            me.data('requestRunning', true);

            datos = $('#formTransportistas').serialize();
            console.log(datos);
            //--------------------------------------------------------------


            $.ajax({
                type: "POST",
                data: datos,
                url: "ajax/Registrartransportista/guardarDato",
                success: function(r) {
                    if (r == "ok") {
                        //console.log(datos);
                        $('#formTransportistas')[0].reset();
                        alertify.success("Agregado con exito");
                    } else {
                        console.log(r);
                        $('#formTransportistas')[0].reset();
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

    



   <!--_____________________________________________________________-->
    <!--Script Bootstrap Validacion.-->
    <script>
    $('#formTransportistas').bootstrapValidator({
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
            Descripcion: {
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
            Direccion: {
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
            Telefono: {
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
            Contacto: {
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
            Resolucion: {
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
            Registro: {
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
            Fecha_de_alta: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            Fecha_de_baja: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            Rsu: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        //guardar();
    });
    </script>