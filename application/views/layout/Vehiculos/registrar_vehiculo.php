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
                                    <!--Tara-->
                    <div class="form-group">
                        <label for="Tara" >Tara:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="number" class="form-control" name="tara" id="tara">
                        </div>
                    </div>
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
                          <!--Adjuntar imagen--> 
                        <div class="form-group">
                            <form action="cargar_archivo" method="post" enctype="multipart/form-data"  id="fileimage">
                                <label for="img_File">Seleccione Imagen</label>
                                <input type="file" name="imagen" id="img_File" onchange="convertA()" style="font-size: smaller">
                                <input type="text" id="input_aux_img" style="display:none" >
                            </form>
                            <img src="" alt="" id="imagen" width="" height="">
                        </div>
                   

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
                        <button type="button" class="close cerrar_modal_e" data-dismiss="modal" aria-label="Close">
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
                                            <input type="text" class="form-control habilitar" id="e_descripcion" name="e_descripcion">
                                        </div>

                                        <div class="form-group"  style="display:none">
                                            <input type="text" class="form-control habilitar" id="e_equi_id" name="e_equi_id" >
                                        </div>
                                    <!--Dominio-->
                                        <div class="form-group">
                                            <label for="dominio">Dominio:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" id="e_dominio" name="e_dominio">
                                        </div>           ​            
                                    <!--Tara-->
                                    <div class="form-group">
                                        <label for="Tara" >Tara:</label>
                                        
                                        <br>
                                                <input type="number" class="form-control habilitar" name="taraedit" id="taraedit">
                                        
                                    </div>
                                    <!--Marca-->
                                        <div class="form-group">
                                            <label for="marca" >Marca:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" id="e_marca" name="e_marca">
                                        </div>       
                                               

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!--Ubicacion-->
                                    <div class="form-group">
                                            <label for="ubicacion">Ubicacion:</label>
                                            <input type="text" class="form-control habilitar" id="e_ubicacion" name="e_ubicacion" >
                                        </div>
                                    <!--Registro-->
                                    <div class="form-group">
                                        <label for="codigo" >Codigo:</label>
                                        <br>
                                        <input type="text" class="form-control habilitar" id="e_codigo" name="e_codigo" >
                                    </div>
                                    <!--TRansportista-->
                                    <div class="form-group ocultaTransedit">
                                        <label for="tran_id" >Transportista:</label>
                                        <select class="form-control select2 select2-hidden-accesible" id="e_tran_id" name="e_tran_id" >
                                            <option value=""  disabled selected  >-seleccione opcion-</option>
                                            <?php 
                                                                        foreach ($transportista as $j) { 
                                                                            echo '<option  value="'.$j->tran_id.'">'.$j->razon_social.'</option>'; 
                                                                        } 
                                            ?> 
                                        </select>
                                    </div> 
                                    <div class="form-group textTransinfo" style="display:none"> 
                                        <label for="tran_id_info">Transportista:</label> 
                                        <br> 
                                        <input type="text"  class="form-control" id="tran_id_info"> 
                                    </div>
                                    <!--Fecha de habilitacion-->
                                        <div class="form-group" >
                                            <label for="FechaIngreso" >Fecha de Ingreso:</label>
                                            <div class="input-group date">
                                            
                                                <input type="date" class="form-control habilitar" name="id_fecha_ingreso" id="id_fecha_ingreso">
                                            
                                            </div>
                                        
                                        </div>
                                         <!--__________________SEPARADOR__________________-->            

                                         <div class="col-md-12"><hr></div>

                                    
                                        <div class="form-group">
                                            <label for="CircR" name="img">Imagen:</label>
                                            <input type="file" class="ocultar" name=img id="img_file" onchange="convert()" style="font-size: smaller;" id="files" style="color:transparent;">
                                            <input type="text" id="input_aux_img64" style="display:none" >
                                            <input type="text" id="input_aux_zonaID" style="display:none" > 
                                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>  
                                            <br>                                
                                            <img src="" alt="no hay imagen! cargue una" id="img_base" width="" height="">
                                        </div>
                                </div>  
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    <div class="col-md-12"><hr></div>
                        <div class="form-group text-bootom">
                            <button type="submit" class="btn btn-primary" id="btnsave_e">Guardar</button>
                            <button type="submit" class="btn btn-default cerrar_modal_edit" id="btnsave" data-dismiss="modal">Cerrar</button>
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
				<h5 class="modal-title"><span class="fa fa-fw fa-times-circle" style="color:#A4A4A4"></span>Eliminar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<input id="id_vehiculo" style="display: none;">
			<div class="modal-body">
				<center>
					<h4>
						<p>¿Desea eliminar el vehiculo?</p>
					</h4>
				</center>
			</div>
            <div class="modal-footer">
                <center>
                    <button type="submit" class="btn btn-primary" id="btndelete" onclick="deletevehiculo()">SI</button>
                    <button type="submit" class="btn btn-default" id="btncancelar" data-dismiss="modal" id="cerrar">NO</button>
                </center>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->



<!---//////////////////////////////////////--- SCRIPTS---//////////////////////////////////////----->

<!--_____________________________________________________________-->

<!-- script que muestra box de datos al dar click en boton agregar -->
<script>

// deshabilita img y spinner	
$(document).ready(function(){		
                var aux= "";	
				$("#img_base").val(aux);
				$(".fa-spinner").hide();
               
		});

//Convertir a base64 el archivo Imagen
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
                    $("#imagen").attr("src",$("#input_aux_img").val());
                    $("#imagen").attr("width",100);
                    $("#imagen").attr("height",100);
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

    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formDatos').data('bootstrapValidator').resetForm();
        $("#formDatos")[0].reset();
        $('#selecmov').find('option').remove();
        $('#chofer').find('option').remove();
    });

    $(".cerrar_modal_edit").click(function(e){
    $("#formVehiculoEdit").data('bootstrapValidator').resetForm();
   
    });

    $(".cerrar_modal_e").click(function(e){
    $("#formVehiculoEdit").data('bootstrapValidator').resetForm();
   
});
//Modal Editar
    $(".btnEditar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    var fecha = data.fecha_ingreso;
    var fechaaux="";
    for(var i=0; i<fecha.length-6;i++)
    {
        fechaaux= fechaaux + fecha[i];
    }
    $(".titulo").text('Editar Vehiculo');
    $('#btnsave_e').show(); 
    $(".habilitar").removeAttr("readonly");
    $(".textTransinfo").attr("style","display:none"); 
    $(".ocultaTransedit").removeAttr("style"); 
    $("#div_ver").attr("style","display:none");
    $("#tran_ver").attr("style","display:none");
    $(".ocultar").removeAttr("style");
    $("#e_descripcion").val( data.descripcion);
    $("#e_marca").val(data.marca); 
    $("#e_dominio").val(data.dominio);
    $("#e_codigo").val(data.codigo);
    $("#e_ubicacion").val(data.ubicacion);
    $("#e_fechaingreso").val(fechaaux);
    $("#id_fecha_ingreso").val(fechaaux);
    console.table($("#id_fecha_ingreso").val());
    $("#e_equi_id").val(data.equi_id);
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid); 
    $("#taraedit").val(data.tara); 
    ExtraerImagen(data);
    });

//Modal Info
    $(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    var fecha = data.fecha_ingreso;
    var fechaaux="";
    for(var i=0; i<fecha.length-6;i++)
    {
        fechaaux= fechaaux + fecha[i];
    }
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
    $("#e_fechaingreso").val(fechaaux);
    $("#id_fecha_ingreso").val(fechaaux);
    $("#tran_id_info").attr("readonly","readonly");  
    console.table($("#id_fecha_ingreso").val());
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid); 
    $(".ocultaTransedit").attr("style","display:none"); 
    $(".textTransinfo").removeAttr("style"); 
    //para asiganrle nombre del transportista al input tipo text 
    $("#e_equi_id").val(data.equi_id); 
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid); 
    $sel = $("#e_tran_id"); 
    for(var j=0; j<= $sel[0].length-1; j++){ 
 
        if(data.tran_id == $sel[0][j].value) 
        { 
            $("#tran_id_info").val($sel[0][j].text); 
        } 
    } 
    $("#taraedit").val(data.tara); 
    ExtraerImagen(data);
    });

//Modal Eliminar
    $(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $('#btndelete').show();    
    $("#id_vehiculo").val(data.equi_id);
});



</script>
​<!--_____________________________________________________________-->


<!--Script de guardado pantalla Registrar Vehiculo-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Vehiculo/Listar_Vehiculo");

    function GuardarVhiculo() {

        var datos = new FormData($('#formVehiculo')[0]);
        datos = formToObject(datos);
        datos.imagen = $("#input_aux_img").val();
        datos.tara = $("#tara").val();
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
        vehiculo.imagen =  $("#input_aux_img64").val();
        vehiculo.tara =  $("#taraedit").val();
        console.table(vehiculo);
        //faltaria la ubicaion, el codigo y tran_id
        var aux =0; 
        if(vehiculo.descripcion != "")
        {
            if(vehiculo.dominio != "")
            {
                if(vehiculo.tara != "")
                {
                    if(vehiculo.marca != "")
                    {
                        if(vehiculo.ubicacion != "")
                        {
                            if(vehiculo.codigo != "")
                            {
                                if(vehiculo.tran_id != "")
                                {
                                    if(vehiculo.fecha_ingreso != "")
                                    {
                                        aux = 1;
                    
                                    }
                    
                                }
                    
                            }
                    
                        }
                    
                    }
                    
                }
            }
        
        }
        if(aux == 1)
        {
            if( vehiculo.imagen != "")
            {
                    $.ajax({
                        type: "POST",
                        data: {vehiculo},
                        url: "general/Estructura/Vehiculo/Actualizar_Vehiculo",
                        success: function (r) {
                            
                            console.table(r);
                            if (r == "ok") {
                                $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Vehiculo/Listar_Vehiculo");
                                alertify.success("Actualizado con exito");
                                $("#formVehiculoEdit").data('bootstrapValidator').resetForm();
                                $("#modalEdit").modal('hide');
                                

                            

                            } else {
                                
                                alertify.error("error al actualizar");
                                $("#formVehiculoEdit").data('bootstrapValidator').resetForm();
                            }
                        }
                    });
            }else{
                alert("Atencion!!! No ha cargado una imagen");
            }
        }else{
                alert("Atencion!!! hay un campo que esta vacio");
        }

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
            taraedit: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                      
                }
            },
            e_marca: {
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
            e_ubicacion: {
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
            e_codigo: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                     }
                    //   /*stringLength: {
                    //       min: 6,
                    //       max: 30,
                    //       message: 'The username must be more than 6 and less than 30 characters long'
                    //   },*/
                    // regexp: {
                    //     regexp: /^(0|[1-9][0-9]*)$/,
                    //     message: 'la entrada no debe ser un numero entero'
                    // }
                }
            },
            e_tran_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            id_fecha_ingreso: {
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