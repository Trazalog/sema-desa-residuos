<div class="box box-primary">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Registrar Inspector</h3>
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
        <form class="formInspectores" id="formInspectores">
        <div class="col-md-6">
            <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre" name="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre">
                </div>
            <!--_____________________________________________-->
            <!--Apellido-->
                <div class="form-group">
                    <label for="Apellido" name="apellido">Apellido:</label>
                    <input type="text" class="form-control" id="Apellido">
                </div>
            <!--_____________________________________________-->
            <!--Direccion-->
                <div class="form-group">
                    <label for="Direccion" name="descripcion">Direccion:</label>
                    <input type="text" class="form-control" id="Direccion">
                </div>
            <!--_____________________________________________-->
            <!--Email-->
                <div class="form-group">
                    <label for="Email" name="email">Email:</label>
                    <input type="text" class="form-control" id="Email">
                </div>
            <!--_____________________________________________-->
        </div>
        <div class="col-md-6">
            <!--DNI-->
                <div class="form-group">
                    <label for="DNI" name="dni">DNI:</label>
                    <input type="text" class="form-control" id="DNI">
                </div>
            <!--_____________________________________________-->
            <!--Departamento-->
                <div class="form-group">
                    <label for="Departamento" name="departamento">Departamento:</label>
                    <input type="text" class="form-control" id="Departamento">
                </div>
            <!--_____________________________________________-->
            <!--Movilidad Asignada-->
                <div class="form-group">
                    <label for="MovAsignada" name="movilidadasignada">Movilidad Asignada:</label>
                    <input type="text" class="form-control" id="MovAsignada">
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
                    regexp: {
                        regexp: /[A-Za-z]/,
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
            email: {
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
                        message: 'la entrada debe ser un numero entero'
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
                        message: 'la entrada debe ser un numero entero'
                    }
                }
            },
        }
  }).on('success.form.bv', function(e){
      e.preventDefault();
      guardar();
  });

</script>