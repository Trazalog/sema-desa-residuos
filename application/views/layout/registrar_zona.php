<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Zona</h4>
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
        <form class="formZonas" id="formZonas">
            <div class="col-md-12">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="Nombre" name="Nombre">Nombre:</label>
                        <input type="text" class="form-control" id="Nombre">
                    </div>

                    <!--_____________________________________________-->

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

                </div>

                <div class="col-md-6">

                    <!--_____________________________________________-->

                    <div class="form-group">
                        <label for="CircR" name="Circuito_Recorrido">Circuito / Recorrido:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="CircR">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                        foreach ($CircR as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                        </select>
                    </div>

                    <!--_____________________________________________-->

                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="Descripcion">
                    </div>
                </div>

                <!--_____________________________________________-->
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-6">

                    <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                        <input type="file" name="upload">
                    </form>
                </div>
                <!--_____________________________________________-->
            </div>




            <div class="col-md-12">
                <hr>
            </div>


            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>


    </div>

    <!--_____________________________________________-->
</div>
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
                                    aria-label="Browser: activate to sort column ascending">Nombre
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Engine version: activate to sort column ascending">
                                    Circuito</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Departamento
                                </th>

                            </tr>
                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody id="tablazonas">
                            <tr role="row" class="even" id="primero" hidden>
                                <td class="sorting_1">
                                    <<button type="button" title="editar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                        <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                                                class="glyphicon glyphicon-trash"
                                                aria-hidden="true"></span></button>&nbsp
                                </td>
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
                                <td>Zona 2</td>
                                <td>Circuito 9</td>
                                <td>Rivadavia</td>
                            </tr>

                            <tr role="row" class="even">
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle"
                                        data-toggle="modal" data-target="#modalEdit"><span
                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Zona 22</td>
                                <td>Circuito 19</td>
                                <td>RSanta Lucia</td>
                            </tr>
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->

                </div>
            </div>

            <!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->


            <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->


            <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
                                                <label for="CircR" name="Circuito_Recorrido">Circuito /
                                                    Recorrido:</label>
                                                <select class="form-control select2 select2-hidden-accesible"
                                                    id="CircR">
                                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                                    <?php
                                                        foreach ($CircR as $i) {
                                                            echo '<option>'.$i->nombre.'</option>';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

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
                                        </div>

                                    </div>


                                </div>
                            </form>

                            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

                        </div>

                        <div class="modal-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                                <button type="submit" class="btn btn-default" id="btnsave"
                                    data-dismiss="modal">Cerrar</button>
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
            <!-- Script Agregar datos de registrar_zona-->

            <script>
            function agregarDato() {
                console.log("entro a agregar datos");
                $('#formZonas').on('submit', function(e) {

                    e.preventDefault();
                    var me = $(this);
                    if (me.data('requestRunning')) {
                        return;
                    }
                    me.data('requestRunning', true);

                    datos = $('#formZonas').serialize();
                    console.log(datos);
                    //--------------------------------------------------------------


                    $.ajax({
                        type: "POST",
                        data: datos,
                        url: "ajax/Registrarzona/guardarDato",
                        success: function(r) {
                            if (r == "ok") {
                                //console.log(datos);
                                $('#formZonas')[0].reset();
                                alertify.success("Agregado con exito");
                            } else {
                                console.log(r);
                                $('#formZonas')[0].reset();
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
            $('#formZonas').bootstrapValidator({
                message: 'This value is not valid',
                /*feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },*/
                fields: {
                    Nombre: {
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
                    Departamento: {
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
                    CircR: {
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
                    }
                }
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                guardar();
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

            <!--_____________________________________________________________-->
            <!-- script cerrar box -->

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