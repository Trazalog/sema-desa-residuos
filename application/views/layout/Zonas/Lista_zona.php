    <!--__________________HEADER TABLA___________________________-->
  <div id="lista_zona">  
    <div id="tabla">
    <table id="tabla_zonas" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">

            <th>Acciones</th>
            <th>Nombre</th>
            <th>Departamento</th>
            <th>Descripcion</th>
            
           
            

        </thead>

        <!--__________________BODY TABLA___________________________-->

    <tbody >
    <?php
    if($zonas)
    {
        foreach($zonas as $fila)
        {
        
        echo "<tr data-json='".json_encode($fila)."'>";
      
        echo    '<td>';
        echo    '<button  type="button" title="Editar"  class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit" id="btnEditar"  ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
            <button type="button" title="Info" class="btn btn-primary btn-circle btnVer" data-toggle="modal" data-target="#modalEdit" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
            <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar" id="btnBorrar"  ><span class="glyphicon glyphicon-trash" aria-hidden="true" ></span></button>&nbsp';
        echo '</td>';         
            
        echo    '<td >'.$fila->nombre.'</td>';
        echo    '<td>'.$fila->depa_nom.'</td>';                       
        echo    '<td>'.$fila->descripción.'</td>';
       
    
        echo '</tr>';
    }
    }
    ?>
    </tbody>
   
    </table>
    </div>
 </div>
    <!--__________________FIN TABLA___________________________-->
    <!---//////////////////////////////////////--- MODAL EDITAR ---///////////////////////////////////////////////////////----->
    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close btn-cerrar-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title titulo" id="exampleModalLabel">Editar  Zona</h5>
            </div>
            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" id="formModalEdit" autocomplete="off" id="" class="registerForm">
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-md-12 " style="margin-left: 6rem;">
                            <div class="col-md-6 col-sm-6">

                                <!--Nombre-->
                                <div class="form-group">
                                    <label for="Nombre" name="nombre">Nombre:</label>
                                    <br>
                                    <input type="text" class="form-control habilitar estilo" id="nom_id" name="nom_id" style="width: 40rem;">
                                    
                                    
                                </div>
                                <!--_____________________________________________-->
                                    
                                <!--Descripcion-->
                                <div class="form-group">
                                    <label for="Descripcion" name="">Descripcion:</label>
                                    <input type="text" class="form-control habilitar estilo custom" id="desc_id" name="desc_id" style="width: 40rem;">
                                </div>
                                <!--_____________________________________________-->

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 " style="margin-left: 6rem;">
                            <div class="col-md-6 col-sm-6">
                            
                                    <div class="form-group" id="div_ver" style="display:none">
                                            
                                            <label for="Dptoo" name="">Departamento:</label> 
                                            <input   type="text" class="form-control estilo" id="dep_ver" name="dep_ver" style="width: 40rem;">
                                        
                                    </div>
                                    <!--Departamento-->
                                    <div class="form-group">
                                        <label for="Dpto" name="" id="texto_dep">Departamento:</label> 
                                        <br>
                                        <select class="form-control select2 select2-hidden-accesible habilitar estilo" id="dep_id" name="dep_id" style="width: 40rem;">
                                            <option value="" selected  id="opt_sel" class="habilitar ocultar " ></option>

                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12"><br></div>
                                    <!--Imagen-->
                                    <div class="form-group">
                                        <label for="CircR" name="img">Adjuntar Imagen:</label>
                                        <input type="file" class="ocultar"  name=img id="img_file" onchange="convert()" style="font-size: smaller" id="files">
                                        <div class="col-md-12"><br></div>
                                        <input type="text" id="input_aux_img64" style="display:none" >
                                        <input type="text" id="input_aux_zonaID" style="display:none" >  
                                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>          
                                        <br>   
                                        <a  id="etiqueta"><p><img src="" alt="no hay imagen! cargue una" id="img_base" width="" height=""> </p></a>                       
                                        <!-- <img src="" alt="no hay imagen! cargue una" id="img_base" width="" height=""> -->
                                    
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
                    <button type="submit" class="btn btn-default cerrarModalEdit" id="btnsave" data-dismiss="modal" id="cerrar">Cerrar</button>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!---//////////////////////////////////////--- FIN MODAL EDITAR ---///////////////////////////////////////////////////////----->
 <!---//////////////////////////////////////--- MODAL BORRAR ---///////////////////////////////////////////////////////----->
    
 <div class="modal fade" id="modalBorrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"> Eliminar Zona</h5>
            </div>
            <div class="modal-body">

           <input type="text" id="id_zona" style="display:none">

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btndelete">Aceptar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal" id="cerrar">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->



<!-- --------------------------------script para modal editar----------------------------------------- -->
<script>
$(document).ready(function(){		
                var aux= "";	
				$("#img_base").val(aux);
				$(".fa-spinner").hide();
               
		});
$(".cerrarModalEdit").click(function(e){
    $("#formModalEdit").data('bootstrapValidator').resetForm();
   
});
$(".btn-cerrar-modal").click(function(e){
    $("#formModalEdit").data('bootstrapValidator').resetForm();
   
});


//Convertir a base64 el archivo Imagen
function getFile(file){
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

</script>
<script>

function cargarImg(){
   
    var val = $("#input_aux_img64").val();

    console.table(val);
    $("#img_base").attr("src",val);
   
    return;
   
}
</script>

<script>
async function convert(){
       
 
     var file = document.getElementById('img_file').files[0];
     console.table(document.getElementById('img_file').files[0]);
         if (file) {
             var archivo = await getFile(file);
             console.table(archivo);
             if(archivo.fileType == "image/jpeg"){
                var cod = "data:image/jpeg;base64,"+archivo.base64StringFile;
                //var cod = "data:image/png;base64,"+archivo.base64StringFile;
             }else{
                 if(archivo.fileType == "application/pdf"){
                    var cod = "data:application/pdf;base64,"+archivo.base64StringFile;
                 }
               
             }
             
             console.table(archivo.fileType);
              
              console.table(cod);
              $("#input_aux_img64").val(cod);
              console.table($("#input_aux_img64").val());
              $("#img_base").attr("src",$("#input_aux_img64").val());
              $("#img_base").attr("width",100);
              $("#img_base").attr("height",100);
              
             
         }
        
         
         
 }


function pdf($img_b64){
    var aux_link = "";
    for(var i=25; i <= $img_b64.length-1; i++){
                        aux_link = aux_link + $img_b64[i];
                         }
                         img = "data:application/pdf;base64,"+aux_link;
                        
                         var ref = img;
                         ref= ref+"G";
                         $("#input_aux_img64").val(ref);
                         console.table("aca con la G agregada"+ref);
                         $("#pdf").attr("href",ref);
                         $("#img_base").attr("src",$("#input_aux_img64").val());
                         $("#img_base").attr("width",100);
                         $("#img_base").attr("height",100);
}
function jpg($img_b64){
    var aux_link = "/";
    for(var i=21; i <= $img_b64.length-1; i++){
                        aux_link = aux_link + $img_b64[i];
                         }
                         img = "data:image/jpeg;base64,"+aux_link;
                         $("#input_aux_img64").val(img);
                         $("#img_base").attr("src",$("#input_aux_img64").val());
                         $("#img_base").attr("width",100);
                         $("#img_base").attr("height",100);
                         var ref = $("#input_aux_img64").val();
                         $("#pdf").attr("href",ref);

}




function ExtraerImg($zona){
    $(".fa-spinner").show();
    $("#img_base").hide();
    $.ajax({
                type: "POST",
                data: {zona_id: $zona.zona_id},
                url: "general/Estructura/Zona/GetImagen",
                success: function ($dato) {
                    $(".fa-spinner").hide();
                    var res = JSON.parse($dato);
                    console.table(res);
                    console.table(res.respuesta.imagen);
                   
                     var img_b64 = res.respuesta.imagen;
            
                   
                   if(img_b64[4]=='a'){
                    pdf(img_b64);
                   }else{
                       if(img_b64[4]=='i'){jpg(img_b64);}
                   }
                    $("#img_base").show();
                    console.table("Como queda src final: "+img_b64);
                    var auxx = $("#input_aux_img64").val();
                    $("#etiqueta").attr("href",auxx);
                    // var auxxx = "_blank";
                    // $("#etiqueta").attr("target",auxxx);
                }
            });

}
 

function Editar($zona) {
    
    $("#desc_id").val($zona.descripción);
    $("#nom_id").val($zona.nombre);
    $("#img_base").attr("src","");
    $("#dep_id")[0][0].value = ""; 
    $("#dep_id")[0][0].text = "Cargando.."; 
    $("#dep_ver").val('Cargando..');
    $("#input_aux_zonaID").val($zona.zona_id); // guardo el Id de zona para luego utilizarlo cuando guarde todo
    
    $.ajax({
                type: "POST",
                data: {zona_id: $zona.zona_id},
                url: "general/Estructura/Zona/MostrarModalEditar",
                success: function ($dato) {
                    console.table("json son decodificar: "+$dato);
                    var res = JSON.parse($dato); // decodifico el dato que obtuve en formato json
                  
                    console.table("json decodificado: "+res);                  
                                      
                    $select = $("#dep_id"); 
                    console.table($select[0].length);
                    for(var i=1; i <= $("#dep_id")[0].length-1 ;i++){
                            $("#dep_id")[0][i].selected = "false";
                        }  
                    if ($dato) {
                        
                        for(var i=0; i <= res.dep.length-1; i++){
                           
                            if($zona.depa_id == res.dep[i].depa_id){
                                $select[0][0].selected = "true";
                                $select[0][0].text = res.dep[i].nombre;
                                $select[0][0].value = res.dep[i].depa_id;
                                $("#dep_ver").val(res.dep[i].nombre);
                            }
                        }
                       
                         
                        
                        // console.table($("#dep_id"));
                        // console.table($("#dep_id")[0]);
                        // console.table($("#dep_id")[0][0].selected);
                        if($select[0].length == 1)
                        {
                            for(var i=0; i <= res.dep.length-1; i++){
                                
                              
                                    $select.append( $('<option />',{ value:res.dep[i].depa_id, text:res.dep[i].nombre }) );
                                
                            }
                        }
                      
                     } else {
                       
                        alert("error");
                    }
                }
            });
        
            ExtraerImg($zona);
           
}



</script>
<script>

//------------------------------------------------BOTON GUARDAR-------------------------------------
$("#btnsave").click(function(e){
    //---------------------todos los datos sin la imagen-------------------------
    var datos = new FormData();
    datos = formToObject(datos);

    datos.zona_id = $("#input_aux_zonaID").val();
    datos.nombre = $("#nom_id").val();
    datos.descripcion = $("#desc_id").val();
    datos.usuario_app = "nachete";
    datos.depa_id = $("#dep_id").val();
    console.table(datos);

    //-------------------solo id_zona e imagen en base 64-----------------------
    var datosImg = new FormData();
    datosImg = formToObject(datosImg);
    datosImg.zona_id = $("#input_aux_zonaID").val();
    datosImg.imagen = $("#input_aux_img64").val();
    console.table("datos de input_aux_img64: "+ $("#input_aux_img64").val());
    console.table(" datosImg.imagen: "+ datosImg.imagen);
    console.table(datosImg);
    var aux =0; 
    if(datos.nombre != "")
    {
        if(datos.descripcion != "")
        {
            if(datos.depa_id != "")
            {
                aux = 1;
                
            }
        }
     
    }
    if(aux == 1)
    {
        if( datosImg.imagen != "")
        {
            $.ajax({
                        type: "POST",
                        data: {datos, datosImg},
                        url: "general/Estructura/Zona/Actualizar_Zona",
                        success: function (r) {
                            console.table(r);
                            if (r == "ok") {
                                
                            // llama a listar_zona_Tabla el cual es  para recargar la tabla que muestra las zonas se le agrega el script para que tome los eventos
                            $("#tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Zona/Listar_Zona_tabla");
                                var URLactual = window.location;
                            
                                alertify.success("Modificado con exito");

                                $("#formModalEdit").data('bootstrapValidator').resetForm();
                                // $("#formModalEdit")[0].reset();
                            
                                $("#boxDatos").hide(500);
                                $("#botonAgregar").removeAttr("disabled");
                            
                            
                            } else {
                                //console.log(r);
                                alertify.error("error al Modificar");
                                $("#formModalEdit").data('bootstrapValidator').resetForm();
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


</script>

<script>
$(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json"));
    $('#btndelete').show(); 
   
        $("#id_zona").val(data.zona_id);  
        
});

//desactivacion de campos y acondicionamiento de modal editar
$(".btnVer").click(function(e){
    
    var data = JSON.parse($(this).parents("tr").attr("data-json"));
    $(".habilitar").attr("readonly","readonly");  
    $(".ocultar").attr("style","display:none");
    $("#dep_id").attr("style","display:none");
    $("#dep_ver").attr("readonly","readonly");
    $("#dep_ver").removeAttr("style");
    $("#div_ver").removeAttr("style");
    $('#btnsave').hide();
    $(".titulo").text('Ver Informacion');
    $("#texto_dep").text('');
    Editar(data);

});

//activavion de campos y acondicionamiento de modal editar 
$(".btnEditar").click(function(e){
    
    var data = JSON.parse($(this).parents("tr").attr("data-json"));   
   
    $('.habilitar').removeAttr("readonly");
    $(".ocultar").removeAttr("style");
    $("#dep_id").removeAttr("style");
    $(".ocultar").attr("style","font-size: smaller");
    $("#dep_ver").attr("style","display:none");
    $("#div_ver").attr("style","display:none");
    $('#btnsave').show(); 
    $(".titulo").text('Editar Zona');
    $("#texto_dep").text('Departamento:');
    Editar(data);

    
});
</script>


<script>
$("#btndelete").click(function(e){
    
    var datos = new FormData();
    datos = formToObject(datos);
    datos.zona_id = $("#id_zona").val();
    datos.eliminado = 1;
    

            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Zona/Eliminar_Zona",
                success: function (r) {
                    console.table(r);
                    if(r == "ok") {
                        $('#btndelete').hide();
                     
                       // llama a listar_zona_Tabla el cual es  para recargar la tabla que muestra las zonas se le agrega el script para que tome los eventos
                       $("#tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Zona/Listar_Zona_tabla");
                         alertify.success("Zona Eliminada con exito");
                       

                        $('#formZonas').data('bootstrapValidator').resetForm();
                        $("#formZonas")[0].reset();
                       
                        $("#boxDatos").hide(500);
                        $("#botonAgregar").removeAttr("disabled");

                    } else {
                        //console.log(r);
                        alertify.error("error al Eliminar");
                        
                    }
                }
            });


           


});

</script>


<!-- --------------------------------fin script modal editar----------------------------------------------- -->    
<!--Script Bootstrap Validacion.-->
<script>
    $('#formModalEdit').bootstrapValidator({
        message: 'This value is not valid',
        /*feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        //excluded: ':disabled',
        fields: {
            nom_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                }
            },
            desc_id: {
                message: 'la entrada no es valida',
                validators: {
                    notEmpty: {
                        message: 'la entrada no puede ser vacia'
                    }
                    
                }
            },
            dep_id: {
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
<script>
    //DataTable($('#tabla_zonas'));
    $('#tabla_zonas').DataTable({
  "aLengthMenu": [ 10, 25, 50, 100 ],
  "order": [[0, "asc"]],
});
</script>
       
           