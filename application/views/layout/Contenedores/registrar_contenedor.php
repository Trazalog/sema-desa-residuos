<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Contenedor</h4>
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




<!---//////////////////////////////////////---BOX 1---///////////////////////////////////////////////////////----->


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
        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--Codigo / Registro-->
                <div class="form-group">
                    <label for="Codigo/Registro" >Codigo / Registro:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="codigo" id="codigo">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" >Descripcion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="descripcion" id="descripcion">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad" >Capacidad:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="number" class="form-control" name="capacidad" id="capacidad">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab">Año de elaboracion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="date" class="form-control"  name="anio_elaboracion" id="anio_elaboracion">                 

                    </div>
                </div>
                <!--_____________________________________________-->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--Tara-->
                <div class="form-group">
                    <label for="Tara" >Tara:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="number" class="form-control" name="tara" id="tara">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Estado-->
                <div class="form-group">
                    <label for="Estados">Estado:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    
                    <select class="form-control select2 select2-hidden-accesible"  name="esco_id" id="esco_id">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estados as $i) {
                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Habilitacion-->
                <div class="form-group">
                    <label for="Habilitacion" >Habilitacion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="habilitacion" id="habilitacion">
                    </div>
                </div>

                 <!--_____________________________________________-->
                <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab">Fecha alta:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="date" class="form-control"  name="fec_alta" id="fec_alta">                 

                    </div>
                </div>

                <!--_____________________________________________-->
                <!--Adjuntador de imagenes-->  

                
                

                    <!-- <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                        <input type="file" name="upload">
                    </form> -->
        
                          
               
            </div>


            <!--_____________________________________________-->

            <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>

            <!--_____________________________________________-->
            <!--Boton de guardado-->
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Contenedor()">Guardar</button>
            </div>
            <!--_____________________________________________-->
        </form>
    </div>
</div>


<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->



<div class="box box-primary">

<!--__________________TABLA___________________________-->



<div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>



            <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla">



                </div>
            </div>
        </div>
    </div>

<!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->





 <!---//////////////////////////////////////--- FUNCIONES ---///////////////////////////////////////////////////////----->



 <!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->

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
​<!--_____________________________________________________________-->

<!-- Script Data-Tables-->
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



​<!--_____________________________________________________________-->

<!-- Script Agregar datos de registrar_generadores-->

<!-- <script>
function Guardar_Contenedor(){
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
                url:"ajax/Registrarcontenedor/guardarDato",
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
</script> -->


<!--_____________________________________________________________-->
<!-- REGISTRAR CONTENEDORES-->



<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor");
    function Guardar_Contenedor() {

        // datos = $('#formZonas').serialize();

        var datos = new FormData($('#formContenedores')[0]);
        datos = formToObject(datos);
        // datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        datos.reci_id = "270";      
        console.table(datos);
        
        
        

        //--------------------------------------------------------------

        if ($("#formContenedores").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Contenedor/Guardar_Contenedor",
                success: function (r) {
                    console.table(r);
                    if (r == "ok") {
                        // //esta porcion de codigo me permite agregar una nueva fila a dataTable asignando al final un id unico a la fila agregada para luego identificarla
                        // var t = $('#tabla_infracciones').DataTable();
                        // var fila = t.row.add([
                        //     N° Acta,
                        //     Tipo de infraccion,
                        //     Inspector,
                        //     Destino,
                    
                        //     //agrega los iconos correspondientes
                        //     '<div class="text-center"><button type="button" title="ok" class="btn btn-primary btn-circle btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>&nbsp<button type="button" title="editar" onclick="clickedit('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" onclick="borrar('+aux+')" id="delete" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp<button type="button" title="buscar" class="btn btn-primary btn-circle info" onclick="clickinfo('+aux+')" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></div>'
                        // ]).node().id = aux; //esta linea de codigo permite agregar un id a la fila recien insertada para identificarla luego
                        // t.draw(false);

                        // aux = aux + 1;//incrementa en 1 la variable auxiliar, la cual indica el id de las filas que se agregan a la tabla
                        // localStorage.setItem('aux', aux);//actualiza la variable local aux para la proxima insercion

                        // $('#FormInfraccion').data('bootstrapValidator').resetForm();
                        // $("#FormInfraccion")[0].reset();
                        // $('#selecmov').find('option').remove();
                        // $('#chofer').find('option').remove();
                        // $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>");
                        // $("#boxDatos").hide(500);
                        // $("#botonAgregar").removeAttr("disabled");
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor");
                        alertify.success("Agregado con exito");
                    } else {
                        //console.table(r);
                        alertify.error("error al agregar");
                    }
                }
            });
        }
    }
</script>



<!--_____________________________________________________________-->

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
        codigo: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                  regexp: {
                      regexp: /^\d+$/ ,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
        descripcion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
              }
          },
          capacidad: {
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
        anio_elaboracion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                  
              }
          },
        tara: {
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
          esco_id: {
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


<!--_____________________________________________________________-->
 <!-- script Datatables -->


<!--_____________________________________________________________-->
 <!-- script Listar Datos -->

<!-- 
<script>


   listarContenedores()

    function listarContenedores(){
        alert('hola');

        $.ajax({
                type:"GET",
                data:datos,
                url:"general/Estructura/Contenedores/Listar_Contenedor",
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
    }


    

</script>  -->









<!-- 
'<div class="text-center">
<button type="button" title="Editar"  onclick="clickedit('+aux+')" class="btn btn-primary btn-circle"  data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp

<button type="button" title="Info" onclick="clickinfo('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp

<button type="button" title="eliminar" onclick="borrar('+aux+')" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp


</div>', -->

                     

