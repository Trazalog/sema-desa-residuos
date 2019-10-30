<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Etapa</h3>
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formEtapa" id="formEtapa">
        
        <div class="col-md-6">
    
            <!--Nombre-->
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre">
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

        </div>
        <div class="col-md-6">
        
            <!--Nombre Recipiente-->
            <div class="form-group">
                <label for="NombreRecipiente">Nombre Recipiente:</label>
                <input type="text" class="form-control" id="NombreRecipiente" name="NombreRecipiente">
            </div>
            <!--_____________________________________________-->
                    
            <!--Usuario-->
            <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="Usuario">
            </div>
            <!--_____________________________________________-->
        
            <!--Boton de guardado-->
            <hr>
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
    $('#formEtapa').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formEtapa').serialize();
    console.log(datos);
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarinspector/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formEtapa')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formEtapa')[0].reset();
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
      $('#formEtapa').bootstrapValidator({
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
            datepicker: {
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
            NombreRecipiente: {
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
            Usuario: {
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
            }
        }
}).on('success.form.bv', function(e){
    e.preventDefault();
    //guardar();
});
</script>