<!-- Hecha por Jose Roberto el mas virgo -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Transportista</h3>
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

<div class="box box-primary animated fadeInLeft" id="boxDatos" hidden>
    <div class="box-body">
    <form class="formTransportistas" id="formTransportistas">

        <!--Boton de cerrar-->
        <div class="box-tools pull-right">
                <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                    data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        <!--_____________________________________________-->

<div class="col-md-6">
<br>
    <!--Nombre / Razon social-->
    <div class="form-group">
        <label for="Nombre/Razon social" style="width: 200px; font-weight: lighter;">Nombre / Razon social:</label>
        <input type="text" class="form-control" id="Nombre/Razon social" name="Nombre_razon" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

    <!--Descripcion-->
    <div class="form-group">
        <label for="Descripcion" style="width: 200px; font-weight: lighter;">Descripcion:</label>
        <input type="text" class="form-control" id="Descripcion" name="Descripcion" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

    <!--Direccion-->
    <div class="form-group">
        <label for="Direccion" style="width: 200px; font-weight: lighter;">Direccion:</label>
        <input type="text" class="form-control" id="Direccion" name="Direccion" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

    <!--Telefono-->
    <div class="form-group">
        <label for="Telefono" style="width: 200px; font-weight: lighter;">Telefono:</label>
        <input type="text" class="form-control" id="Telefono" name="Telefono" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

    <!--Contacto-->
        <div class="form-group">
        <label for="Contacto" style="width: 200px; font-weight: lighter;">Contacto:</label>
        <input type="text" class="form-control" id="Contacto" name="Contacto" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

</div>
<div class="col-md-6">

    <!--Resolucion-->
        <div class="form-group">
        <label for="Resolucion" style="width: 200px; font-weight: lighter;">Resolucion:</label>
        <input type="text" class="form-control" id="Resolucion" name="Resolucion" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

    <!--Registro-->
        <div class="form-group">
        <label for="Registro" style="width: 200px; font-weight: lighter;">Registro:</label>
        <input type="text" class="form-control" id="Registro" name="Registro" style="width: 200px; font-weight: lighter;">
    </div>
    <!--_____________________________________________-->

    <!--Fecha de alta-->
    <div class="form-group" style="width: 200px; font-weight: lighter;">
                <label for="Fechalta" style="width: 200px; font-weight: lighter;">Fecha de alta:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="Fecha_de_alta" >
                </div>
                <!-- /.input group -->
              </div>
    <!--_____________________________________________-->

    <!--Fecha de baja-->
    <div class="form-group" style="width: 200px; font-weight: lighter;">
                <label for="Fechabaja" style="width: 200px; font-weight: lighter;">Fecha de baja:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="Fecha_de_baja" >
                </div>
                <!-- /.input group -->
              </div>
    <!--_____________________________________________-->

    <!--Tipo de RSU autorizado-->
    <div class="form-group">
    <label for="Rsu" style="width: 200px; font-weight: lighter;">Tipo de RSU autorizado:</label>
        <select class="form-control select2 select2-hidden-accesible" id="Rsu" name="Rsu" style="width: 200px; font-weight: lighter;">
            <option value="" disabled selected style="width: 200px; font-weight: lighter;">-Seleccione opcion-</option>
                <?php
                    foreach ($Rsu as $i) {
                        echo '<option>'.$i->nombre.'</option>';
                    }
                ?>
        </select>
    </div>
    <!--_____________________________________________-->

    <!--Boton de guardado-->
    <br>
    <button type="submit" class="btn btn-primary pull-right" style="width: 200px; font-weight: lighter;" onclick="agregarDato()">Guardar</button>
    <!--_____________________________________________-->

</div>
    </form>
    </div>
</div>
</div>
    <br>

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
​<!--_____________________________________________________________-->


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

<!-- Script Agregar datos de registrar_transportista-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formTransportistas').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formTransportistas').serialize();
    console.log(datos);
        //--------------------------------------------------------------
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrartransportista/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formTransportistas')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formTransportistas')[0].reset();
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
  $('#formTransportistas').bootstrapValidator({
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
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          Direccion: {
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
          Telefono: {
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
          Contacto: {
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
          Domicilio: {
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
          Resolucion: {
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
          Registro: {
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
          Fecha_de_alta: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
          Fecha_de_baja: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
          Rsu: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          }
      }
   }).on('success.form.bv', function(e){
      e.preventDefault();
      //guardar();
  });
</script>
<!--_____________________________________________-->