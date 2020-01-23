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
                    <input type="text" class="form-control" name="Codigo_registro" id="Codigo/Registro">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Descripcion-->
                <div class="form-group">
                    <label for="Descripcion" >Descripcion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="Descripcion" id="Descripcion">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Capacidad-->
                <div class="form-group">
                    <label for="Capacidad" >Capacidad:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="Capacidad" id="Capacidad">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Año de elaboracion-->
                <div class="form-group">
                    <label for="Añoelab">Año de elaboracion:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control"  name="Añoelab" id="Añoelab">
                    </div>
                </div>
                <!--_____________________________________________-->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--Tara-->
                <div class="form-group">
                    <label for="Tara" >Tara:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <input type="text" class="form-control" name="Tara" id="Tara">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Estado-->
                <div class="form-group">
                    <label for="Estados">Estado:</label>
                    <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                    <select class="form-control select2 select2-hidden-accesible"  name="Estados" id="Estados">
                        <option value="" disabled selected>-Seleccione opcion-</option>
                        <?php
                        foreach ($Estados as $i) {
                            echo '<option>'.$i->nombre.'</option>';
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
                    <input type="text" class="form-control" name="Habilitacion" id="Habilitacion">
                    </div>
                </div>

                <!--_____________________________________________-->
                <!--Adjuntador de imagenes-->  

                
                

                    <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                        <input type="file" name="upload">
                    </form>
        
                          
               
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

<!--___________________________TABLA___________________________-->

<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6"></div>
        </div>
        <div class="row">

            <div class="col-sm-12 table-scroll">

            <!--___________________________HEADER TABLA___________________________-->


                <!--___________________________HEADER TABLA___________________________-->
                <table id="tabla_contenedores" class="table table-bordered table-striped">
                    <thead class="thead-dark" bgcolor="#eeeeee">

                        <th>Acciones</th>
                        <th>Codigo / Registro</th>
                        <th>Estado</th>
                        <th>Capacidad</th>
                        <th>Habilitacion</th>
                        

                    </thead>

                    <!--___________________________BODY TABLA___________________________-->

                    <tbody>
                    <tr>
                        <td>
                        <button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                        <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                        <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
                        
                        </td>
                        <td>DATO</td>
                        <td> DATO</td>
                        <td>DATO</td>
                        <td>DATO</td>
                    </tr>

                       
                    </tbody>
                </table>
                
                <!--___________________________FIN TABLA___________________________-->
            </div>
        </div>

    </div>
</div>

<!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->






<!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Contenedor</h5>
            </div>


            <div class="modal-body">

            <!--___________________________FORMULARIO MODAL___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">



            <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <!--Codigo / Registro-->
                    <div class="form-group">
                        <label for="Codigo/Registro" >Codigo / Registro:</label>
                        <input type="text" class="form-control"  name="" id="Codigo/Registro">
                    </div>
                    <!--_____________________________________________-->
                    <!--Descripcion-->
                    <div class="form-group">
                        <label for="Descripcion" >Descripcion:</label>
                        <input type="text" class="form-control"  name="" id="Descripcion">
                    </div>
                    <!--_____________________________________________-->
                    <!--Capacidad-->
                    <div class="form-group">
                        <label for="Capacidad" >Capacidad:</label>
                        <input type="text" class="form-control" name="" id="Capacidad">
                    </div>
                    <!--_____________________________________________-->
                    <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="Añoelab" >Año de elaboracion:</label>
                        <input type="text" class="form-control" name="" id="Añoelab">
                    </div>

                </div>
                
                <div class="col-md-6">
                    <!--_____________________________________________--> 
                    <!--Tara-->
                    <div class="form-group">
                        <label for="Tara" >Tara:</label>
                        <input type="text" class="form-control" name="" id="Tara">
                    </div>
                    <!--_____________________________________________-->
                    <!--Estado-->
                    
                    <div class="form-group">
                        <label for="Estados">Estado:</label>
                        <select class="form-control select2 select2-hidden-accesible"  name="" id="Estados">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($Estados as $i) {
                                echo '<option>'.$i->nombre.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!--_____________________________________________-->
                    <!--Habilitacion-->
                    <div class="form-group">
                        <label for="Habilitacion">Habilitacion:</label>
                        <input type="text" class="form-control"  name="" id="Habilitacion">
                    </div>
                </div>

                </div>    
                
            </div>
            <div class="col-md-12">
                <hr>
            </div>

            
        </form>

                
                </div>
                
            </form>

            <!--___________________________FIN FORMULARIO MODAL___________________________-->

            </div>

            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Contenedor</h5>
            </div>


            <div class="modal-body">

            <!--___________________________FORMULARIO MODAL___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">



            <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">

            <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <!--Codigo / Registro-->
                    <div class="form-group">
                        <label for="Codigo/Registro" >Codigo / Registro:</label>
                        <input type="text" class="form-control" name="E_Codigo_registro" id="Codigo/Registro" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Descripcion-->
                    <div class="form-group">
                        <label for="Descripcion" >Descripcion:</label>
                        <input type="text" class="form-control" name="E_Descripcion" id="Descripcion" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Capacidad-->
                    <div class="form-group">
                        <label for="Capacidad">Capacidad:</label>
                        <input type="text" class="form-control"  name="E_Capacidad" id="Capacidad" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="Añoelab">Año de elaboracion:</label>
                        <input type="text" class="form-control"  name="E_Añoelab" id="Añoelab" readonly>
                    </div>

                </div>
                
                <div class="col-md-6">
                    <!--_____________________________________________--> 
                    <!--Tara-->
                    <div class="form-group">
                        <label for="Tara" >Tara:</label>
                        <input type="text" class="form-control"  name="E_Tara" id="Tara" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Estado-->
                    
                    <div class="form-group">
                        <label for="Estados" >Estado:</label>
                        <input type="text" class="form-control" name="E_Estados" id="" readonly>
                    </div>
                    <!--_____________________________________________-->
                    <!--Habilitacion-->
                    <div class="form-group">
                        <label for="Habilitacion" >Habilitacion:</label>
                        <input type="text" class="form-control" name="E_Habilitacion" id="Habilitacion" readonly>
                    </div>
                </div>

                </div>    
                
            </div>
            <div class="col-md-12">
                <hr>
            </div>

            
        </form>

                
                </div>
                
            </form>

            <!--___________________________FIN FORMULARIO MODAL___________________________-->

            </div>

            <div class="modal-footer">
                <div class="form-group text-right">
                    <!-- <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button> -->
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->

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

    function Guardar_Contenedor() {

        datos = $('#formContenedores').serialize();

        //datos para mostrar a modo de ejemplo para DEMO---------------

        //Serialize the Form

        var values = {};
        $.each($("#formContenedores").serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });

        //Value Retrieval Function

        var getValue = function (valueName) {
            return values[valueName];
        };


        //Variables DATOS de los INPUT

        var Codigo_registro = getValue("Codigo_registro");
        var Descripcion = getValue("Descripcion");
        var Capacidad = getValue("Capacidad");
        var Añoelab = getValue("Añoelab");
        var Tara = getValue("Tara");
        var Estados = getValue("Estados");
        var Habilitacion = getValue("Habilitacion");


        //--------------------------------------------------------------

        if ($("#formContenedores").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: datos,
                url: "general/Estructura/Contenedor/Guardar_Contenedor",
                success: function (r) {
                    if (r == "ok") {

                        //console.log(datos);

                         //esta porcion de codigo me permite agregar una nueva fila a dataTable asignando al final un id unico a la fila agregada para luego identificarla
                       
                        var t = $('#tabla_contenedores').DataTable();
                        var fila = t.row.add([

                            //agrega los iconos correspondientes

                            '<div class="text-center"><button type="button" title="Editar"  onclick="clickedit('+aux+')" class="btn btn-primary btn-circle"  data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp<button type="button" title="Info" onclick="clickinfo('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp<button type="button" title="eliminar" onclick="borrar('+aux+')" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp</div>',
                            
                            Codigo / Registro,
                            Estado,
                            Capacidad,
                            Habilitacion
                    
                            
                            
                        ]).node().id = aux; //esta linea de codigo permite agregar un id a la fila recien insertada para identificarla luego
                        t.draw(false);

                        aux = aux + 1;//incrementa en 1 la variable auxiliar, la cual indica el id de las filas que se agregan a la tabla
                        $('#formContenedores').data('bootstrapValidator').resetForm(true);
                        alertify.success("Agregado con exito");
                    }
                    else {
                        //console.log(r);
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
        Codigo_registro: {
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
        Descripcion: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
            }
        },
        Capacidad: {
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
        Añoelab: {
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
        Tara: {
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
        Estados: {
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
<script>
    DataTable($('#tabla_contenedores'))
</script>


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
            Codigo_registro: {
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
            Descripcion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    },
                }
            },
            Capacidad: {
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
            Añoelab: {
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
            Tara: {
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
            Estados: {
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
</script>

<!--'<div class="text-center">
<button type="button" title="Editar"  onclick="clickedit('+aux+')" class="btn btn-primary btn-circle"  data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
<button type="button" title="Info" onclick="clickinfo('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
<button type="button" title="eliminar" onclick="borrar('+aux+')" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
</div>', -->