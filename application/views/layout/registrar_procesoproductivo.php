<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Proceso Productivo</h4>
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


<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->



 <!---//////////////////////////////////////--- BOX 1---///////////////////////////////////////////////////////----->



<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <div class="box-tittle">
            <h5>Informacion</h5>  
        </div>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
        
    </div>
    <!--_____________________________________________-->

    <div class="box-body">
        <form class="formProcesoProductivo" id="formProcesoProductivo">
            <div class="col-md-6">

                <!--Nombre-->
                <div class="form-group">
                    <label for="Nomb">Nombre:</label>
                    <input type="text" class="form-control" id="Nomb" name="Nomb">
                </div>
                <!--_____________________________________________-->

            </div>
            <div class="col-md-12">
                <div class="col-md-4">

                    <!--Nombre-->
                    <div class="form-group">
                        <label for="Nombre">Nombre etapa:</label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre">
                    </div>
                    <!--_____________________________________________-->

                </div>
                <div class="col-md-4">

                    <!--Recipiente-->
                    <div class="form-group">
                        <label for="Recipiente">Recipiente:</label>
                        <input type="text" class="form-control" id="Recipiente" name="Recipiente">
                    </div>
                    <!--_____________________________________________-->

                </div>
                <div class="col-md-4">

                    <!--Orden-->
                    <div class="form-group">
                        <label for="Orden">Orden:</label>
                        <input type="number" class="form-control" id="Orden" name="Orden">
                    </div>
                    <!--_____________________________________________-->
                    
                </div>
            </div>
            <!--__________________SEPARADOR___________________________-->

    <div class="col-md-12"> <hr></div>

<!--________________SEPARADOR_____________________________-->
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
            <div class="row">
        <div class="col-xs-12">


        <div class="box-body table-scroll">
        <div id="example2_wrapper" class="table table-bordered table-hover table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
        <tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Acciones</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Nombre</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Recipiente</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Orden</th>
        </tr>
        </thead>
        <!--_____________________________________________-->

        <tbody id="tabadd">
            <tr role="row" class="even" id="primero">
            <td class="sorting_1">
                <button type="button" title="editar"  class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
            </td>
            <td>Dato1</td>
            <td>Dato1</td>
            <td>Dato1</td>
            </tr>
        </tbody>
        </table></div></div><br><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
        </div>
        </div>

        </section>

    <!--_____________________________________________________________-->
    
</div>


<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

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
<!--_____________________________________________________________-->