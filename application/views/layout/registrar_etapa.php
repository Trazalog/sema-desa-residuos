<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Etapa</h4>
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
                  <input type="date" class="form-control pull-right" id="datepicker" name="Fecha_de_alta">
                </div>
                
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
                <table id="tabla_etapa" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Nombre Recipiente</th>
                            <th>Fecha de alta</th>
                                                        

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
                <h5 class="modal-title" id="exampleModalLabel">Editar Etapa</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                
                
                <div class="row">

                    <!--_____________________________________________-->
                    <!--Nombre-->


                        <div class="col-md-6">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="generador" class="form-label label-sm">Nombre</label>
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
                    <!--Nombre Recipiente-->

                    <div class="col-md-6">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NombreRecipiente">Nombre Recipiente:</label>
                                <input type="text" class="form-control" id="NombreRecipiente" name="NombreRecipiente">
                            </div>
                        </div>
                    <!--_____________________________________________-->
                    <!--Fecha de alta-->

                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="Fechalta">Fecha de alta:</label>
                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" id="datepicker" name="Fecha_de_alta">
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


<!--_____________________________________________--> 
<!-- Script Data-Tables-->



<script>
DataTable($('#tabla_etapa'))
</script>

