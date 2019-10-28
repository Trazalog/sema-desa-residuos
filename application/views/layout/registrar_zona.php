<div class="box box-primary">
    <div class="box-header  with-border">
        <div class="box-tittle">
            <h3>Registrar Zona</h3>  
        </div>
    </div>
    <!--_____________________________________________-->
    <div class="box-body">
        <form class="formZonas" id="formZonas">
            <div class="col-md-6">
                <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre" name="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre">
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
                <!--Circuito / Recorrido-->
                <div class="form-group">
                    <label for="CircR" name="Circuito_Recorrido">Circuito / Recorrido:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="CircR">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($CircR as $i) {
                            echo '<option>'.$i->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!--_____________________________________________-->
                <!--Adjuntador de imagenes-->
                <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                    <input  type="file" name="upload">
                </form>
                <!--_____________________________________________-->
    </div>
    <div class="box-body">
            <div class="col-md-6">
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion">
                </div>
                <!--_____________________________________________-->
                <!--Boton de guardado-->
                <br>
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
                <!--_____________________________________________-->
            </div>
            </div>
        </form>
    </div>
</div>


<!--_____________________________________________________________-->
<!-- Script Agregar datos de registrar_zona-->

<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formZonas').on('submit', function(e){

    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);

    datos=$('#formZonas').serialize();
    console.log(datos);
        //--------------------------------------------------------------


    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarzona/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formZonas')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formZonas')[0].reset();
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
<script>
  
  $('#formZonas').bootstrapValidator({
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
          Departamento: {
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
          Circuito_Recorrido: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'   
                  }
              }
          },
          Descripcion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
              }
          }
      }
  }).on('success.form.bv', function(e){
      e.preventDefault();
      guardar();
  });

</script>
