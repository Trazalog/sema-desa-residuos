<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Incidencia</h4>
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
        <form class="formIncidencias" id="formIncidencias" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-6">
                <!--Codigo / Registro-->
                <div class="form-group">
                    <label for="numero_orden" name="numero_orden">Numero de orden:</label>
                    <input type="text" class="form-control" id="numero_orden">
                </div>
                <!--_____________________________________________-->
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Tipo de residuo" name="Tipo de residuo">Tipo de Residuo:</label>
                    <input type="text" class="form-control" id="tipo_residuo">
                </div>
                <!--_____________________________________________-->
                <!--Capacidad-->
                
                <!--_____________________________________________-->
                <!--Año de elaboracion-->
                
                <!--_____________________________________________-->
            </div>
            <div class="col-md-6">

                <!--_____________________________________________-->
                <!--fecha-->

                <div class="form-group">
                    <label for="Fecha" name="Fecha">Fecha:</label>
                    <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                    <input type="date" class="form-control" id="Fecha">
                </div>

            </div>

                <!--_____________________________________________-->
                <!--Disposicion final-->

           

                <div class="form-group">
                    <label style="margin-left:10px" for="">Disposicion Final:</label>
                    <div class=" input-group">
                         <input type="text" class="form-control" id="disposicion_final">

                        <span class="input-group-btn">
                            <button class='btn btn-primary' data-toggle="modal" data-target="#modal_nombre">
                            <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </div>

            
                

                <!--_____________________________________________-->
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <!--_____________________________________________-->
            <!--Boton de guardado-->
            <!-- <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            </div> -->
            <!--_____________________________________________-->
        </form>

        


         <!-- *************** BOX 1.1 *************** -->



        <div class="row">

            <!-- ________________HEADER_______________ -->

            <div class="col-md-12">

               

                
            </div>
        </div>


        <br>
        <div class="col-md-12">
            <div class="col-md-6">

            <!--_____________________________________________-->
            <!--Descripcion-->

                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="descripcion">
                </div>

            <!--_____________________________________________-->
            <!--Inspector-->

                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Inspector:</label>
                    <input type="text" class="form-control" id="descripcion">
                </div>
                
            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Tipo de Incidencia:</label>
                    <input type="text" class="form-control" id="descripcion">
                </div>
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">N° Acta:</label>
                    <input type="text" class="form-control" id="descripcion">
                </div>
                
            </div>
        </div>

        <div class="col-md-12">

            <div class="col-md-6">

            <!--_____________________________________________-->
            <!--Descripcion-->

                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Transportista:</label>
                    <input type="text" class="form-control" id="descripcion">
                </div>

            <!--_____________________________________________-->
            <!--Inspector-->

                <div class="form-group">
                    <label for="Inspector" name="Inspector">Generador:</label>
                    <input type="text" class="form-control" id="inspector">
                </div>
                
            </div>

            <!--*********************************************-->

            <div class="col-md-6">

                <!--_____________________________________________-->
                <!--Fecha-->

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="Descripcion" name="Descripcion">Fecha:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa  fa-calendar"></i>
                            </div>
                        <input type="date" class="form-control" id="descripcion">
                        </div>
                    </div>

                    </div>

                <!--_____________________________________________-->
                <!--Hora-->

                    <div class="col-md-6">

                    <div class="form-group">
                        <label for="Hora" name="Hora">Hora:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        <input type="number" class="form-control" id="hora">
                        </div>
                    </div>
                    

                    </div>

                </div>
                
          
        </div>

        <div class="col-md-12">

        <hr>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            </div>
    </div>
    </div>
</div>

<!-- *************** FIN BOX 1.1 *************** -->





<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---BOX 2 DATATBLE ---///////////////////////////////////////////////////////----->



<div class="box box-primary">


<div class="col-md-1"><br></div>

    <!--__________________TABLA___________________________-->


    <div class="box-body">


        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            
            <div class="row">
                <div class="col-sm-12 table-scroll">

                    <!--__________________HEADER TABLA___________________________-->

                    <table id="tabla_incidencias" class="table table-bordered table-striped">
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
                            <td> DATO</td>
                            <td>DATO</td>
                        </tr>

                           
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->

                </div>
            </div>

        </div>
    </div>

</div>



<!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->




<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->



<div class="box box-primary">


<div class="box-header with-border">
        <div class="box-tittle">
            <h5>Reporte de Incidencias</h5>
        </div>
</div>
   


<div class="box-body">


            <div class="col-md-12">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Tipo_incidencia" name="Tipo incidencia">Tipo de incidencia:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tipo_incidencia">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                
                    <div class="form-group">
                        <label for="Transportista" name="Transportista">Transportista:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="Transportista">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Generador" name="Generador">Generador:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                        </select>
                    </div>
                </div>

            </div>


            <div class="col-md-12"><hr></div>
   

 <!--__________________TABLA___________________________-->


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
                                type="button"><span>Print</span></button> 
                        </div>

                </div>

                <!--__________________BOTONES EXPORTACION___________________________-->

                <div class="col-md-12"><br></div>

                

                <!--__________________HEADER TABLA___________________________-->

                <div class="col-md-12 table-scroll">

                  

                    <table id="tabla_reportes_incidencia" class="table table-bordered table-striped">
                        
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            
                            <th>Descripcion</th>
                            <th>Tipo de incidencia</th>
                            <th>fecha y hora</th>
                            <th>Inspector</th>
                            <th>Generador</th>
                            <th>Transportista</th>
                            <th>N° Acta</th>
                            

                        
                        </thead>

                        <!--__________________BODY TABLA___________________________-->


                        <tbody id="tablaIncidencia">
                            <tr role="row" class="even" id="primero" hidden>
                             
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                             
                            </tr>

                           
                        </tbody>
                    </table>

                    <!--__________________FIN TABLA___________________________-->

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
                    url: "general/Estructur/Incidencia/guardarDato",
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
             guardar();
        });
        </script>



<!--_____________________________________________________________-->
<!-- script Datatables -->


<script>
    
    DataTable($('#tabla_incidencias'))

    DataTable($('#tabla_reportes_incidencia'))

    

</script>

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