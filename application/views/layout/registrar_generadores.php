<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Generadores</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
        <form class="formGeneradores" id="formGeneradores">
            
            <div class="col-md-6">
                <!--Nombre / Razon social-->
                <div class="form-group">
                    <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                    <input type="text" class="form-control" id="Nombre/Razon social">
                </div>
                <!--_____________________________________________-->
                <!--CUIT-->
                <div class="form-group">
                    <label for="CUIT" name="Cuit">CUIT:</label>
                    <input type="text" class="form-control" id="CUIT">
                </div>
                <!--_____________________________________________-->
                <!--Zona-->
                <div class="form-group">
                    <label for="Zonag" name="Zona">Zona:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Zonag">
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
                    <label for="Rubro" name="Rubro">Rubro:</label>
                    <input type="text" class="form-control" id="Rubro">
                </div>
                <!--_____________________________________________-->
                <!--Tipo-->  
                <div class="form-group">
                    <label for="TipoG" name="Tipo">Tipo:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="TipoG">
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
                    <label for="Domicilio" name="Domicilio">Domicilio:</label>
                    <input type="text" class="form-control" id="Domicilio">
                </div>
                <!--_____________________________________________-->
                <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto" name="Departamento">Departamento:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Dpto">
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
                    <label for="Numero de registro" name="Numero_registro">Numero de registro:</label>
                    <input type="text" class="form-control" id="Numero de registro">
                </div>
                <!--_____________________________________________-->
                <!--Tipo de residuos-->
                <div class="form-group">
                    <label for="Tipo de residuos" name="Tipo_Residuo">Tipo de residuos:</label>
                    <input type="text" class="form-control" id="Tipo de residuos">
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
</div>

<!--_____________________________________________________________-->
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
      fields: {
        Nombre_razon: {
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

          Cuit: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                  regexp: {
                      regexp: /[0-9]*/,
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
              }
          },

          Rubro: {
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

          Tipo: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
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

          Departamento: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
              }
          },

          Numero_registro: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                  regexp: {
                      regexp: /[0-9]*/,
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
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          }
      }
  }).on('success.form.bv', function(e){
      e.preventDefault();
      guardar();
  });

</script>