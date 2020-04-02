<!-- __________________HEADER TABLA___________________________ -->

<table id="tabla_circuitos" class="table table-bordered table-striped">
    <thead class="thead-dark" bgcolor="#eeeeee">

        <th>Acciones</th>
        <th>Codigo</th>
        <th>Chofer</th>
        <th>Vehiculo</th>
        <th>Tipo de residuo</th>

    </thead>

    <!-- __________________BODY TABLA___________________________ -->

    <tbody>
    <?php
        if($circuitos)
        {

//var_dump($circuitos);

            foreach($circuitos as $fila)
            {
            echo "<tr data-json='".json_encode($fila)."'>";
          
            echo    '<td>';
            echo    '<button type="button" title="Editar" class="btn btn-primary btn-circle" data-toggle="modal"
            data-target="#modalEdit" onclick="ModalEdit(this)"><span class="glyphicon glyphicon-pencil"
                aria-hidden="true"></span></button>&nbsp
        <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal"
            data-target="#modalInfo" onclick="ModalInfo(this)"><span class="glyphicon glyphicon-info-sign"
                aria-hidden="true"></span></button>&nbsp
        <button type="button" title="Info" class="btn btn-primary btn-circle" data-toggle="modal"
            data-target="#modalZona"><span class="glyphicon glyphicon-record"
                aria-hidden="true"></span></button>&nbsp
        <button type="button" title="eliminar" class="btn btn-primary btn-circle"><span
                class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>&nbsp';

            echo   '</td>';
            echo    '<td>'.$fila->codigo.'</td>';
            echo    '<td>'.$fila->chof_id.'</td>';
            echo    '<td>'.$fila->vehi_id.'</td>';
            // echo    '<td>'.$fila->tiposCarga."".$fila->carga.'</td>';
            echo    '<td>';
                for ($i=0; $i < count($fila->tiposCarga->carga) ; $i++) { 
                    echo $fila->tiposCarga->carga[$i]->valor;
                    echo ' - ';
                }
            echo '</td>';
            echo '</tr>';
        }
        }
        ?>

    </tbody>
</table>

<!-- __________________FIN TABLAa___________________________ -->




    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Informacion Circuito</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form  id="frmentrega" class="registerForm">


                    
            
                        <div class="col-md-12 col-sm-12 col-xs-12"> 

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Codigo" name="Codigo">Codigo:</label>
                                        <input type="text" class="form-control" id="i_codigo"name="i_codigo" readonly>
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="Vehiculo" name="Vehiculo">Vehiculo:</label>
                                        <input type="text" class="form-control" id="i_vehiculo" readonly>                                
                                    </div>
                                </div>                   
                          
                                <div class="col-md-6">                            
                                    <div class="form-group">
                                        <label for="Chofer" name="Chofer">Chofer:</label>
                                        <input type="text" class="form-control" id="i_chofer" readonly>
                                    
                                    </div>                                
                                    <div class="form-group">
                                    <label for="tipoResiduos" name="tipoResiduos">Tipo de residuo:</label>
                                    <input type="text" class="form-control" id="i_tipoResiduo" readonly>                               
                                    </div>
                                </div>

                         </div>

                         <div class="col-md-12 col-sm-12 col-xs-12"><br></div>  

                         <div class="col-md-12 col-sm-12 col-xs-12">  
                         <div class="form-group">
                            <label  name="Descripcion">Descripciones:</label>
                            <textarea style="resize: none;"  type="text" class="form-control" id="i_descripcion" readonly></textarea>
                            </div>         
                        </div>         
                    
                    
                    <!--_______________________SEPARADOR______________________-->    

                    <div class="col-md-12 col-sm-12 col-xs-12"><br></div>

                    <!--_______________________SEPARADOR______________________-->   

                    <div class="row"> 

                         <div class="col-md-12">

                            <div class="box-header bg-blue">
                                <h5>Punto Critico</h5>
                            </div>
                        
                        </div>

                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12"><br><br></div>
                   <!--*******************************************-->

                    <div class="row">

                        <div class="col-md-12">                           
                        
                                
                             

                                <div class="row">                        
                                    <div class="col-md-12">
                                        
                                        <!--__________________HEADER TABLA___________________________-->

                                        <table id="tabla_puntos_criticos" class="table table-bordered table-striped">
                                            <thead class="thead-dark" bgcolor="#eeeeee">

                                                
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Ubicacion</th>
                                                
                                                

                                            </thead>
                                            <!--__________________BODY TABLA___________________________-->
                                            <tbody>
                                                <?php
                                                if($puntos_criticos)
                                                {
                                                    foreach($puntos_criticos as $fila)
                                                    {
                                                    
                                                    echo    '<td>'.$fila->nombre.'</td>';
                                                    echo    '<td>'.$fila->descripcion.'</td>';
                                                    echo    '<td>'.$fila->descripción.'</td>';
                                                    echo '</tr>';
                                                }
                                                }
                                                ?>
                                            </tbody>
                                        </table>                                    
                                        <!--__________________FIN TABLA___________________________-->

                                        
                                    </div>         
                                </div>

                            </div>

                        </div>
                    
                    
                
                
            </form>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <!-- <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button> -->
                    <button type="submit" class="btn btn-default" id="btnInformacion" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->
<!---//////////////////////////////////////--- MODAL Editar ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Editar Circuito</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form  id="frmentrega" class="registerForm">                    
            
                        <div class="col-md-12 col-sm-12 col-xs-12"> 

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Codigo" name="Codigo">Codigo:</label>
                                        <input type="text" class="form-control" id="e_codigo" name="">
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="Vehiculo" name="Vehiculo">Vehiculo:</label>
                                        <input type="text" class="form-control" id="e_vehiculo"name="" >                                
                                    </div>
                                </div>                   
                          
                                <div class="col-md-6">                            
                                    <div class="form-group">
                                        <label for="Chofer" name="Chofer">Chofer:</label>
                                        <input type="text" class="form-control" id="e_chofer" name="" >
                                    
                                    </div>                                
                                    <div class="form-group">
                                    <label for="tipoResiduos" name="tipoResiduos">Tipo de residuo:</label>
                                    <input type="text" class="form-control" id="e_tipoResiduo" name="">                               
                                    </div>
                                </div>

                         </div>

                         <div class="col-md-12 col-sm-12 col-xs-12"><br></div>  

                         <div class="col-md-12 col-sm-12 col-xs-12">  
                         <div class="form-group">
                            <label  name="Descripcion">Descripciones:</label>
                            <textarea style="resize: none;"  type="text" class="form-control" id="e_descripcion" name="" ></textarea>
                            </div>         
                        </div>         
                    
                    
                    <!--_______________________SEPARADOR______________________-->    

                    <div class="col-md-12 col-sm-12 col-xs-12"><br></div>

                    <!--_______________________SEPARADOR______________________-->   

                    <div class="row"> 

                         <div class="col-md-12">

                            <div class="box-header bg-blue">
                                <h5>Punto Critico</h5>
                            </div>
                        
                        </div>

                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12"><br><br></div>
                   <!--*******************************************-->

                    <div class="row">

                        <div class="col-md-12">                           
                        
                                
                             

                                <div class="row">                        
                                    <div class="col-md-12">
                                        
                                        <!--__________________HEADER TABLA___________________________-->

                                        <table id="tabla_puntos_criticos" class="table table-bordered table-striped">
                                            <thead class="thead-dark" bgcolor="#eeeeee">

                                                
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Ubicacion</th>
                                                
                                                

                                            </thead>
                                            <!--__________________BODY TABLA___________________________-->
                                            <tbody>
                                                <?php
                                                if($puntos_criticos)
                                                {
                                                    foreach($puntos_criticos as $fila)
                                                    {
                                                    
                                                    echo    '<td>'.$fila->nombre.'</td>';
                                                    echo    '<td>'.$fila->descripcion.'</td>';
                                                    echo    '<td>'.$fila->descripción.'</td>';
                                                    echo '</tr>';
                                                }
                                                }
                                                ?>
                                            </tbody>
                                        </table>                                    
                                        <!--__________________FIN TABLA___________________________-->

                                        
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
                    <button type="submit" class="btn btn-default" id="btnEditar" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL INFORMACION ---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////--- MODAL PUNTO CRITICO ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalPunto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Registrar punto critico</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="" class="registerForm">


                <div class="modal-body">

                

                    <div class="row"> 

                        <div class="col-md-12 "> 

                                               

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Nombre-->

                                <div class="form-group">
                                    <label for="Nombre" name="Nombre">Nombre:</label>
                                     <input type="text" class="form-control" id="Nombre">
                                </div>                            

                            </div>
                            

                            <!--**************************************************-->
                            
                            

                            <div class="col-md-6 col-sm-6">

                                <!--_____________________________________________-->
                                <!--Descripcion-->

                                <div class="form-group">
                                    <label for="Descripcion" name="Descripcion">Descripcion:</label>
                                     <input type="text" class="form-control" id="Descripcion">
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
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL PUNTO CRITICO ---///////////////////////////////////////////////////////----->


<!---//////////////////////////////////////--- MODAL ZONA ---///////////////////////////////////////////////////////----->

    
<div class="modal fade" id="modalZona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Asignar Zona</h5>
            </div>


            <div class="modal-body">

            <!--__________________ FORMULARIO MODAL ___________________________-->

            <form method="POST" autocomplete="off" id="" class="registerForm">


                <div class="modal-body">
                
                    <div class="col-md-12 ">                                                
                       
                        <div class="row">

                            <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Departamento-->

                                <div class="form-group">
                                    <label for="Dpto" >Departamento:</label>
                                    <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-"></i>
                                    </div>
                                    <select class="form-control select2 select2-hidden-accesible" name="selectDepto" id="selectDepto">                                    
                                    <?php
                                        foreach($Departamentos as $fila)
                                        {
                                        echo '<option value="'.$fila->depa_id.'">'.$fila->nombre.'</option>' ;
                                        }
                                    ?>
                                    </select>
                                </div>                                                        

                            </div>

                        </div>
                            

                        <!--_____________________________________________-->     
                            
                            
                        <div class="row">

                            <div class="col-md-6">

                                <!--_____________________________________________-->
                                <!--Zona-->

                                <div class="form-group">
                                        <label for="Dpto" >Zona:</label>
                                        <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-"></i>
                                        </div>
                                        <select class="form-control select2 select2-hidden-accesible" name="selectZona" id="selectZona">

                                        <option value="" disabled selected>-Seleccione Zona-</option> 
                                        
                                        
                                        </select>
                                </div> 

                                    
                            </div>
                        
                        </div>

                        <!--_____________________________________________-->  

                               
                    </div>        
   
                </div>
                
            </form>

            <div class="col-md-12"><hr><br></div>

            <!--__________________ FIN FORMULARIO MODAL ___________________________-->

            </div>
            
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-primary pull-right" onclick="insertCircuitoZona()">Guardar</button>
                    <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!---//////////////////////////////////////--- FIN MODAL ZONA ---///////////////////////////////////////////////////////----->



<script>


//----------------- Funcion Filtrar zonas por departamento --------------------------//

$("#selectDepto").change(function(){
    
    var idDepto = $("#selectDepto").val();
  
    $.ajax({

            type: 'POST',        
            data: {idDepto: idDepto}, 
            url: 'general/Estructura/Zona/obtenerDeptoPorZona',
            dataType: 'json',

            success: function(result) {
                // console.table(result);

               
                for (let index = 0; index < result.length; index++)
                {
                                              
                    $('#selectZona').append("<option value='" + result[index].zona_id + "'>" +result[index].zona_nom +"</option"); 

                   
                    
                }
            },

            
            error: function() {
                alert('Error');
            }
    });
});




 </script>


<!--FUNCION MODAL Informacion-->
<script>
function ModalInfo(e) { 

   var json = getJson($(e).closest('tr'));
   


$('#btnInformacion').prop("disabled", false);    
var id = json.circ_id;
console.log("id de circuito selec:" + id);
$.ajax({
  data: { id:id },
  dataType: 'json',
  type: 'POST',
  url: 'index.php/general/Estructura/Zona/getCircuito',
  success: function(data){
      console.table(data);
    

    console.info(data.descripcion);
    console.log('///////////////////////////');
    console.log("tipo de carga" + data.tiposCarga.carga[0].valor);

    // var circuito = getcircuito(data['datos']);
     
    //   //llenar datos de circuitos
      $("#i_codigo").val(data.codigo);
      $('#i_chofer').val(data.chof_id);
      $('#i_vehiculo').val(data.vehi_id);
      $('#i_tipoResiduo').val(data.tiposCarga);
      $('#i_descripcion').val(data.descripcion);
  
    
   
  },

  error: function(result){
    //alert('ERror');
} })

} 
</script>

</script>


<!--FUNCION MODAL EDITAR-->
<script>
function ModalEdit(e) { 

   var json = getJson($(e).closest('tr'));
   


$('#btnEditar').prop("disabled", false);    
var id = json.circ_id;
console.log("id de circuito selec:" + id);
$.ajax({
  data: { id:id },
  dataType: 'json',
  type: 'POST',
  url: 'index.php/general/Estructura/Zona/getCircuito',
  success: function(data){
      console.table(data);
    

    console.info(data.descripcion);
    console.log('///////////////////////////');
    console.log("tipo de carga" + data.tiposCarga.carga[0].valor);

    // var circuito = getcircuito(data['datos']);
     
    //   //llenar datos de circuitos
      $("#e_codigo").val(data.codigo);
      $('#e_chofer').val(data.chof_id);
      $('#e_vehiculo').val(data.vehi_id);
      $('#e_tipoResiduo').val(data.tiposCarga);
      $('#e_descripcion"').val(data.descripcion);
  
    
   
  },

  error: function(result){
    //alert('ERror');
} })

} 
</script>




<script>

DataTable($('#tabla_circuitos'))
</script>