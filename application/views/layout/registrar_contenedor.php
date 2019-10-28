<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
           <h3>Registrar Contenedor</h3>  
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formContenedores" id="formContenedores">
        <div class="col-md-6">

            <!--Codigo / Registro-->
                <div class="form-group">
                    <label for="Codigo/Registro">Codigo / Registro:</label>
                    <input type="text" class="form-control" id="Codigo/Registro" name="Codigo_registro">
                </div>
            <!--_____________________________________________-->

            <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion" name="Descripcion">
                </div>
            <!--_____________________________________________-->

            <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad">Capacidad:</label>
                    <input type="text" class="form-control" id="Capacidad" name="Capacidad">
                </div>
            <!--_____________________________________________-->

            <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab">Año de elaboracion:</label>
                    <input type="text" class="form-control" id="Añoelab" name="Añoelab">
                </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-6">

            <!--Tara-->
                <div class="form-group">
                    <label for="Tara">Tara:</label>
                    <input type="text" class="form-control" id="Tara" name="Tara">
                </div>
            <!--_____________________________________________-->

            <!--Estado-->
                <div class="form-group">
                    <label for="Estados">Estado:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Estados" name="Estados">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estados as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
            <!--_____________________________________________-->

            <!--Habilitacion-->
                <div class="form-group">
                    <label for="Habilitacion">Habilitacion:</label>
                    <input type="text" class="form-control" id="Habilitacion" name="Habilitacion">
                </div>
            <!--_____________________________________________-->

            <!--Boton de guardado-->
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <!--_____________________________________________-->

        </div>
        </form>
    </div>
</div>

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
                url:"ajax/Registrargenerador/guardarDato",
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