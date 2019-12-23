<!-- Hecha por Jose Roberto el mas virgo -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Generadores</h3>
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

        <!--Boton de cerrar-->
            <div class="box-tools pull-right">
                <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                    data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        <!--_____________________________________________-->
    <div class="box-body">
        <form class="formInspectores" id="formInspectores"  method="POST" autocomplete="off" class="registerForm">

            <!--Nombre / Razon social-->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Nombre/Razon social" style="width: 200px; font-weight: lighter;">Nombre / Razon social:</label>
                <input type="text" class="form-control" id="Nombre/Razon social" name="Nombre_razon" style="width: 200px; font-weight: lighter;">
            </div>
            <!--_____________________________________________-->

            <!--CUIT-->
            <div class="form-group">
                <label for="CUIT" style="width: 200px; font-weight: lighter;">CUIT:</label>
                <input type="text" class="form-control" id="CUIT" name="Cuit" style="width: 200px; font-weight: lighter;">
            </div>
            <!--_____________________________________________-->

            <!--Zona-->
            <div class="form-group">
                <label for="Zonag" style="width: 200px; font-weight: lighter;">Zona:</label>
                <select class="form-control select2 select2-hidden-accesible" id="Zonag" name="Zona" style="width: 200px; font-weight: lighter;">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                    foreach ($Zonag as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                    ?>
                </select>
            </div>
            <!--_____________________________________________-->

            <!--Rubro-->
            <div class="form-group">
                <label for="Rubro" style="width: 200px; font-weight: lighter;">Rubro:</label>
                <input type="text" class="form-control" id="Rubro" name="Rubro" style="width: 200px; font-weight: lighter;">
            </div>
            <!--_____________________________________________-->

            <!--Tipo-->  
            <div class="form-group">
                <label for="TipoG" style="width: 200px; font-weight: lighter;">Tipo:</label>
                <select class="form-control select2 select2-hidden-accesible" id="TipoG" name="Tipo" style="width: 200px; font-weight: lighter;">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                    foreach ($TipoG as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
            <!--_____________________________________________-->

            <!--Domicilio-->
        <div class="col-md-6">
            <div class="form-group">
                <label for="Domicilio" style="width: 200px; font-weight: lighter;">Domicilio:</label>
                <input type="text" class="form-control" id="Domicilio" name="Domicilio" style="width: 200px; font-weight: lighter;">
            </div>
            <!--_____________________________________________-->

            <!--Departamento-->
            <div class="form-group">
                <label for="Dpto" style="width: 200px; font-weight: lighter;">Departamento:</label>
                <select class="form-control select2 select2-hidden-accesible" id="Dpto" name="Departamento" style="width: 200px; font-weight: lighter;">
                    <option value="" disabled selected>-Seleccione opcion-</option>
                    <?php
                    foreach ($Dpto as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                    ?>
                </select>
            </div>
            <!--_____________________________________________-->

            <!--Numero de registro-->
            <div class="form-group">
                <label for="Numero de registro" style="width: 200px; font-weight: lighter;">Numero de registro:</label>
                <input type="text" class="form-control" id="Numero de registro" name="Numero_registro" style="width: 200px; font-weight: lighter;">
            </div>
            <!--_____________________________________________-->

            <!--Tipo de residuos-->
            <div class="form-group">
                <label for="Tipo de residuos" style="width: 200px; font-weight: lighter;">Tipo de residuos:</label>
                <input type="text" class="form-control" id="Tipo de residuos" name="Tipo_Residuo" style="width: 200px; font-weight: lighter;">
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
<!--_____________________________________________________________-->

<!--//////////////////////////////Box3//////////////////////////////-->
            <!--Datatable Registrar Generadores-->
            <div class="box box-primary animated fadeInLeft">
                <div class="box-body table-scroll">
                    <table id="example2" class="table table-bordered table-hover table-responsive">

                    <!--Cabecera del Datatable-->
                        <thead>
                            <tr>
                                <th id="Nombre_razon" class="Nombre_razon" style="width: 200px; font-weight: lighter;">Nombre / Razon social</th>
                                <th id="Cuit" class="Cuit" style="width: 200px; font-weight: lighter;">CUIT</th>
                                <th id="Zona" class="Zona" style="width: 200px; font-weight: lighter;">Zona</th>
                                <th id="Rubro" class="Rubro" style="width: 200px; font-weight: lighter;">Rubro</th>
                                <th id="Tipo" class="Tipo" style="width: 200px; font-weight: lighter;">Tipo</th>
                                <th id="Domicilio" class="Domicilio" style="width: 200px; font-weight: lighter;">Domicilio</th>
                                <th id="Departamento" class="Departamento" style="width: 200px; font-weight: lighter;">Departamento</th>
                                <th id="Numero_registro" class="Numero_registro" style="width: 200px; font-weight: lighter;">Numero de registro</th>
                                <th id="Tipo_Residuo" class="Tipo_Residuo" style="width: 200px; font-weight: lighter;">Tipo de residuos</th>
                            </tr>
                        </thead>
                    <!--_____________________________________________-->

                    <!--Cuerpo del Datatable-->
                        <tbody>
                            <tr style="width: 200px; font-weight: lighter;">
                                <td id="Nombre_razon" class="Nombre_razon">Trident</td>
                                <td id="Cuit" class="Cuit">Internet Explorer 4.0</td>
                                <td id="Zona" class="Zona">Win 95+</td>
                                <td id="Rubro" class="Rubro">4</td>
                                <td id="Tipo" class="Tipo">X</td>
                                <td id="Domicilio" class="Domicilio">X</td>
                                <td id="Departamento" class="Departamento">X</td>
                                <td id="Numero_registro" class="Numero_registro">X</td>
                                <td id="Tipo_Residuo" class="Tipo_Residuo">X</td>
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

<!-- Script Agregar datos de registrar_generadores-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formGeneradores').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formGeneradores').serialize();
    console.log(datos);
        //--------------------------------------------------------------
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrargenerador/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formGeneradores')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formGeneradores')[0].reset();
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
  $('#formGeneradores').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      //excluded: ':disabled',
      fields: {
        Nombre_razon: {
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
          Cuit: {
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
          Zona: {
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
          Rubro: {
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
          Tipo: {
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
          Domicilio: {
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
          Departamento: {
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
          Numero_registro: {
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
          Tipo_Residuo: {
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
          }
      }
  }).on('success.form.bv', function (e) {
      e.preventDefault();
      //guardar();
  });
</script>
<!--_____________________________________________-->