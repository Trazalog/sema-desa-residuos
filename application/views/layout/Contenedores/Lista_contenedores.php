<!--__________________HEADER TABLA___________________________-->
<div id="lista_cont">
<div id="tabla">
<table id="tabla_contenedores" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

        <th>Acciones</th>
        <th>Codigo / Registro</th>
        <th>Estado</th>
        <th>Capacidad</th>
        <th>Habilitacion</th>


    </thead>

    <!--__________________BODY TABLA___________________________-->

    <tbody>
        <?php
                    if($contenedores)
                    {
                        foreach($contenedores as $fila)
                        {
                            echo "<tr data-json='".json_encode($fila)."' data-carga='".json_encode($carga)."'>";
                            echo    '<td>';
                            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp
                                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                                
                            echo   '</td>';
                            echo    '<td>'.$fila->codigo.'</td>';
                            echo    '<td>'.substr("$fila->esco_id",17).'</td>'; //funcion substr("cadena de caracteres,n° posición del carácter desde la cual se comenzará la extracción") 17 por que hay que obviar estado_contenedor (0-16)
                            echo    '<td>'.$fila->capacidad.'</td>';
                            echo    '<td>'.$fila->habilitacion.'</td>';
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


<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title titulo" id="exampleModalLabel">Editar Contenedor</h5>
            </div>


            <div class="modal-body col-md-12 col-sm-12 col-xs-12">

                <!--__________________ FORMULARIO MODAL ___________________________-->

                <!-- <form method="POST" autocomplete="off" id="frmentrega" class="registerForm"> -->
                    <!-- <div class="modal-body"> -->
                        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off" class="registerForm">
                            <!-- <div class="col-md-12"> -->
                                <!-- <div class="row"> -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <!--Codigo / Registro-->
                                        <div class="form-group">
                                            <label for="Codigo/Registro">Codigo / Registro:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" name="" id="Codigo" style="width: 35rem;">
                                        </div>
                                        <!--_____________________________________________-->
                                        <br>
                                        <!--Descripcion-->
                                        <div class="form-group">
                                            <label for="Descripcion">Descripcion:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" name="" id="Descripcion" style="width: 35rem;">
                                        </div>
                                        <!--_____________________________________________-->
                                          <!--Cont_id solo para salvaguardar el id del contenedor-->
                                       
                                            <input type="text" class="form-control" name="" id="cont_id" style="display:none">
                                        
                                        <!--_____________________________________________-->
                                        <!--Capacidad-->
                                        <br>
                                        <div class="form-group">
                                            <label for="Capacidad">Capacidad:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" name="" id="Capacidad" style="width: 35rem;">
                                        </div>
                                        <!--_____________________________________________-->
                                        <br>
                                        <!--Año de elaboracion-->
                                        <div class="form-group">
                                            <label for="Añoelab">Año de elaboracion:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" name="" id="Añoelab" style="width: 35rem;">
                                        </div>
                                        <!--_____________________________________________-->

                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <!--Tara-->
                                        <div class="form-group">
                                            <label for="Tara">Tara:</label>
                                            <br>
                                            <input type="text" class="form-control habilitar" name="" id="Tara" style="width: 35rem;">
                                        </div>
                                        <!--_____________________________________________-->
                                        <br>
                                        <!--Estado-->
                                        <div class="form-group">
                                            <label for="Estados">Estado:</label>
                                            <br>
                                            <select class="form-control select2 select2-hidden-accesible selectores" name="" id="Estados" style="width: 35rem;">
                                                <option value="" disabled selected>-Seleccione opcion-</option>
                                                <?php
                                                        foreach ($estados as $i) {
                                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                                                                 }
                                                                                
                                                ?>
                                            </select>
                                            <input type="text" class="form-control ocultarInfo" name="" id="estadoInfo" style="display:none">
                                        </div>
                                        <br>
                                         <!--Habilitacion-->
                                            <div class="form-group">
                                              
                                                 <label for="Habilitacion" >Habilitacion:</label>
                                                  <br>   
                                                     
                                                <select class="form-control select2 select2-hidden-accesible selectores" name="" id="Habilitacion" style="width: 35rem;">
                                                    <option value="" disabled selected>-seleccione opcion-</option>
                                                        <?php
                                                            foreach ($habilitacion as $i) {
                                                                echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                                            }
                                                        ?>
                                                </select>
                                                <input type="text" class="form-control ocultarInfo" name="" id="habilitacionInfo" style="display:none">
                                            </div>    
                                    
                                    
                                        <br>
                                        <div class="form-group ocultar ">
                                            <label for="tipoResiduos">Tipo de residuo:</label>
                                            <br>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                                    <select class="form-control select3 habilitar  " multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tic_id">
                                                   
                  
                                                    </select>
                                                   
                                                    <!-- <input type="text" class="form-control habilitar" name="" id="tic" multiple> -->
                                            </div>  
                                            
                                        </div> 
                                        <br>
                                        <div class="form-group ocultar_Info " style="display:none">
                                            <label for="tipoResiduos">Tipo de residuo:</label>
                                            <br>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                                    <select class="form-control select3 habilitar  " multiple="multiple" disabled  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tic_id_info">
                                                   
                  
                                                    </select>
                                                   
                                                    <!-- <input type="text" class="form-control habilitar" name="" id="tic" multiple> -->
                                            </div>  
                                            
                                        </div>  
                                        <br>
                                        <div class="form-group">
                                                <label for="CircR" name="img">Imagen:</label>
                                                <input type="file" class="ocultar" name=img id="img_file" onchange="convert()" style="font-size: smaller" id="files">
                                                <input type="text" id="input_aux_img64" style="display:none" >
                                                <input type="text" id="input_aux_zonaID" style="display:none" >      
                                                <br>                             
                                                <img src="" alt="no hay imagen! cargue una" id="img_base" width="" height="">
                                                
                                   
                                 
                                   
                                   
                                        </div>
                                        
                                  
                                                                               
                                        <!--_____________________________________________-->
                                       
                                        
                                    </div>

                                  
                                <!-- </div>
                            </div> -->
                            


                        </form>
                    <!-- </div> -->
                <!-- </form> -->

                <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>

            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btncerrar" data-dismiss="modal">Cerrar</button>
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
                <h5 class="modal-title" id="exampleModalLabel"> Eliminar Contenedor</h5>
            </div>
            <div class="modal-body">

           <input type="text" id="id_contenedor" style="display:none">

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" id="btndelete">Aceptar</button>
                    <button type="submit" class="btn btn-default" id="btncancelar" data-dismiss="modal" id="cerrar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL BORRAR ---///////////////////////////////////////////////////////----->
<script>
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

</script>
<script>
function ExtraerImagen($data)
{
    $.ajax({
                type: "POST",
                data: {cont_id: $data.cont_id},
                url: "general/Estructura/Contenedor/GetImagen",
                success: function ($dato) {
                    
                    
                    var res = JSON.parse($dato);
                    console.table(res);
                    console.table(res.respuesta.imagen);
                   
                     var img_b64 = res.respuesta.imagen;
            
                   
                   if(img_b64[4]=='a'){
                    pdf(img_b64);
                   }else{
                       if(img_b64[4]=='i'){jpg(img_b64);}
                   }
                    
                    console.table("Como queda src final: "+img_b64);
                }
            });
}



</script>


<script>
//BOTON ELIMINAR

$(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $('#btndelete').show();    
    $("#id_contenedor").val(data.cont_id);
});



//BOTON VER INFO

$(".btnInfo").click(function(e){
    var aux2 = null;
    $("#input_aux_img64").val(aux2);
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    var datacarga = JSON.parse($(this).parents("tr").attr("data-carga"));
    $(".habilitar").attr("readonly","readonly"); 
    $("#tic_id").attr("disabled"); 
    $(".selectores").attr("style","display:none");
    $(".ocultar").attr("style","display:none"); 
    $(".ocultar_Info").removeAttr("style");
    $(".ocultarInfo").removeAttr("style");
    $('#btnsave').hide();
    $("#Codigo").val(data.codigo);
    $("#Descripcion").val(data.descripcion);
    $("#Capacidad").val(data.capacidad);
    $("#Añoelab").val(data.anio_elaboracion);
    $("#Tara").val(data.tara);
    $("#estadoInfo").val(data.esco_id.substr(17,30));
    $("#cargaInfo").val();
    $("#habilitacionInfo").val(data.habilitacion);
    $(".titulo").text('Informacion Contenedor');
    $("#estadoInfo").attr("readonly","readonly"); 
    $("#habilitacionInfo").attr("readonly","readonly"); 

    $("#tic_id_info").find('option').remove();


        var tipo = data.tipos_carga.tipoCarga;
        var aux = 0;

        for(var i=0; i <= datacarga.length-1; i++){
            aux = 0;
            for(var j=0; j <=tipo.length-1; j++){
                if(datacarga[i].valor == tipo[j].rsu)
                {
                $("#tic_id_info").append("<option selected disabled value= '"+datacarga[i].tabl_id+"'> " + datacarga[i].valor + "</option>");
                aux=1;
                j=tipo.length+1;
                }

            }
            if(aux==0){
                $("#tic_id_info").append("<option disabled value= '"+datacarga[i].tabl_id+"' >" + datacarga[i].valor + "</option>");
            } 
        
        }
  
ExtraerImagen(data);
});

//BOTON EDITAR
$(".btnEditar").click(function(e){
var aux2 = null;
$("#input_aux_img64").val(aux2);
var data = JSON.parse($(this).parents("tr").attr("data-json"));  
var datacarga = JSON.parse($(this).parents("tr").attr("data-carga"));
//para seguimiento despues borrar
console.table(data);
console.table(data.tipos_carga.tipoCarga);
console.table(datacarga[0].valor);
$(".habilitar").removeAttr("readonly");
$(".selectores").removeAttr("style");
$("#tic_id").removeAttr("disabled"); 
$(".ocultar").removeAttr("style");
$(".ocultar_Info").attr("style","display:none");
$(".ocultarInfo").attr("style","display:none");
$(".titulo").text('Editar Contenedor'); 
$('#btnsave').show(); 
//--------------------------------------
$("#Codigo").val(data.codigo);
$("#Descripcion").val(data.descripcion);
$("#Capacidad").val(data.capacidad);
$("#Añoelab").val(data.anio_elaboracion);
$("#Tara").val(data.tara);
$("#cont_id").val(data.cont_id);
$("#Estados")[0][0].selected = "false";
$("#Estados")[0][0].text = data.esco_id.substr(17,30);
$("#Estados")[0][0].value = data.esco_id;   
$("#Habilitacion")[0][0].selected = "false"; 
$("#Habilitacion")[0][0].text = data.habilitacion;
$("#Habilitacion")[0][0].value = data.habil_id;


$("#tic_id").find('option').remove();
var tipo = data.tipos_carga.tipoCarga;
var aux = 0;

for(var i=0; i <= datacarga.length-1; i++){
    aux = 0;
    for(var j=0; j <=tipo.length-1; j++){
        if(datacarga[i].valor == tipo[j].rsu)
        {
        $("#tic_id").append("<option selected value= '"+datacarga[i].tabl_id+"'> " + datacarga[i].valor + "</option>");
        aux=1;
        j=tipo.length+1;}
    }
    if(aux==0){
        $("#tic_id").append("<option value= '"+datacarga[i].tabl_id+"' >" + datacarga[i].valor + "</option>");
    } 
 
}
ExtraerImagen(data);
});


$("#btnsave").click(function(e){
    /////// para borrar el tipo carga paso 1
    var deletetipo = new FormData();
    deletetipo = formToObject(deletetipo);
    deletetipo.cont_id = $("#cont_id").val();
    deletetipo.eliminado = 1;
    ///////lor tipos a guardar paso 3
    var datos_tipo_carga= $("#tic_id").val(); 

   
    /////////////los datos del contenedor
    var datos = new FormData();
    datos = formToObject(datos);
    datos.codigo = $("#Codigo").val();
    datos.descripcion = $("#Descripcion").val();
    datos.capacidad = $("#Capacidad").val();
    datos.anio_elaboracion =  $("#Añoelab").val().substr(0,10);
    datos.tara = $("#Tara").val();
    datos.cont_id = $("#cont_id").val();
    datos.usuario_app = "hugoDS"; 
    datos.imagen = $("#input_aux_img64").val();
    var cont_id = $("#cont_id").val();
    if($("#Estados").val() != null)
    {   
        console.table($("#Estados").val());
        datos.esco_id = $("#Estados").val();
      

    }else{
        console.table($("#Estados")[0][0].value);
        datos.esco_id = $("#Estados")[0][0].value;
      
    }
    
    if($("#Habilitacion").val() != null){
        console.table($("#Habilitacion").val());
        datos.habilitacion = $("#Habilitacion").val();
    }else{
        console.table($("#Habilitacion")[0][0].value);
        datos.habilitacion = $("#Habilitacion")[0][0].value;
    }
 
   
    // console.table($("#Estados").val());
    // console.table("datos antes de entrar: ");
    // console.table(datos);
    // console.table("deltetipo antes de entrar: ");
    // console.table(deletetipo);
    // console.table("datos tipo carga antes de entrar: ");
    // console.table(datos_tipo_carga);
    // console.table("contid antes de entrar: ");
    // console.table(cont_id);
    
    
    $.ajax({
                type: "POST",
                data: {datos, deletetipo, datos_tipo_carga, cont_id },
                url: "general/Estructura/Contenedor/Actualizar_Contenedor",
                success: function (r) {
                    
                    console.table(r);
                    if (r == "ok") {
                        $("#tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor_Tabla");
                        alertify.success("Actualizado con exito");
                        $("#modalEdit").modal('hide');
                       

                      

                    } else {
                        
                        alertify.error("error al actualizar");
                    }
                }
            });

});

$("#btndelete").click(function(e){
    
    var datos = new FormData();
    datos = formToObject(datos);
    datos.cont_id = $("#id_contenedor").val();
    datos.eliminado = 1;
    console.table(datos);

            $.ajax({
                type: "POST",
                data: {datos},
                url: "general/Estructura/Contenedor/Borrar_Contenedor",
                success: function (r) {
                    console.table(r);
                    if(r == "ok") {
                        $('#btndelete').hide();
                        $("#tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/Contenedor/Listar_Contenedor_Tabla");
                         alertify.success("Contenedor Eliminado con exito");
                         $("#modalBorrar").modal('hide');
                    } else {                        
                        alertify.error("error al Eliminar");
                        
                    }
                }
            });

});
</script>

<script>
$('.select3').select2();
DataTable($('#tabla_contenedores'))
</script>
<script>
    //DataTable($('#tabla_zonas'));
  $('#tabla_contenedores').DataTable({
  "aLengthMenu": [ 10, 25, 50, 100 ],
  "order": [[0, "asc"]],
    "paging": false,
    "searching": false,
    "retrieve": true,
});

</script>