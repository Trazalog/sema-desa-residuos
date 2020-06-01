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

<!---//////////////////////////////////////--- BOX 1 ---//////////////////////////////////////----->

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
                            <input type="text" class="form-control" id="descripcion" name="descripcion">
                        </div>
            ​        <!--_____________________________________________________________-->

                    <!--Dominio-->
                        <div class="form-group">
                            <label for="Dominio">Dominio:</label>
                            <input type="text" class="form-control" id="dominio" name="dominio">
                        </div>
            ​        <!--_____________________________________________________________-->

                    <!--Marca-->
                        <div class="form-group">
                            <label for="Marca" >Marca:</label>
                            <input type="text" class="form-control" id="marca" name="marca">
                        </div>
            ​        <!--_____________________________________________________________-->
                     <!--Condicion-->
                        <div class="form-group">
                            <label for="transportista" >Transportista:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="tran_id" name="tran_id" >
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($transportista as $i) {
                                        echo '<option value="'.$i->tran_id.'">'.$i->razon_social.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
            ​        <!--_____________________________________________________________-->

                    <!--Condicion-->
                        <!-- <div class="form-group">
                            <label for="condicion" >Condicion:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="condicion" name="condicion" >
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                <?php
                                    foreach ($condicion as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                ?>
                            </select>
                        </div> -->
            ​        <!--_____________________________________________________________-->

                    <!--Modelo-->
                        <!-- <div class="form-group">
                            <label for="Modelo" >Modelo:</label>
                            <input type="text" class="form-control" id="modelo" name="modelo">
                        </div> -->
            ​        <!--_____________________________________________________________-->

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <!--Capacidad-->
                        <!-- <div class="form-group">
                            <label for="Capacidad" >Capacidad:</label>
                            <input type="text" class="form-control" id="Capacidad" name="capacidad">
                        </div> -->
            ​        <!--_____________________________________________________________-->

                    <!--Tara-->
                        <!-- <div class="form-group">
                            <label for="Tara" >Tara:</label>
                            <input type="text" class="form-control" id="Tara" name="tara" >
                        </div> -->
            ​        <!--_____________________________________________________________-->   
                    <!--Ubicacion-->
                        <div class="form-group">
                            <label for="ubicacion">Ubicacion:</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" >
                        </div>
                    <!--_____________________________________________________________-->    
 

                    <!--Habilitacion-->
                        <!-- <div class="form-group">
                            <label for="Habilitacion" >Habilitacion:</label>
                            <input type="text" class="form-control" id="Habilitacion" name="habilitacion" >
                        </div> -->
            ​        <!--_____________________________________________________________-->    

                    <!--Registro-->
                        <div class="form-group">
                            <label for="codigo" >Codigo:</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" >
                        </div>
            ​        <!--_____________________________________________________________--> 

                    <!--Fecha de habilitacion-->
                        <div class="form-group" >
                            <label for="fecha_ingreso" >Fecha de Ingreso:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" id="fecha_ingreso" name="fecha_ingreso">
                            </div>
                           
                        </div>
            ​        <!--_____________________________________________________________-->

                   

                </div>

                    <!--__________________SEPARADOR__________________-->            

                <div class="col-md-12"><hr></div>

                    <!--__________________SEPARADOR__________________-->

<!--                    
                        <div class="col-md-6">
                            <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                                <input type="file" name="imagen" id="img_File" onchange="convertA()" style="font-size: smaller" id="img_Id">
                                <input type="text" id="input_aux_img" style="display:none" >
                            </form>
                            <img src="" alt="" id="img_Base" width="" height="">
                        </div> -->
                    <!--_____________________________________________-->           
                    <!--_____________________________________________________________-->            

                <div class="col-md-12"><hr></div><br>

                    <!--Boton de guardado--> 
                        <button type="submit" class="btn btn-primary pull-right" onclick="GuardarVhiculo()">Guardar</button>
                    <!--_____________________________________________________________--> 

            </form>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN BOX---//////////////////////////////////////----->

<!---//////////////////////////////////////--- TABLA ---//////////////////////////////////////----->

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



    <!---//////////////////////////////////////--- MODAL EDITAR ---//////////////////////////////////////----->

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title titulo" id="exampleModalLabel">Editar Vehiculo</h5>
            </div>

            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL __________________-->

            <form class="formVehiculoEdit" id="formVehiculoEdit"  method="POST" autocomplete="off" class="registerForm">
                <div class="modal-body">
                    <div class="col-md-6 col-sm-6 col-xs-12">
        
                        <!--Descripcion-->
                            <div class="form-group">
                                <label for="descripcion" >Descripcion:</label>
                                <br>
                                <input type="text" class="form-control habilitar" id="e_descripcion" name="descripcion">
                            </div>

                            <div class="form-group"  style="display:none">
                                <input type="text" class="form-control habilitar" id="e_equi_id" >
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Dominio-->
                            <div class="form-group">
                                <label for="dominio">Dominio:</label>
                                <br>
                                <input type="text" class="form-control habilitar" id="e_dominio" name="dominio">
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Marca-->
                            <div class="form-group">
                                <label for="marca" >Marca:</label>
                                <br>
                                <input type="text" class="form-control habilitar" id="e_marca" name="marca">
                            </div>
            ​            <!--_____________________________________________________________-->

                        <!--Condicion-->
                            <!-- <div class="form-group">
                                <label for="condicion" >Condicion:</label>
                                <select class="form-control select2 select2-hidden-accesible" id="" name="e_condicion" >
                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                    foreach ($condicion as $i) {
                                        echo '<option>'.$i->nombre.'</option>';
                                    }
                                    ?>
                                </select>
                            </div> -->
            ​            <!--_____________________________________________________________-->

                        <!--Modelo-->
                            <!-- <div class="form-group">
                                <label for="Modelo" >Modelo:</label>
                                <input type="text" class="form-control" id="" name="e_modelo">
                            </div> -->
            ​            <!--_____________________________________________________________-->

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <!--Ubicacion-->
                        <div class="form-group">
                                <label for="ubicacion">Ubicacion:</label>
                                <input type="text" class="form-control habilitar" id="e_ubicacion" name="ubicacion" >
                            </div>
                        <!--_____________________________________________________________-->   
                        <!--Registro-->
                        <div class="form-group">
                            <label for="codigo" >Codigo:</label>
                            <br>
                            <input type="text" class="form-control habilitar" id="e_codigo" name="codigo" >
                        </div>
            ​           <!--_____________________________________________________________--> 

                         <div class="form-group">
                            <label for="tran_id" >Transportista:</label>
                            <select class="form-control select2 select2-hidden-accesible" id="e_tran_id" name="tran_id" >
                                <option value="" selected class="habilitar ocultar " ></option>
                            </select>
                        </div> 
                     

                        <!--Capacidad-->
                            <!-- <div class="form-group">
                                <label for="Capacidad" >Capacidad:</label>
                                <input type="text" class="form-control" id="" name="e_capacidad">
                            </div> -->
            ​            <!--_____________________________________________________________-->

                        <!--Tara-->
                            <!-- <div class="form-group">
                                <label for="Tara" >Tara:</label>
                                <input type="text" class="form-control" id="" name="e_tara" >
                            </div> -->
            ​            <!--_____________________________________________________________-->

                        <!--Habilitacion-->
                            <!-- <div class="form-group">
                                <label for="Habilitacion" >Habilitacion:</label>
                                <input type="text" class="form-control" id="" name="e_habilitacion" >
                            </div> -->
            ​            <!--_____________________________________________________________-->

                        <!--Registro-->
                            <!-- <div class="form-group">
                                <label for="Registro" >Registro:</label>
                                <input type="text" class="form-control" id="" name="e_registro" >
                            </div> -->
            ​            <!--_____________________________________________________________-->

                        <!--Fecha de habilitacion-->
                            <div class="form-group" >
                                <label for="FechaIngreso" >Fecha de Ingreso:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control habilitar" name="" id="id_fecha_ingreso">
                                    <!-- <input type="date" class="form-control pull-right habilitar" id="e_fechaingreso" name="FechaIngreso"> -->
                                </div>
                             
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
                </div>
            </form>

            <!--__________________ FIN FORMULARIO MODAL __________________-->

            </div>
            <div class="col-md-12"><hr></div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave_e">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---//////////////////////////////////////----->
<!---//////////////////////////////////////--- MODAL BORRAR ---///////////////////////////////////////////////////////----->
    
<div class="modal fade" id="modalBorrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"> Eliminar Vehiculo</h5>
            </div>
            <div class="modal-body">

           <input type="text" id="id_vehiculo" style="display:none">

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btndelete" onclick="deletevehiculo()">Aceptar</button>
                    <button type="submit" class="btn btn-default" id="btncancelar" data-dismiss="modal" id="cerrar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- SCRIPTS---//////////////////////////////////////----->

<!--_____________________________________________________________-->

<!-- script que muestra box de datos al dar click en boton agregar -->
<script>

function cargartransportistas($dato){
    $("#e_tran_id")[0][0].value = ""; 
    $("#e_tran_id")[0][0].text = "Cargando.."; 
    $("#tran_ver").val('Cargando..');
   
    $.ajax({
                type: "POST",
                data: {},
                url: "general/Estructura/Vehiculo/ObtenerTransportistas",
                success: function ($dato) {
                    console.table("json son decodificar: "+$dato);
                    var res = JSON.parse($dato); // decodifico el dato que obtuve en formato json
                  
                    console.table("json decodificado: "+res);                  
                                      
                    $select = $("#e_tran_id"); 
                    console.table($select[0].length);
                    for(var i=1; i <= $("#e_tran_id")[0].length-1 ;i++){
                            $("#e_tran_id")[0][i].selected = "false";
                        }  
                    if ($dato) {
                        
                        for(var i=0; i <= res.tran.length-1; i++){
                           
                            if($dato.tran_id == res.tran[i].tran_id){
                                $select[0][0].selected = "true";
                                $select[0][0].text = res.tran[i].razon_social;
                                $select[0][0].value = res.tran[i].tran_id;
                                $("#tran_ver").val(res.tran[i].razon_social);
                            }
                        }
                       
                        if($select[0].length == 1)
                        {
                            for(var i=0; i <= res.tran.length-1; i++){
                                
                              
                                    $select.append( $('<option />',{ value:res.tran[i].tran_id, text:res.tran[i].razon_social }) );
                                
                            }
                        }
                      
                     } else {
                       
                        alert("error");
                    }
                }
            });
}
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);
        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });

    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });

//Modal Editar
    $(".btnEditar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $(".titulo").text('Editar Vehiculo');
    $('#btnsave_e').show(); 
    $(".habilitar").removeAttr("readonly");
    $("#div_ver").attr("style","display:none");
    $("#tran_ver").attr("style","display:none");
    $(".ocultar").removeAttr("style");
    $("#e_descripcion").val( data.descripcion);
    $("#e_marca").val(data.marca); 
    $("#e_dominio").val(data.dominio);
    $("#e_codigo").val(data.codigo);
    $("#e_ubicacion").val(data.ubicacion);
    $("#e_fechaingreso").val(data.fecha_ingreso);
    $("#id_fecha_ingreso").val(data.fecha_ingreso);
    console.table($("#id_fecha_ingreso").val());
    $("#e_equi_id").val(data.equi_id);
    cargartransportistas(data);
    });

//Modal Info
    $(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $(".titulo").text('Informacion Vehiculo');
    $('#btnsave_e').hide();
    $(".habilitar").attr("readonly","readonly"); 
    $("#div_ver").removeAttr("style");
    $("#tran_ver").removeAttr("style");
    $("#tran_ver").attr("readonly","readonly");
    $(".ocultar").attr("style","display:none");
    $("#e_descripcion").val( data.descripcion);
    $("#e_marca").val(data.marca); 
    $("#e_dominio").val(data.dominio);
    $("#e_codigo").val(data.codigo);
    $("#e_ubicacion").val(data.ubicacion);
    $("#e_fechaingreso").val(data.fecha_ingreso);
    $("#id_fecha_ingreso").val(data.fecha_ingreso);
    console.table($("#id_fecha_ingreso").val());
    cargartransportistas(data);
    });

//Modal Eliminar
    $(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $('#btndelete').show();    
    $("#id_vehiculo").val(data.equi_id);
});



</script>
​<!--_____________________________________________________________-->
<script>
function GetFile(file){
		var reader = new FileReader();
		return new Promise((resolve, reject) => {
			reader.onerror = () => {
				reader.abort();
				reject(new Error("Error parsing file"));
			}
			reader.onload = function() {
				//This will result in an array that will be recognized by C#.NET WebApi as a byte[]
				let bytes = Array.from(new Uint8Array(this.result));
				//if you want the base64encoded file you would use the below line:
				let base64StringFile = btoa(bytes.map((item) => String.fromCharCode(item)).join(""));
				//Resolve the promise with your custom file structure
				resolve({
					bytes: bytes,
					base64StringFile: base64StringFile,
					fileName: file.name,
					fileType: file.type
				});
			}
			reader.readAsArrayBuffer(file);
		});
	}

async function convertA(){
       
       
       var file = document.getElementById('img_File').files[0];
       console.table(document.getElementById('img_File').files[0]);
           if (file) {
               var archivo = await GetFile(file);
               console.table(archivo);
               if(archivo.fileType == "image/jpeg"){
                  var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
                  //var cod = "data:image/png;base64,"+archivo.base64StringFile;
                    $("#input_aux_img").val(cod);
                    $("#img_Base").attr("src",$("#input_aux_img").val());
                    $("#img_Base").attr("width",100);
                    $("#img_Base").attr("height",100);
               }else{
                   if(archivo.fileType == "application/pdf"){
                      var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
                   }
                 
               }
               
                $("#input_aux_img").val(cod);
                console.table($("#input_aux_img").val());
                
               
           }
          
           
           
   }



</script>

<!--Script de guardado pantalla Registrar Vehiculo-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Vehiculo/Listar_Vehiculo");

    function GuardarVhiculo() {

        var datos = new FormData($('#formVehiculo')[0]);
        datos = formToObject(datos);
        //datos.imagen = $("#input_aux_img").val();
        //datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
        
        
        console.table(datos);
  
        //--------------------------------------------------------------

        if ($("#formVehiculo").data('bootstrapValidator').isValid()) {
            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Vehiculo/Guardar_Vehiculo",
                success: function (r) {
                    console.log(r);
                    if (r == "ok") {

                       $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Vehiculo/Listar_Vehiculo");
                        alertify.success("Agregado con exito");

                        $('#formVehiculo').data('bootstrapValidator').resetForm();
                        $("#formVehiculo")[0].reset();

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

    


//Funcion Editar el vehiculo

    $("#btnsave_e").click(function(e){
        var vehiculo = new FormData();
        vehiculo = formToObject(vehiculo);
        vehiculo.equi_id = $("#e_equi_id").val();
        vehiculo.descripcion = $("#e_descripcion").val();
        vehiculo.marca = $("#e_marca").val();
        vehiculo.codigo = $("#e_codigo").val();
        vehiculo.ubicacion =  $("#e_ubicacion").val();
        vehiculo.tran_id =  $("#e_tran_id").val();
        vehiculo.dominio = $("#e_dominio").val();
        vehiculo.fecha_ingreso = $("#id_fecha_ingreso").val();
        console.table(vehiculo);
        //faltaria la ubicaion, el codigo y tran_id
        $.ajax({
                type: "POST",
                data: {vehiculo},
                url: "general/Estructura/Vehiculo/Actualizar_Vehiculo",
                success: function (r) {
                    
                    console.table(r);
                    if (r == "ok") {
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Vehiculo/Listar_Vehiculo");
                        alertify.success("Actualizado con exito");
                        $("#modalEdit").modal('hide');
                       

                      

                    } else {
                        
                        alertify.error("error al actualizar");
                    }
                }
            });

    });

//Funcion Eliminar Vehiculo
     function deletevehiculo(){
        var eliminar = new FormData();
        eliminar = formToObject(eliminar);
        eliminar.equi_id = $("#id_vehiculo").val();
       // datos.eliminado = 1;
        console.table(eliminar);
        $.ajax({
                type: "POST",
                data: {eliminar},
                url: "general/Estructura/Vehiculo/Borrar_Vehiculo",
                success: function (r) {
                    console.table(r);
                    if(r == "ok") {
                        $('#btndelete').hide();
                        $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Vehiculo/Listar_Vehiculo");
                         alertify.success("Contenedor Eliminado con exito");
                         $("#modalBorrar").modal('hide');
                    } else {                        
                        alertify.error("error al Eliminar");
                        
                    }
                }
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
            tran_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            ubicacion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            codigo: {
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
                }  
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
        //guardar();
    });
</script>
​<!--_____________________________________________________________-->

<!--Script Bootstrap Validacion.MODAL EDITAR -->
<script>
    $('#formVehiculoEdit').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
           e_descripcion: {
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
            e_dominio: {
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
            e_marca: {
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
            e_condicion: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            e_modelo: {
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
            e_capacidad: {
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
            e_tara: {
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
            e_habilitacion: {
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
            e_registro: {
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
            e_fechahabilitacion: {
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
<!--_____________________________________________________________-->