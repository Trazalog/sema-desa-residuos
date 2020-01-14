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
                        <label for="Nombre" >Nombre:</label>
                        <input type="text" name="Nombre" class="form-control" id="Nombre">
                    </div>

                    <!--_____________________________________________-->

                    <div class="form-group">
                        <label for="Dpto" >Departamento:</label>
                        <select class="form-control select2 select2-hidden-accesible" name="Departamento" id="Dpto">
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
                        <label for="CircR" >Circuito / Recorrido:</label>
                        <select class="form-control select2 select2-hidden-accesible" name="Circuito_Recorrido" id="CircR">
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
                        <label for="Descripcion" >Descripcion:</label>
                        <input type="text" name="Descripcion" class="form-control" id="Descripcion">
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




            <div class="col-md-12"><hr></div>


            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>


    </div>

    <!--_____________________________________________-->
</div>
</form>
</div>
</div>



<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

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
                    <table id="tabla_zonas" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Circuito</th>
                            <th>Descripcion</th>
                            

                        </thead>

                        <!--__________________BODY TABLA___________________________-->

                        <tbody>
                        <tr>
                            <td>
                            <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                            <!-- <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp -->
                            <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                            
                            </td>
                            <td>DATO</td>
                            <td> DATO</td>
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Zona</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="" class="registerForm">


                <div class="modal-body">

                

                    <div class="row"> 

                        <div class="col-md-12 "> 

                                               

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Nombre-->

                                <div class="form-group">
                                 <label for="Nombre" name="">Nombre:</label>
                                 <input type="text" class="form-control" id="">
                                </div>

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="form-group">
                                    <label for="Descripcion" name="">Descripcion:</label>
                                     <input type="text" class="form-control" id="">
                                </div>

                            </div>

                            

                            <!--**************************************************-->
                            
                            

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Circuito-->

                                <div class="form-group">
                                    <label for="CircR" name="">Circuito / Recorrido:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php
                                    foreach ($CircR as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>

                                <!--_____________________________________________-->
                                <!--Departamento-->                

                                <div class="form-group">
                                    <label for="Dpto" name="">Departamento:</label>
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

            <!-- <script>
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
                    'keytable': true,
                    
                })
            })



            
            </script> -->

            <script>
            DataTable($('#tabla_zonas'))
            </script>
            </body>