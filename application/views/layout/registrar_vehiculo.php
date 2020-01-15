<!-- Hecha por Jose Roberto el mas VIRGO -->

<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Vehiculo</h4>
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


<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->



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

​        <!--_____________________________________________________________-->


<div class="box-body">

<form class="formVehiculo" id="formVehiculo"  method="POST" autocomplete="off" class="registerForm">

        <div class="col-md-6 col-sm-6 col-xs-12">
        
                        <!--Descripcion-->
                        <div class="form-group">
                                <label for="Descripcion" >Descripcion:</label>
                                <input type="text" class="form-control" id="Descripcion" name="descripcion">
                        </div>
            ​            <!--_____________________________________________________________-->

                        <!--Dominio-->
                        <div class="form-group">
                                <label for="Dominio">Dominio:</label>
                                <input type="text" class="form-control" id="Dominio" name="dominio">
                        </div>
            ​            <!--_____________________________________________________________-->

                        <!--Marca-->
                        <div class="form-group">
                                <label for="Marca" >Marca:</label>
                                <input type="text" class="form-control" id="Marca" name="marca">
                        </div>
            ​            <!--_____________________________________________________________-->

                        <!--Condicion-->
                        <div class="form-group">
                            <label for="condicion" >Condicion:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="condicion" name="condicion" >
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($condicion as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>
            ​            <!--_____________________________________________________________-->

                        <!--Modelo-->
                        <div class="form-group">
                                <label for="Modelo" >Modelo:</label>
                                <input type="text" class="form-control" id="Modelo" name="modelo">
                        </div>
            ​            <!--_____________________________________________________________-->
        </div>
        
        <div class="col-md-6 col-sm-6 col-xs-12">
        
                        <!--Capacidad-->
                        <div class="form-group">
                                <label for="Capacidad" >Capacidad:</label>
                                <input type="text" class="form-control" id="Capacidad" name="capacidad">
                        </div>
            ​            <!--_____________________________________________________________-->

                        <!--Tara-->
                        <div class="form-group">
                                <label for="Tara" >Tara:</label>
                                <input type="text" class="form-control" id="Tara" name="tara" >
                        </div>
            ​            <!--_____________________________________________________________-->    

                        <!--Habilitacion-->
                        <div class="form-group">
                                <label for="Habilitacion" >Habilitacion:</label>
                                <input type="text" class="form-control" id="Habilitacion" name="habilitacion" >
                        </div>
            ​            <!--_____________________________________________________________-->    

                        <!--Registro-->
                        <div class="form-group">
                                <label for="Registro" >Registro:</label>
                                <input type="text" class="form-control" id="Registro" name="registro" >
                        </div>
            ​            <!--_____________________________________________________________--> 

                        <!--Fecha de habilitacion-->
                        <div class="form-group" >
                            <label for="Fechahabilitacion" >Fecha de habilitacion:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" id="datepicker" name="fechahabilitacion">
                            </div>
                            <!-- /.input group -->
                        </div>
            ​            <!--_____________________________________________________________-->

                        <!--Adjuntador de imagenes-->
                        <!-- <div class="form-group">
                            <form action="cargar_archivo" method="post" enctype="multipart/form-data" style="width: 200px; font-weight: lighter;">
                                <input  type="file"  id="imgarch" name="upload" data-required="true">
                            </form>
                        </div> -->
            ​            <!--_____________________________________________________________-->

        
        </div>

            <!--_______________________SEPARADOR______________________________________-->            
            
            <div class="col-md-12"><hr></div>

            <!--_______________________SEPARADOR______________________________________-->
            
            <div class="col-md-6">
                

                <button type="file" name="upload" class="btn btn-default btn-circle" aria-label="Left Align">
                    <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                </button>
                <small for="agregar" class="form-label">Adjuntar imagen</small>
        
            </div>

            <!--_____________________________________________________________-->            
            <!--Boton de guardado--> 
                    <div class="col-md-12"><hr></div><br>
            <button type="submit" class="btn btn-primary pull-right" onclick="agregarDato()">Guardar</button>

            <!--_____________________________________________________________--> 
</form>
</div>
</div>
</div>

<!---//////////////////////////////////////--- FIN BOX---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->



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


                    <!--__________________HEADER TABLA___________________________-->
                    <table id="tabla_vehiculos" class="table table-bordered table-striped">
                        <thead class="thead-dark" bgcolor="#eeeeee">

                            <th>Acciones</th>
                            <th>Dominio</th>
                            <th>Condicion</th>
                            <th>Capacidad</th>
                            <th>Tara</th>
                            <th>habilitacion</th>
                            <th>Registro</th>
                            

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
                            <td>DATO</td>
                            <td>DATO</td>
                        </tr>

                           
                        </tbody>
                    </table>
                    
                    <!--__________________FIN TABLA___________________________-->
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Vehiculo</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                <!--_____________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="Nombre/Razon social">
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT" name="Cuit">CUIT:</label>
                                <input type="text" class="form-control" id="CUIT">
                            </div>
                <!--_____________________________________________-->
                <!--Tipo de residuo-->

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
                         </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" name="Domicilio">Domicilio:</label>
                                <input type="text" class="form-control" id="Domicilio">
                            </div>

                <!--_____________________________________________-->
                <!--Resolucion-->

                            <div class="form-group">
                                <label for="Zonag" name="Zona">Zona:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="Zonag">
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($Zonag as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                </div>

                <!--_____________________________________________-->
                <!--Fecha de Alta-->

                <div class="row">                        
                    <div class="col-md-6">
                        <label for="Numero de registro" name="Numero_registro">Numero de registro:</label>
                        <input type="text" class="form-control" id="Numero de registro">
                            
                        </div>

                        <div class="col-md-6">
                            <label for="Rubro" name="Rubro">Rubro:</label>
                            <input type="text" class="form-control" id="Rubro">
                        </div>

                <!--_____________________________________________-->
                <!--Fecha de Baja-->


                        <div class="col-md-6">
                            <label for="TipoG" name="Tipo">Tipo:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="TipoG">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                foreach ($TipoG as $i) {
                                    echo '<option>'.$i->nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="Tipo de residuos" name="Tipo_Residuo">Tipo de residuos:</label>
                            <input type="text" class="form-control" id="Tipo de residuos">
                        </div>
                    </div>
                    
                    
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

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
                <h5 class="modal-title" id="exampleModalLabel">Informacion Vehiculo</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                <div class="modal-body">

                <!--_____________________________________________-->
                <!--Nombre/Razon social-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nombre/Razon social" name="Nombre_razon">Nombre / Razon social:</label>
                                <input type="text" class="form-control" id="Nombre/Razon social" readonly>
                            </div>
                        </div>                        
                    </div>

                <!--_____________________________________________-->
                <!--Registro-->

                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CUIT" name="Cuit">CUIT:</label>
                                <input type="text" class="form-control" id="CUIT" readonly>
                            </div>
                <!--_____________________________________________-->
                <!--Tipo de residuo-->

                            <div class="form-group">
                            <label for="Dpto" name="Departamento">Departamento:</label>
                            <input type="text" class="form-control" id="Dpto" readonly>
                            </div>
                         </div>

                <!--_____________________________________________-->
                <!--Descripcion-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Domicilio" name="Domicilio">Domicilio:</label>
                                <input type="text" class="form-control" id="Domicilio" readonly>
                            </div>

                <!--_____________________________________________-->
                <!--Resolucion-->

                            <div class="form-group">
                                <label for="Zonag" name="Zona">Zona:</label>
                                <input type="text" class="form-control" id="zonaG" readonly>
                            </div>
                        </div>
                </div>

                <!--_____________________________________________-->
                

                <div class="row"> 

                        <!--_____________________________________________-->
                        <!--Numero de registro-->

                        <div class="col-md-6">
                            <label for="Numero de registro" name="Numero_registro">Numero de registro:</label>
                            <input type="text" class="form-control" id="Numero de registro" readonly>                            
                        </div>

                        <!--_____________________________________________-->
                        <!--Rubro-->

                        <div class="col-md-6">
                            <label for="Rubro" name="Rubro">Rubro:</label>
                            <input type="text" class="form-control" id="Rubro" readonly>
                        </div>                

                        <!--_____________________________________________-->
                        <!--Tipo-->

                        <div class="col-md-6">
                            <label for="TipoG" name="Tipo">Tipo:</label>
                            <input type="text" class="form-control" id="TipoG" readonly>
                        </div>

                        <!--_____________________________________________-->
                        <!--Tipo de residuos-->

                        <div class="col-md-6">
                            <label for="Tipo de residuos" name="Tipo_Residuo">Tipo de residuos:</label>
                            <input type="text" class="form-control" id="Tipo de residuos" >
                        </div>
                    </div>
                    
                    
                </div>
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

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





</div>
</div>


  
 <!---//////////////////////////////////////--- SCRIPTS---///////////////////////////////////////////////////////----->

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

<!-- Script Agregar datos de registrar_generadores-->
<script>
function agregarDato(){
    console.log("entro a agregar datos");
    $('#formVehiculo').on('submit', function(e){
    e.preventDefault();
    var me = $(this);
    if ( me.data('requestRunning') ) {return;}
    me.data('requestRunning', true);
    datos=$('#formVehiculo').serialize();
    console.log(datos);
        //--------------------------------------------------------------
    $.ajax({
                type:"POST",
                data:datos,
                url:"ajax/Registrarchofer/guardarDato",
                success:function(r){
                    if(r == "ok"){
                        //console.log(datos);
                        $('#formVehiculo')[0].reset();
                        alertify.success("Agregado con exito");
                    }
                    else{
                        console.log(r);
                        $('#formVehiculo')[0].reset();
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
​<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.-->
<script>
  $('#formVehiculo').bootstrapValidator({
      message: 'This value is not valid',
      /*feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },*/
      //excluded: ':disabled',
      fields: {
          descripcion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          dominio: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          marca: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          condicion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
              }
          },
          modelo: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /[A-Za-z]/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          capacidad: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          tara: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          habilitacion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
                  }
              }
          },
          registro: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
              }
          },
          fechahabilitacion: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  },
                    /*stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },*/
                  regexp: {
                      regexp: /^(0|[1-9][0-9]*)$/,
                      message: 'la entrada no debe ser un numero entero'
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
 <!-- script Datatables -->
 <script>

    DataTable($('#tabla_vehiculos'))

</script>