<!-- Hecha por Jose Roberto el mas vergas -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Proceso Productivo</h3>
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
<!--_____________________________________________________________-->

<!--//////////////////////////////Box2//////////////////////////////-->
<div class="box box-primary animated fadeInLeft" id="boxDatos" hidden>
    <div class="box-header with-border">
        <!--_____________________________________________________________-->

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
    <form class="formProcesoProductivo" id="formProcesoProductivo"  method="POST" autocomplete="off" class="registerForm">

        <!--COMIENZO DE LOS CAMPOS DEL FORMULARIO-->

        <div class="col-md-12">

            <!--Nombre-->
            <div class="form-group">
                <label for="Nombre" style="width: 200px; font-weight: lighter;">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="nomb">
            </div>
​            <!--_____________________________________________________________-->

        </div>
        <div class="col-md-5">

            <!--Nombre-->
            <div class="form-group">
                <label for="Nombre" style="width: 200px; font-weight: lighter;">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="nombre">
            </div>
​            <!--_____________________________________________________________-->

        </div>
        <div class="col-md-5">

            <!--Recipiente-->
            <div class="form-group">
                <label for="Recipiente" style="width: 200px; font-weight: lighter;">Recipiente:</label>
                <input type="text" class="form-control" id="Recipiente" name="recipiente">
            </div>
​            <!--_____________________________________________________________-->

        </div>
        <div class="col-md-2">

            <!--Orden-->
            <div class="form-group">
                <label for="Orden" style="width: 200px; font-weight: lighter;">Orden:</label>
                <input type="text" class="form-control" id="Orden" name="orden">
            </div>
​            <!--_____________________________________________________________-->

        </div>

            <!--Boton de guardado-->
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
​            <!--_____________________________________________________________-->

        <!--FIN DE LOS CAMPOS DEL FORMULARIO-->

    </div>
    </div>
</div>
</div>

<!--_____________________________________________________________-->

<!--//////////////////////////////Box3//////////////////////////////-->

    <!--Datatable Registrar Generadores-->
    <div class="box box-primary animated fadeInLeft">
        <div class="box-body table-scroll">
            <table id="example2" class="table table-bordered table-hover table-responsive">

            <!--Cabecera del Datatable-->
                <thead>
                    <tr>
                        <th id="Nombre" class="Nombre" style="width: 200px; font-weight: lighter;">Nombre</th>
                        <th id="Nombre" class="Nombre" style="width: 200px; font-weight: lighter;">Apellido</th>
                        <th id="Recipiente" class="Recipiente" style="width: 200px; font-weight: lighter;">DNI</th>
                        <th id="Orden" class="Orden" style="width: 200px; font-weight: lighter;">Fecha de nacimiento</th>
                    </tr>
                </thead>
​            <!--_____________________________________________________________-->

            <!--Cuerpo del Datatable-->
                <tbody>
                    <tr style="width: 200px; font-weight: lighter;">
                        <td id="Nombre" class="Nombre">Trident</td>
                        <td id="Nombre" class="Nombre">Internet Explorer 4.0</td>
                        <td id="Recipiente" class="Recipiente">Win 95+</td>
                        <td id="Orden" class="Orden">4</td>
                    </tr>
                </tbody>
​            <!--_____________________________________________________________-->

            </table>
        </div>
    </div>

<!--_____________________________________________________________-->  

</div>

<!--_____________________________________________________________-->

</form>
</div>
</div>
</div>

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