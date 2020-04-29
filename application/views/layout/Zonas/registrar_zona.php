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
                    <!--_____________________________________________-->

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

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
                    <!--_____________________________________________-->

                </div>
                </div>
                <div class="col-md-12"> 

                    <!--Descripcion--> 
                        <div class="form-group">
                            <label for="Descripcion" >Descripcion:</label>
                            <textarea style="resize: none;" type="text" class="form-control input-sm" rows="5" id="Descripcion"
                                name="descripcion" required></textarea>                        
                        </div>
                    <!--_____________________________________________-->

                </div>
                <div class="col-md-12"><hr></div>

                    <!--Adjuntar imagen--> 
                        <div class="col-md-6">
                            <form action="cargar_archivo" method="post" enctype="multipart/form-data">
                                <input type="file" name="imagen" id="img_File" onchange="convertA()" style="font-size: smaller" id="img_Id">
                                <input type="text" id="input_aux_img" style="display:none" >
                            </form>
                            <img src="" alt="" id="img_Base" width="" height="">
                        </div>
                    <!--_____________________________________________-->

                <div class="col-md-12"><hr></div>

                    <!--Boton Guardar-->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right" onclick="Guardar_Zona()">Guardar</button>
                        </div>
                    <!--_____________________________________________-->

                </div>
                </div>
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
                    </div><br>
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

<!-- --------------------------------script para modal editar----------------------------------------- -->
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
<!-- --------------------------------fin script modal editar----------------------------------------------- -->    

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

<!-- Script que muestra box de datos al dar click en boton agregar -->
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

<!--Script de guardado y listado datatable pantalla |Registrar Zona|-->
<script>
    $("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Zona/Listar_Zona");
    function Guardar_Zona() {

        // datos = $('#formZonas').serialize();

        var datos = new FormData($('#formZonas')[0]);

        datos = formToObject(datos);
        datos.imagen = $("#input_aux_img").val();
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

<!--Script Datatable-->
<script>
    // DataTable($('#tabla_zonas'));
    // DataTable($('#tabla_circuitos'));
</script>
<!--_____________________________________________-->