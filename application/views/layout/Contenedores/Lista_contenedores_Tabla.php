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

<script>
$(document).ready(function(){		
                var aux= "";	
				$("#img_base").val(aux);
				$(".fa-spinner").hide();
               
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

</script>
<script>
function ExtraerImagen($data)
{  $(".fa-spinner").show();
   $("#img_base").hide();
    $.ajax({
                type: "POST",
                data: {cont_id: $data.cont_id},
                url: "general/Estructura/Contenedor/GetImagen",
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
                }
            });
}



</script>

<script>
$(".btnEliminar").click(function(e) {
  var data = JSON.parse($(this).parents("tr").attr("data-json"));
  $('#btndelete').show();
  $("#id_contenedor").val(data.cont_id);
});
//--------------------------------------------------------------------
$(".btnInfo").click(function(e){
    var aux2 = null;
    $("#input_aux_img64").val(aux2);
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    var datacarga = JSON.parse($(this).parents("tr").attr("data-carga"));
    $(".habilitar").attr("readonly","readonly"); 
    $(".selectores").attr("style","display:none");
    $(".ocultar").attr("style","display:none"); 
    $(".ocultarInfo").removeAttr("style");
    $(".ocultarInfo").attr("style","width: 39rem;");
    $(".ocultarInfofecha").removeAttr("style");
    $(".ocultarInfofecha").attr("style","width: 35rem;");
    $(".ocultar_Info").removeAttr("style");
    $('#btnsave').hide();
    $("#Codigo").val(data.codigo);
    $("#Descripcion").val(data.descripcion);
    $("#Capacidad").val(data.capacidad);
    $("#Añoelab").val(data.anio_elaboracion.slice(0, 10));// saco hs y minutos
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
                $("#tic_id_info").append("<option selected value= '"+datacarga[i].tabl_id+"'> " + datacarga[i].valor + "</option>");
                aux=1;
                j=tipo.length+1;
                }

            }
            if(aux==0){
                $("#tic_id_info").append("<option value= '"+datacarga[i].tabl_id+"' >" + datacarga[i].valor + "</option>");
            } 
        
        }
  
        ExtraerImagen(data);    
});


//-------------------------------------------------------------------------
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
$(".selectores").attr("style","width: 39rem;");
$(".ocultar").removeAttr("style");
$(".ocultarInfo").attr("style","display:none");
$(".ocultarInfofecha").attr("style","display:none");
$(".titulo").text('Editar Contenedor'); 
$('#btnsave').show(); 
$(".ocultar_Info").attr("style","display:none");
$("#tic_id").removeAttr("disabled"); 
//--------------------------------------
$("#Codigo").val(data.codigo);
$("#Descripcion").val(data.descripcion);
$("#Capacidad").val(data.capacidad);
$("#Añoelab").val(data.anio_elaboracion);

//para pintar la fecha en el input fecha de elaboracion
var fec_nacimiento = data.anio_elaboracion.slice(0, 10) // saco hs y minutos		
			Date.prototype.toDateInputValue = (function() {
				var local = new Date(fec_nacimiento);
				// local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
				return local.toJSON().slice(0, 10);
			});
$('input#fec_elab_edit').val(new Date().toDateInputValue());
console.table($('input#fec_elab_edit').val());
//fin
$("#fec_elab_edit").attr("style","width: 31rem;");
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

  for (var i = 0; i <= datacarga.length - 1; i++) {
    aux = 0;
    for (var j = 0; j <= tipo.length - 1; j++) {
      if (datacarga[i].valor == tipo[j].rsu) {
        $("#tic_id").append("<option selected value= '" + datacarga[i].tabl_id + "'> " + datacarga[i].valor +
          "</option>");
        aux = 1;
        j = tipo.length + 1;
      }
    }
    if (aux == 0) {
      $("#tic_id").append("<option value= '" + datacarga[i].tabl_id + "' >" + datacarga[i].valor + "</option>");
    }

  }
  ExtraerImagen(data);
});
</script>
<script>
//DataTable($('#tabla_zonas'));
$('#tabla_contenedores').DataTable({
  "aLengthMenu": [10, 25, 50, 100],
  "order": [
    [0, "asc"]
  ],
});
</script>