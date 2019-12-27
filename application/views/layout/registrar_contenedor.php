<!-- Hecha por Jose Roberto el mas vergas -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Contenedor</h3>
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
        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">
        <div class="col-md-6">

            <!--Codigo / Registro-->
                <div class="form-group">
                    <label for="Codigo/Registro" style="width: 200px; font-weight: lighter;">Codigo / Registro:</label>
                    <input type="text" class="form-control" id="Codigo/Registro" name="Codigo_registro" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________________________-->

            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" style="width: 200px; font-weight: lighter;">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion" name="Descripcion" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________________________-->

            <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad" style="width: 200px; font-weight: lighter;">Capacidad:</label>
                    <input type="text" class="form-control" id="Capacidad" name="Capacidad" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________________________-->

            <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab" style="width: 200px; font-weight: lighter;">Año de elaboracion:</label>
                    <input type="text" class="form-control" id="Añoelab" name="Añoelab" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________________________-->

        </div>
        <div class="col-md-6">

            <!--Tara-->
                <div class="form-group">
                    <label for="Tara" style="width: 200px; font-weight: lighter;">Tara:</label>
                    <input type="text" class="form-control" id="Tara" name="Tara" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________________________-->

            <!--Estado-->
                <div class="form-group">
                    <label for="Estados" style="width: 200px; font-weight: lighter;">Estado:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Estados" name="Estados" style="width: 200px; font-weight: lighter;">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estados as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________________________-->

            <!--Habilitacion-->
                <div class="form-group">
                    <label for="Habilitacion" style="width: 200px; font-weight: lighter;">Habilitacion:</label>
                    <input type="text" class="form-control" id="Habilitacion" name="Habilitacion" style="width: 200px; font-weight: lighter;">
                </div>
            <!--_____________________________________________________________-->

            <!--Boton de guardado-->
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <!--_____________________________________________________________-->
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
                        <th id="Codigo_registro" class="Codigo_registro" style="width: 200px; font-weight: lighter;">Codigo Registro</th>
                        <th id="Descripcion" class="Descripcion" style="width: 200px; font-weight: lighter;">Descripcion</th>
                        <th id="Capacidad" class="Capacidad" style="width: 200px; font-weight: lighter;">Capacidad</th>
                        <th id="Añoelab" class="Añoelab" style="width: 200px; font-weight: lighter;">Año de elaboracion</th>
                        <th id="Tara" class="Tara" style="width: 200px; font-weight: lighter;">Tara</th>
                        <th id="Estados" class="Estados" style="width: 200px; font-weight: lighter;">Estados</th>
                        <th id="Habilitacion" class="Habilitacion" style="width: 200px; font-weight: lighter;">Habilitacion</th>
                    </tr>
                </thead>
​            <!--_____________________________________________________________-->

            <!--Cuerpo del Datatable-->
                <tbody>
                    <tr style="width: 200px; font-weight: lighter;">
                        <td id="Codigo_registro" class="Codigo_registro">Trident</td>
                        <td id="Descripcion" class="Descripcion">Internet Explorer 4.0</td>
                        <td id="Capacidad" class="Capacidad">Win 95+</td>
                        <td id="Añoelab" class="Añoelab">4</td>
                        <td id="Tara" class="Tara">X</td>
                        <td id="Estados" class="Estados">X</td>
                        <td id="Habilitacion" class="Habilitacion">X</td>
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

<!-- Script Agregar datos de registrar_generadores-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formContenedores').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formContenedores').serialize();
    console.log(datos);
        //--------------------------------------------------------------
        
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarcontenedor/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formContenedores')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
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

<!--Script Bootstrap Validacion.-->
<script>
  $('#formContenedores').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      //excluded: ':disabled',
      fields: {
        Codigo_registro: {
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
              }
          },
        Capacidad: {
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
        Añoelab: {
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
        Tara: {
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
        Estados: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
        Habilitacion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
      }
  }).on('success.form.bv', function(e){
      e.preventDefault();
      //guardar();
  });
</script>
<!--_____________________________________________________________-->