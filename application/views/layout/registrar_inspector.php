<!-- Hecha por Jose Roberto el mas virgo -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Inspector</h3>
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
<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
    <div class="box-tittle">
        
        <!--Boton de cerrar-->
        <div class="box-tools pull-right">
                <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                    data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        <!--_____________________________________________-->
    </div>
    <div class="box-body">
        <form class="formInspectores" id="formInspectores"  method="POST" autocomplete="off" class="registerForm">
        <div class="col-md-6">
            <br>
            <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre"  style="width: 200px; font-weight: lighter;">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="nombre"  style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

            <!--Apellido-->
                <div class="form-group">
                    <label for="Apellido"  style="width: 200px; font-weight: lighter;">Apellido:</label>
                    <input type="text" class="form-control" id="Apellido" name="apellido"  style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

            <!--Direccion-->
                <div class="form-group">
                    <label for="Direccion" style="width: 200px; font-weight: lighter;">Direccion:</label>
                    <input type="text" class="form-control" id="Direccion" name="descripcion" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

            <!--Email-->
                <div class="form-group">
                    <label for="Email" style="width: 200px; font-weight: lighter;">Email:</label>
                    <input type="text" class="form-control" id="Email" name="email" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-6">

            <!--DNI-->
                <div class="form-group">
                    <label for="DNI" style="width: 200px; font-weight: lighter;">DNI:</label>
                    <input type="text" class="form-control" id="DNI" name="dni" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

            <!--Departamento-->
                <div class="form-group">
                    <label for="Departamento" style="width: 200px; font-weight: lighter;">Departamento:</label>
                    <input type="text" class="form-control" id="Departamento" name="departamento" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

            <!--Movilidad Asignada-->
                <div class="form-group">
                    <label for="MovAsignada" style="width: 200px; font-weight: lighter;">Movilidad Asignada:</label>
                    <input type="text" class="form-control" id="MovAsignada" name="movilidadasignada" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________-->

            <!--Boton de guardado-->
            <br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <!--_____________________________________________-->
        </div>
        </div>
        </div>
    </div>


<!--//////////////////////////////Box3//////////////////////////////-->
            <!--Datatable Registrar Generadores-->
            <div class="box box-primary animated fadeInLeft">
                <div class="box-body table-scroll">
                    <table id="example2" class="table table-bordered table-hover table-responsive">

                    <!--Cabecera del Datatable-->
                        <thead>
                            <tr>
                                <th id="Nombre" class="Nombre" style="width: 200px; font-weight: lighter;">Nombre</th>
                                <th id="Apellido" class="Apellido" style="width: 200px; font-weight: lighter;">Apellido</th>
                                <th id="Direccion" class="Direccion" style="width: 200px; font-weight: lighter;">Direccion</th>
                                <th id="Email" class="Email" style="width: 200px; font-weight: lighter;">Email</th>
                                <th id="DNI" class="DNI" style="width: 200px; font-weight: lighter;">DNI</th>
                                <th id="Departamento" class="Departamento" style="width: 200px; font-weight: lighter;">Departamento</th>
                                <th id="MovAsignada" class="MovAsignada" style="width: 200px; font-weight: lighter;">Movilidad Asignada</th>
                            </tr>
                        </thead>
                    <!--_____________________________________________-->

                    <!--Cuerpo del Datatable-->
                        <tbody>
                            <tr style="width: 200px; font-weight: lighter;">
                                <td id="Nombre" class="Nombre">Trident</td>
                                <td id="Apellido" class="Apellido">Internet Explorer 4.0</td>
                                <td id="Direccion" class="Direccion">Win 95+</td>
                                <td id="Email" class="Email">4</td>
                                <td id="DNI" class="DNI">X</td>
                                <td id="Departamento" class="Departamento">X</td>
                                <td id="MovAsignada" class="MovAsignada">X</td>

                            </tr>
                        </tbody>
                    <!--_____________________________________________-->

                    </table>
                </div>
            </div>
<!--_____________________________________________________________-->

</form>
    </div>
</div>
</div>

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

<!-- Script Data-Tables-->
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

<!-- Script Agregar datos de registrar_inspector-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formInspectores').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formInspectores').serialize();
    console.log(datos);
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarinspector/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formInspectores')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formInspectores')[0].reset();
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

    <!--Script Bootstrap Validacion.-->
<script>
      $('#formInspectores').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      fields: {
            nombre: {
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
            apellido: {
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
            descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            email: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            dni: {
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
            departamento: {
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
            movilidadasignada: {
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
        }
  }).on('success.form.bv', function(e){
      e.preventDefault();
      //guardar();
  });
</script>