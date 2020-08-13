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

    <!--__________________________________________________________________________________________-->

    <div class="box-body">
        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Codigo / Registro-->
                    <div class="form-group">
                        <label for="codigo" >Codigo / Registro:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="text" class="form-control" name="codigo" id="codigo">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Descripcion-->
                    <div class="form-group">
                        <label for="descripcion" >Descripcion:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="text" class="form-control" name="descripcion" id="descripcion">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Capacidad-->
                    <div class="form-group">
                        <label for="capacidad" >Capacidad:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="number" class="form-control" name="capacidad" id="capacidad">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="anio_elaboracion">Año de elaboracion:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" class="form-control"  name="anio_elaboracion" id="anio_elaboracion">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->
                <!--Adjuntar imagen--> 
                <div class="form-group">
                            
                                <label for="img_File">Seleccione Imagen</label>
                                <input type="file" name="imagen" id="img_File" onchange="convertA()" style="font-size: smaller">
                                <input type="text" id="input_aux_img" style="display:none" >
                                <img src="" alt="" id="imagen" width="" height="">
                </div>
                <!--Asociar Recipiente-->
                    <!--<div class="form-group">
                        <label for="Recipiente">Asociar Recipiente:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <select class="form-control select2 select2-hidden-accesible" name="reci_id" id="reci_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        // foreach ($Recipiente as $i) {
                                        //     echo '<option  value="'.$i->reci_id.'">'.$i->nombre.'</option>';
                                        // }
                                    ?>
                            </select>
                        </div>
                    </div>-->

                <!--__________________________________________________________________________________________-->

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Tara-->
                    <div class="form-group">
                        <label for="tara" >Tara:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <input type="number" class="form-control" name="tara" id="tara">
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Estado-->
                    <div class="form-group">
                        <label for="esco_id">Estado:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>                    
                            <select class="form-control select2 select2-hidden-accesible" name="esco_id" id="esco_id">
                                <option value="" disabled  selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($Estados as $i) {
                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->

                <!--Habilitacion-->
                    <div class="form-group">
                        <label for="habilitacion" >Habilitacion:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <select class="form-control select2 select2-hidden-accesible" name="habilitacion" id="habilitacion">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($Habilitacion as $i) {
                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->
                <!--__________________________________________________________________________________________-->

                <!--Habilitacion-->
                <div class="form-group">
                        <label for="tran_id" >Transportista:</label>
                        <div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                            <select class="form-control select2 select2-hidden-accesible" name="tran_id" id="tran_id">
                                <option value="" disabled selected>-Seleccione opcion-</option>
                                    <?php
                                        foreach ($transportista as $k) {
                                            echo '<option  value="'.$k->tran_id.'">'.$k->razon_social.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                <!--__________________________________________________________________________________________-->
               
                
                 <!--Tipo carga-->                
                    <div class="form-group">
                        <label for="ticaid">Tipo de residuo:</label>
                        <div class="input-group date" id="carg">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="ticco_id" name="ticaid" required>
                            
                                    <?php
                                        foreach ($Carga as $i) {
                                            

                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                                </select>
                        </div>
                     </div>                
                <!-- ______________________________________________________________________________________________ -->
                <!--Año de elaboracion-->
                    <div class="form-group">
                        <label for="fec_alta">Fecha alta:</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" class="form-control"  name="fec_alta" id="fec_alta">
                        </div>
                    </div>      
                <!--__________________________________________________________________________________________-->

            </div>
            <!-- <div class="col-md-12 col-sm-12 col-xs-12"><hr></div> -->
           
                <!--Adjuntar imagen-->
                    <!-- <div class="col-md-6">
                        <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                            <input type="file" name="imagen">
                        </form>
                    </div>-->
                <!--__________________________________________________________________________________________-->

            <!-- <div class="col-md-12 col-sm-12 col-xs-12"><hr></div> -->

                <!--Boton de guardado-->
                    <!-- <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Contenedor()">Guardar</button>
                    </div>             -->
                <!--__________________________________________________________________________________________-->

        </form>
    </div>
    <div class="modal-footer">
					<div class="form-group text-right">
                        <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Contenedor()">Guardar</button>
					</div>
	</div>

</div>

<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

    <!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->

    <div class="box box-primary">
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>

                <!--__________________TABLA___________________________-->

                <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla"></div>

                <!--__________________TABLA___________________________-->       

            </div>
        </div>
    </div>

    <!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->

<!---//////////////////////////////////////--- SCRIPTS ---///////////////////////////////////////////////////////----->

<!--__________________________________________________________________________________________-->
<script>
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
<!-- Script Boton Agregar-->
<script>
    //Script Boton Agregar
    $("#botonAgregar").on("click", function() {
        //crea un valor aleatorio entre 1 y 100 y se asigna al input nro
        var aux = "";
				$("#imagen").attr("src",aux);
				$("#input_aux_img").val(aux);
        var aleatorio = Math.round(Math.random() * (100 - 1) + 1);
        $("#nro").val(aleatorio);
        $("#botonAgregar").attr("disabled", "");
        //$("#boxDatos").removeAttr("hidden");
        $("#boxDatos").focus();
        $("#boxDatos").show();
    });

    // Script Boton Cerrar
    $("#btnclose").on("click", function() {
        $("#boxDatos").hide(500);
        $("#botonAgregar").removeAttr("disabled");
        $('#formContenedores').data('bootstrapValidator').resetForm();
        $("#formContenedores")[0].reset();
        $('#selecmov').find('option').remove();

    });
</script>
<!--__________________________________________________________________________________________-->

<!-- Registrar Contenedores-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor");
    function Guardar_Contenedor() {
        var datos_tipo_carga= $('#ticco_id').val();   
        // datos = $('#formContenedores').serialize();

        var datos = new FormData();
        datos = formToObject(datos);
        datos.imagen =  $("#input_aux_img").val();
        datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario         
        datos.tran_id = $("#tran_id").val();
        datos.fec_alta = $("#fec_alta").val();
        datos.habilitacion = $("#habilitacion").val(); 
        datos.tara = $("#tara").val();
        datos.esco_id = $("#esco_id").val();
        datos.codigo = $("#codigo").val();
        datos.capacidad =  $("#capacidad").val();
        datos.anio_elaboracion =  $("#anio_elaboracion").val();
        datos.descripcion = $("#descripcion").val();
        console.table(datos);
        console.table(datos_tipo_carga);

        //--------------------------------------------------------------

        if ($("#formContenedores").data('bootstrapValidator').isValid()) {

            if($("#input_aux_img").val()!="")
            {
                    $.ajax({
                    type: "POST",
                    data: {datos, datos_tipo_carga},
                    url: "general/Estructura/Contenedor/Guardar_Contenedor",
                    success: function (r) {
                        
                        console.table(r);
                        if (r == "ok") {

                            $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor");
                            alertify.success("Agregado con exito");

                            $('#formContenedores').data('bootstrapValidator').resetForm();
                            $("#formContenedores")[0].reset();

                            $("#boxDatos").hide(500);
                            $("#botonAgregar").removeAttr("disabled");

                        } else {
                            //console.table(r);
                            alertify.error("error al agregar");
                        }
                    }
                });
            }else{
                alert("ATENCION!!! No Cargo una Imagen ");
            }
           
        }else{
            alert("ATENCION!!! Hay campos sin completar");
        }
    }
</script>
<!--__________________________________________________________________________________________-->

<!--Script Bootstrap Validacion.-->

<script>
$(document).ready(function() {
$('#formContenedores').bootstrapValidator({
				message: 'This value is not valid',
				// feedbackIcons: {
				// 		valid: 'glyphicon glyphicon-ok',
				// 		invalid: 'glyphicon glyphicon-remove',
				// 		validating: 'glyphicon glyphicon-refresh'
				// },
				//excluded: ':disabled',
				fields: {
                            codigo: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            },
                            regexp: {
                                regexp: /^(0|[1-9][0-9]*)$/ ,
                                message: 'la entrada debe ser un numero entero'
                            }
                        }
                    },
                    descripcion: {
                        message: 'la entrada no es valida',
                            validators: {
                            notEmpty: {
                                 message: 'la entrada no puede ser vacia'
                                 }
                                }          
                    },
                    fec_alta: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }        
                        }
                    },
                    anio_elaboracion: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }
                        }
                    },
                    tara: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            },
                            regexp: {
                                regexp: /^[+-]?((\d+(\.\d+)?)|(\.\d+))$/,
                                message: 'la entrada debe ser un numero entero'
                            }
                        }
                    },
                    esco_id: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }
                        }
                    },
                    
                    capacidad: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            },
                            regexp: {
                                regexp: /^[+-]?((\d+(\.\d+)?)|(\.\d+))$/,
                                message: 'la entrada debe ser un numero entero'
                            }
                        }
                    },
                    habilitacion: {
                        message: 'la entrada no es valida',
                        validators: {
                            notEmpty: {
                                message: 'la entrada no puede ser vacia'
                            }
                        }
                    },
                    ticaid: {
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
                    }
				}
		// }).on('success.form.bv', function(e) {
		// 		e.preventDefault();
				//guardar();
		});
});

</script>
<script>
  
    //Initialize Select2 Elements
    $('.select3').select2();
</script>
<!--__________________________________________________________________________________________-->

<!--
'<div class="text-center">
<button type="button" title="Editar"  onclick="clickedit('+aux+')" class="btn btn-primary btn-circle"  data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
<button type="button" title="Info" onclick="clickinfo('+aux+')" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalInfo"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
<button type="button" title="eliminar" onclick="borrar('+aux+')" class="btn btn-primary btn-circle"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp
</div>',
-->