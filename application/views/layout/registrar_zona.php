<!-- Hecha por Jose Roberto el mas virgo -->

<!--//////////////////////////////Box1//////////////////////////////-->
<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h3 style="font-weight: lighter;">Registrar Zona</h3>
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
<!--_____________________________________________________________-->

<!--//////////////////////////////Box2//////////////////////////////-->
<div class="box box-primary animated fadeInLeft" id="boxDatos" hidden>
    <div class="box-body">
        <form class="formZonas" id="formZonas">

        <!--Boton de cerrar-->
        <div class="box-tools pull-right">
                <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                    data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        <!--_____________________________________________-->

                <div class="col-md-6">
                <br>
                <!--Nombre-->
                <div class="form-group">
                    <label for="Nombre" style="width: 200px; font-weight: lighter;">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre" style="width: 200px; font-weight: lighter;">
                </div>
                <!--_____________________________________________-->

                <!--Departamento-->
                <div class="form-group">
                    <label for="Dpto" style="width: 200px; font-weight: lighter;">Departamento:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="Dpto" name="Departamento" style="width: 200px; font-weight: lighter;">
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
                    <label for="CircR" style="width: 200px; font-weight: lighter;">Circuito / Recorrido:</label>
                    <select class="form-control select2 select2-hidden-accesible" id="CircR" name="Circuito_Recorrido" style="width: 200px; font-weight: lighter;">
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
                <form action="cargar_archivo" method="post" enctype="multipart/form-data" style="width: 200px; font-weight: lighter;">
                <input  type="file"  id="imgarch" name="upload" data-required="true">
                </form>
                <!--_____________________________________________-->

                </div>
                <div class="col-md-6">

                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" style="width: 200px; font-weight: lighter;">Descripcion:</label>
                    <input type="text" class="form-control" id="Descripcion" name="Descripcion" style="width: 200px; font-weight: lighter;">
                </div>
                <!--_____________________________________________-->

                <!--Boton de guardado-->
                <br>
                <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
                <!--_____________________________________________-->
                </div>
            </div>
        </div>

            <!--//////////////////////////////Box3//////////////////////////////-->
            <!--Datatable Registrar Generadores-->
            <div class="box box-primary animated fadeInLeft">
                <div class="box-body table-scroll">
                    <table id="example2" class="table table-bordered table-hover table-responsive">

                    <!--Cabecera del Datatable-->
                        <thead>
                            <tr>
                                <th id="Nombre" class="Nombre" style="width: 200px; font-weight: lighter;">Nombre</th>
                                <th id="Departamento" class="Departamento" style="width: 200px; font-weight: lighter;">Departamento</th>
                                <th id="Circuito_Recorrido" class="Circuito_Recorrido" style="width: 200px; font-weight: lighter;">Circuito / Recorrido</th>
                                <th id="Descripcion" class="Descripcion" style="width: 200px; font-weight: lighter;">Descripcion</th>
                            </tr>
                        </thead>
                    <!--_____________________________________________-->

                    <!--Cuerpo del Datatable-->
                        <tbody>
                            <tr style="width: 200px; font-weight: lighter;">
                                <td id="Nombre" class="Nombre">Trident</td>
                                <td id="Departamento" class="Departamento">Internet Explorer 4.0</td>
                                <td id="Circuito_Recorrido" class="Circuito_Recorrido">Win 95+</td>
                                <td id="Descripcion" class="Descripcion">4</td>
                            </tr>
                        </tbody>
                    <!--_____________________________________________-->

                    </table>
                </div>
            </div>
<!--_____________________________________________________________-->

        </form>
    </div>
</div>
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

<!-- Script Data-Tables-->

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
​<!--_____________________________________________________________-->

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

<!--Script Bootstrap Validacion.-->
<script>
  $('#formZonas').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      //excluded: ':disabled',
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
  }).on('success.form.bv', function (e) {
      e.preventDefault();
      //guardar();
  });
</script>
<!--_____________________________________________________________-->

<!--Script validador de campo de imagenes-->
<script>
var value = $("#imgarch").val();
if (value == "1") {
    document.getElementById('imgarch').setAttribute("data-required","true");
}
else {
    document.getElementById('imgarch').setAttribute("data-required","false");
}
</script>
<!--_____________________________________________________________-->