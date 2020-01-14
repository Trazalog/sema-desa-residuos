

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




    <!--__________________TABLA___________________________-->

    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-scroll">

                <!--__________________HEADER TABLA___________________________-->
                <table id="tabla_establecimiento" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Localidad</th>
                            <th>Fecha de alta</th>
                            

                        </thead>

                        <!--__________________BODY TABLA___________________________-->

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

                    <!--__________________FIN TABLA___________________________-->
                </div>
            </div><br>

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


<!-- Script Agregar datos de registrar_inspector-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formEstablecimiento').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formEstablecimiento').serialize();
    console.log(datos);
        //--------------------------------------------------------------

    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarinspector/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formEstablecimiento')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formEstablecimiento')[0].reset();
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
DataTable($('#tabla_establecimiento'))
</script>


