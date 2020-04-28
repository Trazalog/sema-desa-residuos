<!-- <div id="tabla"> -->

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
            
            
        echo    '<td >'.$fila->nombre.'</td>';
        echo    '<td>'.$fila->depa_nom.'</td>';                       
        echo    '<td>'.$fila->descripción.'</td>';
        
   
    
        echo '</tr>';
    }
    }
    ?>
    </tbody>
   
    </table>
    
    <!-- </div> -->
    <!--__________________FIN TABLA___________________________-->
   


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





<!-- --------------------------------fin script modal editar----------------------------------------------- -->    


    <script>
    //DataTable($('#tabla_zonas'));
    $('#tabla_zonas').DataTable({
  "aLengthMenu": [ 10, 25, 50, 100 ],
  "order": [[0, "asc"]],
});
</script>

