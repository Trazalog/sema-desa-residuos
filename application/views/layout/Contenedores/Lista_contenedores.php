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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title titulo" id="exampleModalLabel">Editar Contenedor</h5>
            </div>


            <div class="modal-body">

                <!--__________________ FORMULARIO MODAL ___________________________-->

                <form method="POST" autocomplete="off" id="frmentrega" class="registerForm">


                    <div class="modal-body">



                        <form class="formContenedores" id="formContenedores" method="POST" autocomplete="off"
                            class="registerForm">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--Codigo / Registro-->
                                        <div class="form-group">
                                            <label for="Codigo/Registro">Codigo / Registro:</label>
                                            <input type="text" class="form-control habilitar" name="" id="Codigo">
                                        </div>
                                        <!--_____________________________________________-->
                                        <!--Descripcion-->
                                        <div class="form-group">
                                            <label for="Descripcion">Descripcion:</label>
                                            <input type="text" class="form-control habilitar" name="" id="Descripcion">
                                        </div>
                                        <!--_____________________________________________-->
                                          <!--Cont_id solo para salvaguardar el id del contenedor-->
                                       
                                            <input type="text" class="form-control" name="" id="cont_id" style="display:none">
                                        
                                        <!--_____________________________________________-->
                                        <!--Capacidad-->
                                        <div class="form-group">
                                            <label for="Capacidad">Capacidad:</label>
                                            <input type="text" class="form-control habilitar" name="" id="Capacidad">
                                        </div>
                                        <!--_____________________________________________-->
                                        <!--Año de elaboracion-->
                                        <div class="form-group">
                                            <label for="Añoelab">Año de elaboracion:</label>
                                            <input type="text" class="form-control habilitar" name="" id="Añoelab">
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <!--_____________________________________________-->
                                        <!--Tara-->
                                        <div class="form-group">
                                            <label for="Tara">Tara:</label>
                                            <input type="text" class="form-control habilitar" name="" id="Tara">
                                        </div>
                                        <!--_____________________________________________-->
                                        <!--Estado-->

                                        <div class="form-group">
                                            <label for="Estados">Estado:</label>
                                            <select class="form-control select2 select2-hidden-accesible selectores" name=""
                                                id="Estados">
                                                <option value="" disabled selected>-Seleccione opcion-</option>
                                                <?php
                                                        foreach ($estados as $i) {
                                                            echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                                                                 }
                                                                                
                                                ?>
                                            </select>
                                            <input type="text" class="form-control ocultarInfo" name="" id="estadoInfo" style="display:none">
                                        </div>
                                         <!--Habilitacion-->
                                         <div class="form-group">
                                            <label for="Habilitacion" >Habilitacion:</label>
                                            
                                                <select class="form-control select2 select2-hidden-accesible selectores" name="" id="Habilitacion">
                                                    <option value="" disabled selected>-seleccione opcion-</option>
                                                        <?php
                                                            foreach ($habilitacion as $i) {
                                                                echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                                            }
                                                        ?>
                                                </select>
                                                <input type="text" class="form-control ocultarInfo" name="" id="habilitacionInfo" style="display:none">
                                            
                                        </div>
                                    <!--__________________________________________________________________________________________-->
                                                            <br>
                                        <div class="form-group">
                                            <label for="tipoResiduos">Tipo de residuo:</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                                    <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tic_id">
                                                   
                  
                                                    </select>
                                            </div>
                                        </div>                                                   
                                        <!--_____________________________________________-->
                                       
                                        
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>


                        </form>


                    </div>

                </form>

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
//BOTON ELIMINAR

$(".btnEliminar").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $('#btndelete').show();    
    $("#id_contenedor").val(data.cont_id);
});



//BOTON VER INFO

$(".btnInfo").click(function(e){
    var data = JSON.parse($(this).parents("tr").attr("data-json")); 
    $(".habilitar").attr("readonly","readonly"); 
    $(".selectores").attr("style","display:none");
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

});

//BOTON EDITAR
$(".btnEditar").click(function(e){
var data = JSON.parse($(this).parents("tr").attr("data-json"));  
var datacarga = JSON.parse($(this).parents("tr").attr("data-carga"));
//para seguimiento despues borrar
console.table(data);
console.table(data.tipos_carga.tipoCarga);
console.table(datacarga[0].valor);
$(".habilitar").removeAttr("readonly");
$(".selectores").removeAttr("style");
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