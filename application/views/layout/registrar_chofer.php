<!-- Hecha por Jose Roberto el mas vergas -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Chofer</h3>
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
    <form class="formChofer" id="formChofer"  method="POST" autocomplete="off" class="registerForm">

    <div class="col-md-6">

        <!--COMIENZO DE LOS CAMPOS DEL FORMULARIO-->
            <!--Nombre-->
            <div class="form-group">
                    <label for="Nombre"  style="width: 200px; font-weight: lighter;">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="nombre"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Apellido-->
            <div class="form-group">
                    <label for="Apellido"  style="width: 200px; font-weight: lighter;">Apellido:</label>
                    <input type="text" class="form-control" id="Apellido" name="apellido"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--DNI-->
            <div class="form-group">
                    <label for="DNI"  style="width: 200px; font-weight: lighter;">DNI:</label>
                    <input type="text" class="form-control" id="DNI" name="dni"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Fecha de nacimiento-->
            <div class="form-group">
                    <label for="FechaNacimiento"  style="width: 200px; font-weight: lighter;">Fecha de nacimiento:</label>
                    <input type="text" class="form-control" id="FechaNacimiento" name="fecha_nacimiento"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Direccion-->
            <div class="form-group">
                    <label for="Direccion"  style="width: 200px; font-weight: lighter;">Direccion:</label>
                    <input type="text" class="form-control" id="Direccion" name="direccion"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Celular-->
            <div class="form-group">
                    <label for="Celular"  style="width: 200px; font-weight: lighter;">Celular:</label>
                    <input type="text" class="form-control" id="Celular" name="celular"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Codigo-->
            <div class="form-group">
                    <label for="Codigo"  style="width: 200px; font-weight: lighter;">Codigo:</label>
                    <input type="text" class="form-control" id="Codigo" name="codigo"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

        </div>
        <div class="col-md-6">

            <!--Empresa-->
            <div class="form-group">
                    <label for="Empresa"  style="width: 200px; font-weight: lighter;">Empresa:</label>
                    <input type="text" class="form-control" id="Empresa" name="empresa"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Carnet-->
            <div class="form-group">
                <label for="carnet" style="width: 200px; font-weight: lighter;">Carnet:</label>
                <select class="form-control select2 select2-hidden-accesible" id="carnet" name="carnet" style="width: 200px; font-weight: lighter;">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                    foreach ($carnet as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                    ?>
                </select>
            </div>
​            <!--_____________________________________________________________-->

            <!--Categoria-->
            <div class="form-group">
                    <label for="Categoria"  style="width: 200px; font-weight: lighter;">Categoria:</label>
                    <input type="text" class="form-control" id="Categoria" name="categoria"  style="width: 200px; font-weight: lighter;">
            </div>
​            <!--_____________________________________________________________-->

            <!--Vencimiento-->
            <div class="form-group" style="width: 200px; font-weight: lighter;">
                <label for="Vencimiento" style="width: 200px; font-weight: lighter;">Vencimiento:</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="vencimiento">
                </div>
                <!-- /.input group -->
            </div>
​            <!--_____________________________________________________________-->

            <!--Habilitacion-->
            <div class="form-group">
                    <label for="Habilitacion"  style="width: 200px; font-weight: lighter;">Habilitacion:</label>
                    <input type="text" class="form-control" id="Habilitacion" name="habilitacion"  style="width: 200px; font-weight: lighter;">
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
                        <th id="Apellido" class="Apellido" style="width: 200px; font-weight: lighter;">Apellido</th>
                        <th id="DNI" class="DNI" style="width: 200px; font-weight: lighter;">DNI</th>
                        <th id="FechaNacimiento" class="FechaNacimiento" style="width: 200px; font-weight: lighter;">Fecha de nacimiento</th>
                        <th id="Direccion" class="Direccion" style="width: 200px; font-weight: lighter;">Direccion</th>
                        <th id="Celular" class="Celular" style="width: 200px; font-weight: lighter;">Celular</th>
                        <th id="Codigo" class="Codigo" style="width: 200px; font-weight: lighter;">Codigo</th>
                        <th id="Empresa" class="Empresa" style="width: 200px; font-weight: lighter;">Empresa</th>
                        <th id="Carnet" class="Carnet" style="width: 200px; font-weight: lighter;">Carnet</th>
                        <th id="Categoria" class="Categoria" style="width: 200px; font-weight: lighter;">Categoria</th>
                        <th id="Vencimiento" class="Vencimiento" style="width: 200px; font-weight: lighter;">Vencimiento</th>
                        <th id="Habilitacion" class="Habilitacion" style="width: 200px; font-weight: lighter;">Habilitacion</th>
                    </tr>
                </thead>
​            <!--_____________________________________________________________-->

            <!--Cuerpo del Datatable-->
                <tbody>
                    <tr style="width: 200px; font-weight: lighter;">
                        <td id="Nombre" class="Nombre">Trident</td>
                        <td id="Apellido" class="Apellido">Internet Explorer 4.0</td>
                        <td id="DNI" class="DNI">Win 95+</td>
                        <td id="FechaNacimiento" class="FechaNacimiento">4</td>
                        <td id="Direccion" class="Direccion">X</td>
                        <td id="Celular" class="Celular">X</td>
                        <td id="Codigo" class="Codigo">X</td>
                        <td id="Empresa" class="Empresa">X</td>
                        <td id="Carnet" class="Carnet">X</td>
                        <td id="Categoria" class="Categoria">X</td>
                        <td id="Categoria" class="Categoria">X</td>
                        <td id="Habilitacion" class="Habilitacion">X</td>
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
    $('#formChofer').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formChofer').serialize();
    console.log(datos);
        //--------------------------------------------------------------
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarchofer/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formChofer')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formChofer')[0].reset();
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
  $('#formChofer').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      //excluded: ':disabled',
      fields: {
        nombre: {
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
          apellido: {
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
          dni: {
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
                      message: 'la entrada debe ser un numero entero'
                  }
              }
          },
          fecha_nacimiento: {
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
                      message: 'la entrada debe ser un numero entero'
                  }
              }
          },
          direccion: {
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
          celular: {
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
          codigo: {
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
          empresa: {
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
          carnet: {
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
          categoria: {
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
          vencimiento: {
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
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
      }
  }).on('success.form.bv', function (e) {
      e.preventDefault();
      //guardar();
  });
</script>
​<!--_____________________________________________________________-->