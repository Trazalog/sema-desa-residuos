<!-- Hecha por Jose Roberto el mas vergas -->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
        <div class="box-tittle">
            <h3>Proceso Productivo</h3> 
        </div>
    </div>

    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formProcesoProductivo" id="formProcesoProductivo">
            <div class="col-md-12">

                <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre">
                </div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-5">

                <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre">
                </div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-5">

                <!--Recipiente-->
                <div class="form-group">
                    <label for="Recipiente">Recipiente:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Recipiente" name="Recipiente">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Recipiente as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-1">

                <!--Orden-->
                <div class="form-group">
                    <label for="Orden">Orden:</label>
                    <input type="text" class="form-control" id="Orden" name="Orden">
                </div>
                <!--_____________________________________________-->
                
            </div>
            <div class="col-md-12">

                <!--Boton de guardado-->
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Agregar</button>
                <!--_____________________________________________-->
            </div>

        </form>
    </div>
</div>


<div class="box box-primary animated fadeInLeft">
    <div class="box-header">
    </div>

    <!--Tabla de informacion de proceso productivo-->
        
    <section class="content">
            <div class="row">
                <em class="fas fa-ad"></em>
            </div>

        </section>

    <!--_____________________________________________________________-->
    
</div>


<!--_____________________________________________________________-->

<!-- Script Agregar datos de proceso_productivo-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formProcesoProductivo').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formProcesoProductivo').serialize();
    console.log(datos);
    
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Procesoproductivo/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formProcesoProductivo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formProcesoProductivo')[0].reset();
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
<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.-->
<script>
      $('#formProcesoProductivo').bootstrapValidator({
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
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          Etapaproceso: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
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
<!--_____________________________________________________________-->