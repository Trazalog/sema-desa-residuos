

<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Establecimiento</h4>
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
    
    <!--____________________BOX BODY____________________-->

    <div class="box-body">

        <!--/////////////////////// FORMULARIO ///////////////////////-->


        <form class="formEstablecimiento" id="formEstablecimiento">

        
        <div class="col-md-6">
            
            <!--_____________________________________________-->
            <!--Nombre-->

            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre">
            </div>

            <!--_____________________________________________-->
            <!--Estado-->

            <div class="form-group">
                <label for="Estado">Estado:</label>
                <input type="text" class="form-control" id="Estado" name="Estado">
            </div>            
            
            <!--_____________________________________________-->
            <!--Pais-->
            
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
                        <input type="date" class="form-control pull-right" id="fecha-baja">
                </div>
             </div>

            <!--_____________________________________________-->
            <!--Usuario-->

            <div class="form-group">
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" id="Usuario" name="Usuario" disabled>
            </div>

            

        </div>

         <!--***********************************************-->

        <div class="col-md-6">

            <!--_____________________________________________-->
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
            <!--Ubicacion-->

            <div class="col-md-12">

                <!--_____________________________________________-->
                <!--Latitud-->

                <div class="col-md-6">

                    <div class="form-group">            
                    <label for="Ubicacion">Latitud:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                    <input type="number" class="form-control" id="latitud" name="latitud">
                    </div>
                    </div>

                </div>

                <!--_____________________________________________-->
                <!--Longitud-->

                <div class="col-md-6">

                    <div class="form-group">
                    <label for="Ubicacion">Longitud:</label>
                    <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                    <input type="number" class="form-control" id="Longitud" name="Longitud">
                    </div>
                    </div>
                    
                </div>
           

            </div>
            <!--_____________________________________________-->

        </div>
        
        
        <div class="col-md-12"><hr> </div>
            <!--_____________________________________________-->
        <!--Boton de guardado-->
        <div class="col-md-12">
        <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>
        </div>
        
        </form>
    </div>
</div>


<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////---BOX 2---///////////////////////////////////////////////////////----->




<div class="box box-primary">

    


    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>



            <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla">



                </div>
            </div>

    <!---//////////////////////////////////////--- FIN BOX 2---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Establecimiento</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

        <form class="formEstablecimiento" id="formEstablecimiento">
        
            <div class="col-md-6">

                <!--_____________________________________________-->
                <!--Nombre-->

                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre">
                </div>

                <!--_____________________________________________-->
                <!--Localidad-->

                <div class="form-group">
                    <label for="Localidad">Localidad:</label>
                    <input type="text" class="form-control" id="Localidad" name="Localidad">
                </div>          
                
                <!--_____________________________________________-->
                <!--Pais-->
                
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
                            <input type="date" class="form-control pull-right" id="fecha-baja">
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Usuario-->

                <div class="form-group">
                    <label for="Usuario">Usuario:</label>
                    <input type="text" class="form-control" id="Usuario" name="Usuario">
                </div>
           

            </div>

            <!--***********************************************-->

            <div class="col-md-6">

                <!--_____________________________________________-->
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
                <!--Ubicacion-->
                
                <div class="col-md-12">            

                    <div class="col-md-6">

                        <div class="form-group">            
                        <label for="Ubicacion">Latitud:</label>
                        <input type="number" class="form-control" id="latitud" name="latitud">
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                        <label for="Ubicacion">Longitud:</label>
                        <input type="number" class="form-control" id="Ubicacion" name="Ubicacion">
                        </div>
                        
                    </div>
            

                </div>

                <!--_____________________________________________-->
                <!--Estado-->

                <div class="form-group">
                    <label for="Estado">Estado:</label>
                    <input type="text" class="form-control" id="Estado" name="Estado">
                </div>
                

            </div>

        <!--***********************************************-->
        
        
        <div class="col-md-12"><hr> </div>
            <!--_____________________________________________-->
       
        
    </form>

                
               

        <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>

            <div class="modal-footer">
            <div class="col-md-12">
                <div class="form-group text-right">                    
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Informacion Establecimiento</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

        <form class="formEstablecimiento" id="formEstablecimiento">
        
            <div class="col-md-6">

                <!--_____________________________________________-->
                <!--Nombre-->

                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre" readonly>
                </div>

                <!--_____________________________________________-->
                <!--Localidad-->

                <div class="form-group">
                    <label for="Localidad">Localidad:</label>
                    <input type="text" class="form-control" id="Localidad" name="Localidad" readonly>
                </div>          
                
                <!--_____________________________________________-->
                <!--Pais-->
                
                <div class="form-group">
                    <label for="Pais">Pais:</label>
                    <input type="text" class="form-control" id="Pais" name="Pais" readonly>
                </div>

                <!--_____________________________________________-->
                <!--Fecha de alta-->

                <div class="form-group">
                    <label for="Fechalta">Fecha de alta:</label>
                    <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" id="fecha-baja" readonly>
                    </div>
                </div>
                <!--_____________________________________________-->
                <!--Usuario-->

                <div class="form-group">
                    <label for="Usuario">Usuario:</label>
                    <input type="text" class="form-control" id="Usuario" name="Usuario" readonly>
                </div>
           

            </div>

            <!--***********************************************-->

            <div class="col-md-6">

                <!--_____________________________________________-->
                <!--Calles-->

                <div class="form-group">
                    <label for="Calles">Calles:</label>
                    <input type="text" class="form-control" id="Calles" name="Calles" readonly>
                </div>

                <!--_____________________________________________-->
                <!--Altura-->

                <div class="form-group">
                    <label for="Altura">Altura:</label>
                    <input type="text" class="form-control" id="Altura" name="Altura" readonly>
                </div>

                <!--_____________________________________________-->
                <!--Ubicacion-->
                
                <div class="col-md-12">            

                    <div class="col-md-6">

                        <div class="form-group">            
                        <label for="Ubicacion">Latitud:</label>
                        <input type="number" class="form-control" id="latitud" name="latitud" readonly>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                        <label for="Ubicacion">Longitud:</label>
                        <input type="number" class="form-control" id="Ubicacion" name="Ubicacion" readonly>
                        </div>
                        
                    </div>
            

                </div>

                <!--_____________________________________________-->
                <!--Estado-->

                <div class="form-group">
                    <label for="Estado">Estado:</label>
                    <input type="text" class="form-control" id="Estado" name="Estado" readonly>
                </div>
                

            </div>

        <!--***********************************************-->
        
        
        <div class="col-md-12"><hr> </div>
            <!--_____________________________________________-->
       
        
    </form>

                
               

        <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>

            <div class="modal-footer">
            <div class="col-md-12">
                <div class="form-group text-right">                    
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->

    



<!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

<!--_____________________________________________________________-->
<!--GUARDAR.-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Establecimiento/Lista_establecimientos");
    function Guardar_Zona() {

        // datos = $('#formZonas').serialize();

        var datos = new FormData($('#formEstablecimiento')[0]);
        datos = formToObject(datos);
        datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        console.log(datos);
        
        
        

        //--------------------------------------------------------------

        if ($("#formEstablecimiento").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Establecimiento/Guardar_Establecimiento",
                success: function (r) {
                    console.log(r);
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
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Establecimiento/Lista_establecimientos");
                        alertify.success("Agregado con exito");
                    } else {
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
                        regexp: /[A-Za-z]/,
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


<!--_____________________________________________--> 
<!-- Script Data-Tables-->



<script>



</script>