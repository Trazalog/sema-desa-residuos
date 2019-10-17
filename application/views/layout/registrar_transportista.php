<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Transportista</h3>  
        </div>
    </div>

<!--_________________________________________________-->
    
    <div class="box-body">
    <form class="formTransportistas" id="formTransportistas">
<div class="col-md-6">
    <!--Nombre / Razon social-->
    <div class="form-group">
        <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
        <input type="text" class="form-control" id="Nombre/Razon social">
    </div>
    <!--_____________________________________________-->
    <!--Descripcion-->
    <div class="form-group">
        <label for="Descripcion" name="Descripcion">Descripcion:</label>
        <input type="text" class="form-control" id="Descripcion">
    </div>
    <!--_____________________________________________-->
    <!--Direccion-->
    <div class="form-group">
        <label for="Direccion" name="Direccion">Direccion:</label>
        <input type="text" class="form-control" id="Direccion">
    </div>
    <!--_____________________________________________-->
    <!--Telefono-->
    <div class="form-group">
        <label for="Telefono" name="Telefono">Telefono:</label>
        <input type="text" class="form-control" id="Telefono">
    </div>
    <!--_____________________________________________-->
    <!--Contacto-->
        <div class="form-group">
        <label for="Contacto" name="Contacto">Contacto:</label>
        <input type="text" class="form-control" id="Contacto">
    </div>
    <!--_____________________________________________-->
</div>
<div class="col-md-6">
    <!--Resolucion-->
        <div class="form-group">
        <label for="Resolucion" name="Resolucion">Resolucion:</label>
        <input type="text" class="form-control" id="Resolucion">
    </div>
    <!--_____________________________________________-->

    <!--Registro-->
        <div class="form-group">
        <label for="Registro" name="Registro">Registro:</label>
        <input type="text" class="form-control" id="Registro">
    </div>
    <!--_____________________________________________-->
    <!--Fecha de alta-->
    <div class="form-group">
                <label for="Fechalta" name="Fecha_de_alta">Fecha de alta:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>

    <!--_____________________________________________-->
    <!--Fecha de baja-->
    <div class="form-group">
                <label for="Fechabaja" name="Fecha_de_baja">Fecha de baja:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
    <!--_____________________________________________-->
    <!--Tipo de RSU autorizado-->
    <div class="form-group">
    <label for="Rsu" name="Rsu">Tipo de RSU autorizado:</label>
        <select class="form-control select2 select2-hidden-accesible" id="Rsu">
            <option value="" disabled selected>-Seleccione opcion-</option>
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

    <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
    <!--_____________________________________________-->
</div>
    </form>
    </div>
</div>

    <br>


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
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
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

          Fecha_de_baja: {
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
      guardar();
  });
