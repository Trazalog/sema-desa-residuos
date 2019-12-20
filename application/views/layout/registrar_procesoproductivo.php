<!-- Hecha por Jose Roberto el mas vergas -->

<!--//////////////////////////////Box1//////////////////////////////-->
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
                    <label for="Nomb">Nombre:</label>
                    <input type="text" class="form-control" id="Nomb" name="Nomb">
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
                    <input type="text" class="form-control" id="Recipiente" name="Recipiente">
                </div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-2">

                <!--Orden-->
                <div class="form-group">
                    <label for="Orden">Orden:</label>
                    <input type="text" class="form-control" id="Orden" name="Orden">
                </div>
                <!--_____________________________________________-->
                
            </div>
            <div class="col-md-12">

                <!--Boton de guardado-->
                <br>
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
            <div class="row">
        <div class="col-xs-12">
        <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Nombre</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Recipiente</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Orden</th></tr>
        </thead>
        <!--_____________________________________________-->

        <tbody id="tabadd">
            <tr role="row" class="even" id="primero">
            <!--<td>Roberto Basañes</td>
            <td>Desarrollador</td>-->
            <!--<td class="sorting_1"><button type="button" title="ok" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
            -->
            </tr>
        </tbody>
        </table></div></div><br><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
        </div>
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
          Nomb: {
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
          Recipiente: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
          Orden: {
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
    //guardar();
});
</script>
<!--_____________________________________________________________-->