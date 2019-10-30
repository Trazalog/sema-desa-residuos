<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Establecimiento</h3>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formEstablecimiento" id="formEstablecimiento">
        
        <div class="col-md-6">

            <!--Nombre-->
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre">
            </div>
            <!--_____________________________________________-->

            <!--Ubicacion-->
            <div class="form-group">
                <label for="Ubicacion">Ubicacion:</label>
                <br>
                <div class="col-md-6">
                <input type="text" class="form-control" id="Ubicacion" name="Ubicacion">
                </div>
                <div class="col-md-6">
                <input type="text" class="form-control" id="Ubicacion" name="Ubicacion">
                </div>
            </div>
            <!--_____________________________________________-->

            <!--Pais-->
            <br><br>
            <div class="form-group">
                <label for="Pais">Pais:</label>
                <input type="text" class="form-control" id="Pais" name="Pais">
            </div>
            <!--_____________________________________________-->

            <!--Fecha de alta-->
            <div class="form-group">
                <label for="Fechalta">Fecha de alta:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="Fecha_de_alta">
                </div>
                <!-- /.input group -->
            </div>
            <!--_____________________________________________-->

            <!--Usuario-->
            <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="Usuario">
            </div>
            <!--_____________________________________________-->

        </div>
        <div class="col-md-6">

            <!--Calles-->
            <div class="form-group">
                <label for="Calles">Calles:</label>
                <input type="text" class="form-control" id="Calles" name="Calles">
            </div>
            <!--_____________________________________________-->

            <!--Altura-->
            <div class="form-group">
                <label for="Altura">Altura:</label>
                <input type="text" class="form-control" id="Altura" name="Altura">
            </div>
            <!--_____________________________________________-->

            <!--Localidad-->
            <div class="form-group">
                <label for="Localidad">Localidad:</label>
                <input type="text" class="form-control" id="Localidad" name="Localidad">
            </div>
            <!--_____________________________________________-->

            <!--Estado-->
            <div class="form-group">
                <label for="Estado">Estado:</label>
                <input type="text" class="form-control" id="Estado" name="Estado">
            </div>
            <!--_____________________________________________-->

        </div>
        
            <!--Boton de guardado-->
            <br><br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
            <!--_____________________________________________-->
        
        </form>
    </div>
</div>

<!-- Script Agregar datos de registrar_inspector-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formEstablecimiento').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formEstablecimiento').serialize();
    console.log(datos);
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarinspector/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formEstablecimiento')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formEstablecimiento')[0].reset();
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
      $('#formEstablecimiento').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      fields: {
            Nombre: {
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
            Ubicacion: {
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
            Pais: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
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
            Usuario: {
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
            Calles: {
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
            Altura: {
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
            Localidad: {
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
            Estado: {
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
      //guardar();
  });
</script>