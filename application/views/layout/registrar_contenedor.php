<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Contenedor</h4>
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




<!---//////////////////////////////////////---BOX 1---///////////////////////////////////////////////////////----->


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
        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-6">
                <!--Codigo / Registro-->
                <div class="form-group">
                    <label for="Codigo/Registro">Codigo / Registro:</label>
                    <input type="text" class="form-control" id="Codigo/Registro" name="Codigo_registro">
                </div>
                <!--_____________________________________________-->
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion" name="Descripcion">
                </div>
                <!--_____________________________________________-->
                <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad">Capacidad:</label>
                    <input type="text" class="form-control" id="Capacidad" name="Capacidad">
                </div>
                <!--_____________________________________________-->
                <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab">Año de elaboracion:</label>
                    <input type="text" class="form-control" id="Añoelab" name="Añoelab">
                </div>
                <!--_____________________________________________-->
            </div>
            <div class="col-md-6">
                <!--Tara-->
                <div class="form-group">
                    <label for="Tara">Tara:</label>
                    <input type="text" class="form-control" id="Tara" name="Tara">
                </div>
                <!--_____________________________________________-->
                <!--Estado-->
                <div class="form-group">
                    <label for="Estados">Estado:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Estados" name="Estados">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estados as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Habilitacion-->
                <div class="form-group">
                    <label for="Habilitacion">Habilitacion:</label>
                    <input type="text" class="form-control" id="Habilitacion" name="Habilitacion">
                </div>


                <!--_____________________________________________-->
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <!--_____________________________________________-->

            <!--Boton de guardado-->
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            </div>
            <!--_____________________________________________-->
        </form>
    </div>
</div>


<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->



<div class="box box-primary">


    <!--__________________TABLA___________________________-->


    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

            <div class="row">


                <!--__________________BOTONES EXPORTACION___________________________-->

                <div class="col-md-12">

                    <div class="dt-buttons btn-group  pull-right">
                        <button class="btn btn-default  buttons-excel buttons-html5" tabindex="0"
                            aria-controls="example2" type="button " aria-label="Left Align"><span>Excel</span></button>
                        <button class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="example2"
                            type="button"><span>PDF</span></button>
                        <button class="btn btn-default buttons-print" tabindex="0" aria-controls="example2"
                            type="button"><span>Print</span></button> </div>

                </div>

                <!--__________________BOTONES EXPORTACION___________________________-->

                <br>

                <br>



                <div class="col-sm-12 table-scroll">

                    <!--__________________HEADER TABLA___________________________-->

                    <table id="example2" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Acciones</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Codigo/Registro
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Engine version: activate to sort column ascending">
                                    Descripcion</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Estado
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Habilitacion
                                </th>
                            </tr>
                        </thead>

                        <!--__________________BODY TABLA___________________________-->


                        <tbody id="tablaContenedor">
                            <tr role="row" class="even" id="primero" hidden>
                                <td class="sorting_1">
                                    <button type="button" title="editar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr role="row" class="even">
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle"
                                        data-toggle="modal" data-target="#modalEdit"><span
                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Contenedor 1</td>
                                <td>------</td>
                                <td>Optimo</td>
                                <td>Habilitado</td>
                            </tr>

                            <tr role="row" class="even">
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle"
                                        data-toggle="modal" data-target="#modalEdit"><span
                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Contenedor 1</td>
                                <td>------</td>
                                <td>Optimo</td>
                                <td>Habilitado</td>
                            </tr>

                            <tr role="row" class="even">
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle"
                                        data-toggle="modal" data-target="#modalEdit"><span
                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Contenedor 1</td>
                                <td>------</td>
                                <td>Optimo</td>
                                <td>Habilitado</td>
                            </tr>
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->

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





        <!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->


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
        <!-- Script Agregar datos de registrar_generadores-->

        <script>
        function agregarDato() {
            console.log("entro a agregar datos");
            $('#formContenedores').on('submit', function(e) {

                e.preventDefault();
                var me = $(this);
                if (me.data('requestRunning')) {
                    return;
                }
                me.data('requestRunning', true);

                datos = $('#formContenedores').serialize();
                console.log(datos);


                //--------------------------------------------------------------


                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "ajax/Registrargenerador/guardarDato",
                    success: function(r) {
                        if (r == "ok") {
                            //console.log(datos);
                            $('#formContenedores')[0].reset();
                            alertify.success("Agregado con exito");
                        } else {
                            console.log(r);
                            $('#formContenedores')[0].reset();
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
        <!-- Script Boostrap Validator-->

        <script>
        $('#formContenedores').bootstrapValidator({
            message: 'This value is not valid',
            /*feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            fields: {
                Codigo_registro: {
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
                Descripcion: {
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
                Capacidad: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                    }
                },
                Descripcion: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                    }
                };
                Añoelab: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                    }
                };
                Tara: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                    }
                };
                Estados: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                    }
                };
                Habilitacion: {
                    message: 'la entrada no es valida',
                    validators: {
                        notEmpty: {
                            message: 'la entrada no puede ser vacia'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            // guardar();
        });
        </script>






        <!---//////////////////////////////////////---DATA TABLES SCRIPT---///////////////////////////////////////////////////////----->
        <!-- Script Data-Tables-->
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

        <!-- Script Data-Tables-->


        <!---//////////////////////////////////////---DATA TABLES SCRIPT---///////////////////////////////////////////////////////----->






        <!-- <script>
            $(document).ready(function() {
                var table = $('#example1').DataTable({
                    fixedHeader: true,
                    colReorder: true
                });
            });
            </script>

            <script>
            $(document).ready(function() {
                $('#example1').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'print',
                            text: 'Print all',
                            exportOptions: {
                                modifier: {
                                    selected: null
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print selected'
                        }
                    ],
                    select: true
                });
            });
            </script> -->

        <!---//////////////////////////////////////---DATA TABLES SCRIPT---///////////////////////////////////////////////////////----->