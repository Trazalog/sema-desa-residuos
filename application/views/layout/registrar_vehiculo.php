<!-- Hecha por Jose Roberto el mas vergas -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Vehiculo</h3>
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
        <div class="box-tittle">
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
    <form class="formVehiculo" id="formVehiculo"  method="POST" autocomplete="off" class="registerForm">

    <div class="col-md-6">

        <!--COMIENZO DE LOS CAMPOS DEL FORMULARIO-->

            <!--Descripcion-->
            <div class="form-group">
                    <label for="Descripcion"  style="width: 200px; font-weight: lighter;">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion" name="descripcion"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Dominio-->
            <div class="form-group">
                    <label for="Dominio"  style="width: 200px; font-weight: lighter;">Dominio:</label>
                    <input type="text" class="form-control" id="Dominio" name="dominio"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Marca-->
            <div class="form-group">
                    <label for="Marca"  style="width: 200px; font-weight: lighter;">Marca:</label>
                    <input type="text" class="form-control" id="Marca" name="marca"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Condicion-->
            <div class="form-group">
                <label for="condicion" style="width: 200px; font-weight: lighter;">Condicion:</label>
                <select class="form-control select2 select2-hidden-accesible" id="condicion" name="condicion" style="width: 200px; font-weight: lighter;">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                    foreach ($condicion as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                    ?>
                </select>
            </div>
​            <!--_____________________________________________________________-->

            <!--Modelo-->
            <div class="form-group">
                    <label for="Modelo"  style="width: 200px; font-weight: lighter;">Modelo:</label>
                    <input type="text" class="form-control" id="Modelo" name="modelo"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

    </div>
    <div class="col-md-6">

            <!--Capacidad-->
            <div class="form-group">
                    <label for="Capacidad"  style="width: 200px; font-weight: lighter;">Capacidad:</label>
                    <input type="text" class="form-control" id="Capacidad" name="capacidad"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Tara-->
            <div class="form-group">
                    <label for="Tara"  style="width: 200px; font-weight: lighter;">Tara:</label>
                    <input type="text" class="form-control" id="Tara" name="tara"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->    

            <!--Habilitacion-->
            <div class="form-group">
                    <label for="Habilitacion"  style="width: 200px; font-weight: lighter;">Habilitacion:</label>
                    <input type="text" class="form-control" id="Habilitacion" name="habilitacion"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->    

            <!--Registro-->
            <div class="form-group">
                    <label for="Registro"  style="width: 200px; font-weight: lighter;">Registro:</label>
                    <input type="text" class="form-control" id="Registro" name="registro"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________--> 

            <!--Fecha de habilitacion-->
            <div class="form-group" style="width: 200px; font-weight: lighter;">
                <label for="Fechahabilitacion" style="width: 200px; font-weight: lighter;">Fecha de habilitacion:</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="fechahabilitacion">
                </div>
                <!-- /.input group -->
            </div>
​            <!--_____________________________________________________________-->

            <!--Adjuntador de imagenes-->
            <form action="cargar_archivo" method="post" enctype="multipart/form-data" style="width: 200px; font-weight: lighter;">
                <input  type="file"  id="imgarch" name="upload" data-required="true">
            </form>
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
                        <th id="Descripcion" class="Descripcion" style="width: 200px; font-weight: lighter;">Descripcion</th>
                        <th id="Dominio" class="Dominio" style="width: 200px; font-weight: lighter;">Dominio</th>
                        <th id="Marca" class="Marca" style="width: 200px; font-weight: lighter;">Marca</th>
                        <th id="Condicion" class="Condicion" style="width: 200px; font-weight: lighter;">Condicion</th>
                        <th id="Modelo" class="Modelo" style="width: 200px; font-weight: lighter;">Modelo</th>
                        <th id="Capacidad" class="Capacidad" style="width: 200px; font-weight: lighter;">Capacidad</th>
                        <th id="Tara" class="Tara" style="width: 200px; font-weight: lighter;">Tara</th>
                        <th id="Habilitacion" class="Habilitacion" style="width: 200px; font-weight: lighter;">Habilitacion</th>
                        <th id="Registro" class="Registro" style="width: 200px; font-weight: lighter;">Registro</th>
                        <th id="Fechahabilitacion" class="Fechahabilitacion" style="width: 200px; font-weight: lighter;">Fecha de Habilitacion</th>
                    </tr>
                </thead>
​            <!--_____________________________________________________________-->

            <!--Cuerpo del Datatable-->
                <tbody>
                    <tr style="width: 200px; font-weight: lighter;">
                        <td id="Descripcion" class="Descripcion">Trident</td>
                        <td id="Dominio" class="Dominio">Internet Explorer 4.0</td>
                        <td id="Marca" class="Marca">Win 95+</td>
                        <td id="Condicion" class="Condicion">4</td>
                        <td id="Modelo" class="Modelo">X</td>
                        <td id="Capacidad" class="Capacidad">X</td>
                        <td id="Tara" class="Tara">X</td>
                        <td id="Habilitacion" class="Habilitacion">X</td>
                        <td id="Registro" class="Registro">X</td>
                        <td id="Fechahabilitacion" class="Fechahabilitacion">X</td>
                    </tr>
                </tbody>
​            <!--_____________________________________________________________-->
            </table>
        </div>
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
    $('#formVehiculo').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formVehiculo').serialize();
    console.log(datos);
        //--------------------------------------------------------------
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarchofer/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formVehiculo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formVehiculo')[0].reset();
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
​<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.-->
<script>
  $('#formVehiculo').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      //excluded: ':disabled',
      fields: {
          descripcion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          dominio: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          marca: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          condicion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
              }
          },
          modelo: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          capacidad: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          tara: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          habilitacion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          registro: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
              }
          },
          fechahabilitacion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          }
      }
  }).on('success.form.bv', function (e) {
      e.preventDefault();
      //guardar();
  });
</script>
​<!--_____________________________________________________________-->