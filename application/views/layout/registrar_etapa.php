<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3>Registrar Etapa</h3>
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

    <!---//////////////////////////////////////---BOX 1---///////////////////////////////////////////////////////----->
    

    <div class="box-body">
        <form class="formEtapa" id="formEtapa">
        
        <div class="col-md-6">
    
            <!--Nombre-->
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre">
            </div>
            <!--_____________________________________________-->

            <!--Fecha de alta-->
            <div class="form-group">
                <label for="Fechalta">Fecha de alta:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="Fecha_de_alta">
                </div>
                <!-- /.input group -->
            </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-6">
        
            <!--Nombre Recipiente-->
            <div class="form-group">
                 <label for="NombreRecipiente">Nombre Recipiente:</label>
                <input type="text" class="form-control" id="NombreRecipiente" name="NombreRecipiente">
            </div>
            <!--_____________________________________________-->
                    
            <!--Usuario-->
            <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="Usuario" disabled>
            </div>
            <!--_____________________________________________-->
        
            <!--Boton de guardado-->
            <hr>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
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
            
             <div class="col-md-12 table-scroll">

                <!--__________________HEADER TABLA___________________________-->
                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
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
                                    Recipiente</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Fecha de Alta
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Usuario
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
                                <td>Nombre 1</td>
                                <td>Recipiente 1</td>
                                <td>--/--/--</td>
                                <td>Usuario 1</td>

                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <td>Nombre 2</td>
                                <td>Recipiente 2</td>
                                <td>--/--/--</td>
                                <td>Usuario 2</td>
                            </tr>

                            <tr role="row" class="even" >
                                <td class="sorting_1">
                                    <button type="button" id="btninfo" title="info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                                </td>
                                <<td>Nombre 3</td>
                                <td>Recipiente 3</td>
                                <td>--/--/--</td>
                                <td>Usuario 3</td>

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

                
                
                <div class="row">

                    <!--_____________________________________________-->
                    <!--Registro-->


                        <div class="col-md-6">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="generador" class="form-label label-sm">Registro</label>
                                    <input type="text" id="" name="" required class="form-control input-sm">
                                </div>
                            </div>
                    <!--_____________________________________________-->
                    <!--Usuario-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Usuario">Usuario:</label>
                                    <input type="text" class="form-control" id="Usuario" name="Usuario" disabled>
                                </div>
                             </div>
                        </div>
                    <!--_____________________________________________-->
                    <!--Fecha de alta-->

                    <div class="col-md-6">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Fechalta">Fecha de alta:</label>
                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" name="Fecha_de_alta">
                            </div>
                        </div>
                    <!--_____________________________________________-->
                    <!--Nombre Recipiente-->
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="NombreRecipiente">Nombre Recipiente:</label>
                            <input type="text" id="" name="" required class="form-control input-sm">
                            </div>

                        </div>

                    </div>
                </div>

                <!--_____________________________________________-->
                <!--Fecha de Alta-->

                
                    
                    
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


<!-- Script Agregar datos de registrar_etapa-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formEtapa').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formEtapa').serialize();
    console.log(datos);
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registraretapa/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formEtapa')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formEtapa')[0].reset();
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


<!--Script Bootstrap Validacion.-->
<script>
      $('#formEtapa').bootstrapValidator({
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
            Fecha_de_alta: {
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
            NombreRecipiente: {
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
            Usuario: {
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
            }
        }
}).on('success.form.bv', function(e){
    e.preventDefault();
    //guardar();
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
            