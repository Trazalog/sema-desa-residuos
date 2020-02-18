<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Registrar Zona</h4>
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
    
        <form class="formZonas" id="formZonas" method="POST" autocomplete="off" class="registerForm">
           
                <div class="col-md-12">

                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--_____________________________________________-->
                        <!--Nombre-->

                        <div class="form-group">
                            <label for="Nombre" >Nombre:</label>
                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <input type="text" name="nombre" class="form-control" id="Nombre">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <!--_____________________________________________-->
                        <!--Departamento-->

                        <div class="form-group">
                            <label for="Departamento" >Departamento:</label>
                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                            <select class="form-control select2 select2-hidden-accesible" name="depa_id" id="Departamento">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                            foreach ($Departamentos as $i) {
                                echo '<option  value="'.$i->depa_id.'">'.$i->nombre.'</option>';

                                
                            }
                            ?>
                            </select>
                            </div>
                        </div>

                    </div>


                </div>

                

                    <!--_____________________________________________-->
                    <!--Circuito-->


                        


                    <!--_____________________________________________-->

                <div class="col-md-12"> 

                    <!--_____________________________________________-->
                    <!--Descripcion--> 

                    <div class="form-group">
                        <label for="Descripcion" >Descripcion:</label>
                        <textarea style="resize: none;" type="text" class="form-control input-sm" rows="5" id="Descripcion"
                            name="descripcion" required></textarea>
                        
                    </div>
                </div>

                <!--_____________________________________________-->
            
            <div class="col-md-12"><hr></div>

                <!--_____________________________________________-->
                <!--Adjuntar imagen--> 

                <div class="col-md-6">

                    <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                        <input type="file" name="imagen">
                    </form>
                </div>

                <!--_____________________________________________-->

                <div class="col-md-12"><hr></div>

                <!--_____________________________________________-->
                <!--Boton Guardar--> 
            
            <div class="col-md-12">

            <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Zona()">Guardar</button>
            
            </div>
                
        </div>

            

            

            


    </div>

    <!--_____________________________________________-->
</div>
</form>
</div>
</div>



<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////---BOX 2 DATATBLE ---///////////////////////////////////////////////////////----->





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

<!---//////////////////////////////////////--- FIN BOX 2 DATATABLE---///////////////////////////////////////////////////////----->



 <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->

    
 <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Zona</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="" class="registerForm">


                <div class="modal-body">

                

                    <div class="row"> 

                        <div class="col-md-12 "> 

                                               

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Nombre-->

                                <div class="form-group">
                                 <label for="Nombre" name="">Nombre:</label>
                                 <input type="text" class="form-control" id="">
                                </div>

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="form-group">
                                    <label for="Descripcion" name="">Descripcion:</label>
                                     <input type="text" class="form-control" id="">
                                </div>

                            </div>

                            

                            <!--**************************************************-->
                            
                            

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Circuito-->

                                <div class="form-group">
                                    <label for="CircR" name="">Circuito / Recorrido:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php

                                    ?>
                                    </select>
                                </div>

                                <!--_____________________________________________-->
                                <!--Departamento-->                

                                <div class="form-group">
                                    <label for="Dpto" name="">Departamento:</label>
                                    <select class="form-control select2 select2-hidden-accesible" id="">
                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                        <?php
                                    foreach ($Departamentos as $i) {
                                        echo '<option value="'.$fila->depa_id.'">'.$fila->nombre.'</option>' ;
                                     }
                                    ?>
                                    </select>
                                </div>

                            </div>

                           

                            




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


 <!---//////////////////////////////////////--- MODAL CIRCUITOS ---///////////////////////////////////////////////////////----->

    
 <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Circuitos Asignados</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="" class="registerForm">


                <div class="modal-body">                

                    <div class="row">
                
                        <div class="col-sm-12 ">

                            <!--__________________HEADER TABLA___________________________-->


                            <table id="tabla_circuitos" class="table table-bordered table-striped table-scroll">
                                <thead class="thead-dark" bgcolor="#eeeeee">

                                    
                                    <th>Codigo</th>
                                    <th>Chofer</th>
                                    <th>Vehiculo</th>
                                    <th>Tipo de residuo</th>
                                    

                                </thead>

                                <!--__________________BODY TABLA___________________________-->

                                <tbody>
                                <?php
                                if($CircuitosAsignados)
                                    {
                                        foreach($CircuitosAsignados as $fila)
                                        {
                                        echo '<tr data-json:'.json_encode($fila).'>';                                        
                                        echo    '<td>'.$fila->codigo.'</td>';
                                        echo    '<td>'.$fila->chof_id.'</td>';
                                        echo    '<td>'.$fila->vehi_id.'</td>';
                                        echo    '<td>'.$fila->descripcion.'</td>';
                                        echo '</tr>';
                                    }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!--__________________FIN TABLAa___________________________-->

                        </div>
                    </div>
                
                     <br>          
                   
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


<!---//////////////////////////////////////--- FIN MODAL CIRCUITOS ---///////////////////////////////////////////////////////----->







            <!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->
<!--_____________________________________________-->

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
​<!--_____________________________________________-->

<!-- Script Agregar datos de registrar_zona-->
<!-- <script>
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
</script> -->



<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Zona/Listar_Zona");
    function Guardar_Zona() {

        // datos = $('#formZonas').serialize();

        var datos = new FormData($('#formZonas')[0]);
        datos = formToObject(datos);
        datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        console.table(datos);
        
        
        

        //--------------------------------------------------------------

        if ($("#formZonas").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Zona/Guardar_Zona",
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
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Zona/Listar_Zona");
                        alertify.success("Agregado con exito");

                        $('#formZonas').data('bootstrapValidator').resetForm();
                        $("#formZonas")[0].reset();
                       
                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");



                    } else {
                        //console.log(r);
                        alertify.error("error al agregar");
                    }
                }
            });
        }
    }
</script>

<!--_____________________________________________-->

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
        nombre: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
                  }
              }
          },
          depa_id: {
              message: 'la entrada no es valida',
              validators: {
                  notEmpty: {
                      message: 'la entrada no puede ser vacia'
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

<!--_____________________________________________-->

<script>

// DataTable($('#tabla_zonas'));

// DataTable($('#tabla_circuitos'));


</script>