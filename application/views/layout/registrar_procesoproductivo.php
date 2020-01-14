<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Proceso Productivo</h4>
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

        <!--Boton de cerrar-->
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
​        <!--_____________________________________________________________-->

    </div>
    <div class="box-body">
        <form class="formProcesoProductivo" id="formProcesoProductivo">
            
            <div class="col-md-12">
                <div class="col-md-4">

                    <!--Nombre-->
                    <div class="form-group">
                        <label for="Nomb">Nombre:</label>
                        <input type="text" class="form-control" id="Nomb" name="Nomb">
                    </div>
                    <!--_____________________________________________-->

                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4 col-sm-4 col-xs-12">

                    <!--Nombre-->
                    <div class="form-group">
                        <label for="Nombre">Nombre etapa:</label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre">
                    </div>
                    <!--_____________________________________________-->

                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">

                    <!--Recipiente-->
                    <div class="form-group">
                        <label for="Recipiente">Recipiente:</label>
                        <input type="text" class="form-control" id="Recipiente" name="Recipiente">
                    </div>
                    <!--_____________________________________________-->

                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">

                    <!--Orden-->
                    <div class="form-group">
                        <label for="Orden">Orden:</label>
                        <input type="number" class="form-control" id="Orden" name="Orden">
                    </div>
                    <!--_____________________________________________-->
                    
                </div>
            </div>
            <!--__________________SEPARADOR___________________________-->

    <div class="col-md-12 col-sm-12 col-xs-12"> <hr></div>

<!--________________SEPARADOR_____________________________-->
            <div class="col-md-12">

                <!--Boton de guardado-->
              
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Agregar</button>
                <!--_____________________________________________-->

            <!--Boton de guardado-->
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
​            <!--_____________________________________________________________-->

        <!--FIN DE LOS CAMPOS DEL FORMULARIO-->

    </div>
    </div>
</div>
</div>

<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->



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


                <!--__________________HEADER TABLA___________________________-->
                <table id="tabla_procesos_productivos" class="table table-bordered table-striped">
                    <thead class="thead-dark" bgcolor="#eeeeee">

                        <th>Acciones</th>
                        <th>Nombre de Etapa</th>
                        <th>Recipiente</th>
                        <th>Orden</th>
                        
                        

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

<!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Proceso productivo</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                <form class="formProcesoProductivo" id="formProcesoProductivo">
            
                    <div class="col-md-12">
                        <div class="col-md-4">

                            <!--Nombre-->
                            <div class="form-group">
                                <label for="Nomb">Nombre:</label>
                                <input type="text" class="form-control" id="Nomb" name="Nomb">
                            </div>
                            <!--_____________________________________________-->

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4 ">

                            <!--Nombre-->
                            <div class="form-group">
                                <label for="Nombre">Nombre etapa:</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre">
                            </div>
                            <!--_____________________________________________-->

                        </div>
                        <div class="col-md-4 ">

                            <!--Recipiente-->
                            <div class="form-group">
                                <label for="Recipiente">Recipiente:</label>
                                <input type="text" class="form-control" id="Recipiente" name="Recipiente">
                            </div>
                            <!--_____________________________________________-->

                        </div>
                        <div class="col-md-4 ">

                            <!--Orden-->
                            <div class="form-group">
                                <label for="Orden">Orden:</label>
                                <input type="number" class="form-control" id="Orden" name="Orden">
                            </div>
                            <!--_____________________________________________-->
                            
                        </div>
                    </div>
            

                </form>

                
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>

            <div class="modal-footer">

            <div class="col-md-12"><hr></div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--_____________________________________________________________-->

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->





<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

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
​<!--_____________________________________________________________-->

<!-- Script Data-Tables-->
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
​<!--_____________________________________________________________-->

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
​<!--_____________________________________________________________-->

<!-- Script Agregar datos de proceso_productivo-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formProcesoProductivo').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formProcesoProductivo').serialize();
    console.log(datos);
    
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Procesoproductivo/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formProcesoProductivo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formProcesoProductivo')[0].reset();
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
      $('#formProcesoProductivo').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/

      fields: {
          nomb: {
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
          nombre: {
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
          recipiente: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
          orden: {
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
          }
      }
}).on('success.form.bv', function(e){
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

DataTable($('#tabla_procesos_productivos'))

</script>
