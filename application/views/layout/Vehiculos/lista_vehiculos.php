    <!--__________________HEADER TABLA___________________________-->
    <table id="tabla_vehiculos" class="table table-bordered table-striped">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
        <th>Id</th>
        <th>Dominio</th>
        <th>Descripcion</th>
        <th>Marca</th>
        </thead>

        <!--__________________BODY TABLA___________________________-->

        <tbody>
        <?php
        if($vehiculos)
        {
            foreach($vehiculos as $fila)
            {
            echo "<tr data-json='".json_encode($fila)."'>";
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle btnEditar" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>&nbsp
                    <button type="button" title="Info" class="btn btn-primary btn-circle btnInfo" data-toggle="modal" data-target="#modalEdit"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>&nbsp 
                    <button type="button" title="eliminar" class="btn btn-primary btn-circle btnEliminar" data-toggle="modal" data-target="#modalBorrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';
                
            echo   '</td>';
            echo    '<td>'.$fila->equi_id.'</td>';   
            echo    '<td>'.$fila->dominio.'</td>';
            echo    '<td>'.$fila->descripcion.'</td>';                       
            echo    '<td>'.$fila->marca.'</td>';                        
            echo   '</tr>';
        }
        }
        ?>
        </tbody>
    </table>

    <!--__________________FIN TABLA___________________________-->

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
                data: {vehi_id: $data.equi_id},
                url: "general/Estructura/Vehiculo/GetImagen",
                success: function ($dato) {
                    
                    
                    var res = JSON.parse($dato);
                    console.table(res["vehiculos"].imagen);
                    
                   
                     var img_b64 = res["vehiculos"].imagen;
            
                   
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

//Modal Editar
$(".btnEditar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    console.table(data);
    $(".titulo").text('Editar Vehiculo');
    $(".textTransinfo").attr("style","display:none"); 
    $(".ocultaTransedit").removeAttr("style"); 
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
    $("#e_equi_id").val(data.equi_id);
    $("#id_fecha_ingreso").val(data.fecha_ingreso);
    console.table($("#id_fecha_ingreso").val());
    var tranid = data.tran_id; 
    $("#e_tran_id").val(tranid);
    $("#taraedit").val(data.tara); 
    ExtraerImagen(data);
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
<script>
    DataTable($('#tabla_vehiculos'))
</script>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 