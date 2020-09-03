<div class="box box-primary animated bounceInDown" id="boxDatos" hidden>
    <div class="box-header with-border">
        <div class="box-tittle">
        <h5>Liquidacion de Ordenes de Transporte</h5>  
        </div>
        <div class="box-tools pull-right">
            <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                data-toggle="tooltip" title="" data-original-title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

​      

        <div class="box-body">
            <form class="formVehiculo" id="formVehiculo"  method="POST" autocomplete="off" class="registerForm">
                <div class="col-md-6 col-sm-6 col-xs-12">

                            <!--transportistas-->
                        <div class="form-group" style="margin-bottom: -1rem;" >
                                    <label for="transp" class="form-label">Transportista:</label>
                                                
                                                    <select class="form-control" id="tran_id">
                                                        <option value="" disabled selected>-Seleccione opcion-</option>
                                                                <?php
                                                            foreach ($transportistas as $j) {
                                                            echo '<option value="'.$j->tran_id.'">'.$j->razon_social.'</option>';
                                                            }
                                                                ?>
                                                    </select>
                            <!-- <input type="text" class="form-control buscaTrans" placeholder="Buscar Transportista" id="buscaTrans">
                            <input type="text" class="hidden idTransportista" id="idTransportista"> -->
                        </div>
            ​       
                            <!--cantidad kilos-->
                        <div class="form-group" style="margin-bottom: -1rem;" >
                            <label for="kilos">Cantidad de kilos Pesados :</label>
                            <input type="text" class="form-control" readonly id="kilos" name="kilos">
                        </div>
            ​        

                            <!--unidades tributarias-->
                        <div class="form-group" style = "margin-bottom: 5px; margin-top: 1rem;">
                            <label for="totalunidades" >Total de unidades tributarias:</label>
                            <input type="text" class="form-control" readonly id="totalunidades" name="totalunidades">
                        </div>
            ​       
                
                </div> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                            <!--fecha inicio-->  
                        <div class="form-group">
                            <label for="fec_inicio" >Fecha Inicio:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="date" class="form-control pull-right" id="fec_inicio" name="fec_inicio">
                            </div>
                        </div>
                             <!--fecha fin-->
                        <div class="form-group">
                                <label for="fec_fin" >Fecha Fin:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="fec_fin" name="fec_fin">
                                </div>
                        </div>   
                        
                                <!--cantidad toneladas-->
                        <div class="form-group">
                            <label for="toneladas" >Cantidad Toneladas:</label>
                            <input type="text" class="form-control" readonly id="toneladas" name="toneladas" >
                        </div>
                      
            ​    </div>
            </form>
            <div>
            <button class="btn btn-primary" style="margin-left: 97rem;"  onclick="ObtenerLiquidacion()">Consultar</button>
           
            </div>
           
            <br>    
                <!--_________________Tabla para enviar_________________-->
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box " id="contenedores" >
                    <!-- <div class="box " id="contenedores"> -->
                    <div class="box-body table-responsive">
                    <!--__________________HEADER TABLA___________________________-->
                    <table class="table table-striped" id="tbl_generadores">
                        <thead class="thead-dark" bgcolor="#eeeeee">
                        <th>Acciones</th>
                        <th>Generador</th>
                        <th>Peso</th>
                        <th>Toneladas</th>
                        </thead>
                        <!--__________________BODY TABLA___________________________-->
                        <tbody>
                      
                        </tbody>
                    </table>
                    <!--__________________FIN TABLA___________________________-->
                    </div>
                </div>
                </div>
                    <!--_________________Tabla para enviar_________________-->

                     <!--_________________Tabla para enviar_________________-->
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box " id="contenedores" >
                    <!-- <div class="box " id="contenedores"> -->
                    <div class="box-body table-responsive">
                    <!--__________________HEADER TABLA___________________________-->
                    <table class="table table-striped" id="tbl_generadores_datalle" style="display:none;">
                        <thead class="thead-dark" bgcolor="#eeeeee">
                        <th>Tipo de Residuos</th>
                        <th>Valorizado</th>
                        <th>Taza</th>
                        <th>Toneladas</th>
                        <th>Monto</th>
                        </thead>
                        <!--__________________BODY TABLA___________________________-->
                        <tbody>
         
                        </tbody>
                    </table>
                    <!--__________________FIN TABLA___________________________-->
                    </div>
                </div>
                </div>
                    <!--_________________Tabla para enviar_________________-->
        </div>
    </div>
</div>



<script>
//PARA DESPLEGAR EL MODAL AL INICIAR LA PAGINA
$(document).ready(function(){
    $("#boxDatos").focus();
    $("#boxDatos").show();

});

//FUNCION PARA AÑADIR EN LA ULTIMA TABLA DETALLE DE oT DEL GENERADOR SELECCIONADO
$(document).on("click",".fa-plus-square",function() {
            $('#tbl_generadores').DataTable().row( $(this).closest('tr') ).remove().draw();
            $("#tbl_generadores_datalle").removeAttr('style');
            var ortrfila = $(this).parents("tr").attr("ortr_id");
            var dataTodo = $(this).parents("tr").attr("data-json");
            var datajson = JSON.parse(dataTodo);
            var table = $('#tbl_generadores_datalle').DataTable();
            var ton; 
            var monto;
    
            for(var h=0; h < datajson.datos.length; h++)
            {
                if(datajson.datos[h].ortr_id == ortrfila)
                {
                    ton = (datajson.datos[h].peso_neto * 1) / 1000;
                    monto = ton * datajson.datos[h].taza;
                    var row =  `<tr ortr_id='${datajson.datos[h].ortr_id}'> 
                                    <td>${datajson.datos[h].valor}</td>
                                    <td>${datajson.datos[h].tiva}</td>
                                    <td>${datajson.datos[h].taza}</td> 
                                    <td>${ton}</td>   
                                    <td>${monto}</td>     
				                </tr>`;
                    table.row.add($(row)).draw();
                }
            }


});
        
//FUNCION PARA CARGAR LOS TRES PRIMEROS INPUT DE SOLO LECTURA Y LA PRIMERA TABLA QUE CONTIENE INFO GENERAL DE LOS GENERADORES        
function cargarModal($data)
{
    //sumas de pesaje y unidades tributarias
    var cantUnTri = 0;
    var cantKg = 0
    console.table($data.datos[1].peso_neto);
    for(var i=0; i<$data.datos.length; i++)
    {
        cantKg = cantKg + parseInt($data.datos[i].peso_neto);
        cantUnTri = cantUnTri + parseInt($data.datos[i].unidad_tributaria); 
    }

    //LLenado de inputs cantidad de kilos pesados, cantidad de toneladas, y cantidad de unidades tributarias
    $("#kilos").val(cantKg);
    $("#totalunidades").val(cantUnTri);
    var toneladas = (cantKg * 1) / 1000; //regla de tres simple  para convertir Kg a Tns
    $("#toneladas").val(toneladas);

    //llenado de tabla fe generadores con sus kg
    var sumkilos; // variable para sumar kilos de los diferentes generadores que luego ira en la columna de peso
    var ortr_id; // esta variable almacenara el ortr_id de cada generador para lugo usarla cuando de persione el mas en la primera tabla 
    var table = $('#tbl_generadores').DataTable();
    for(var j=0; j<$data.generadores.length; j++) // uso del arreglo con los nombre de los generadores sin repetir aca se ve su utilidad 
    {   sumkilos = 0;
        for(var t=0; t<$data.datos.length; t++)
        {
            if($data.generadores[j] == $data.datos[t].razon_social)
            {
                sumkilos = sumkilos + parseInt($data.datos[t].peso_neto);
                ortr_id = $data.datos[t].ortr_id;
            }
        }
        var tons = (sumkilos * 1) / 1000; //regla de tres simple  para convertir Kg a Tns
        var row =  `<tr ortr_id='${ortr_id}' data-json='${JSON.stringify($data)}' > 
						<td> <i class='fa fa-plus-square text-light-blue' style='cursor: pointer; margin-left: 15px;' title='Añadir'></i> </td>
						<td>${$data.generadores[j]}</td>
						<td>${sumkilos}</td>
						<td>${tons}</td>         
				    </tr>`;
        table.row.add($(row)).draw(); // agrega fila a la tabla con id tbl_generadores aclaracion en tr se le asigna los atributos ortr_id para poder utilizarlo luego 
                                      // cuando se presione el mas y se necesite cargar en la tabla de abajo info detallada para ese generador al igual que el atrinuto data-json se 
                                      // se almacena todo los datos para luego utilizarlo con la misma finalidad que es mostrar detalles de ese generador en la siguiente tabla     
    }
   

}

//FUNCTION QUE TRAE INFO DE TODO LO PESADO POR EL TRASNPORTISTA x EN UN PERIODO DE TIEMPO
function ObtenerLiquidacion()
{
     var transportista =  $("#tran_id").val();
     var fecha_inicio  = $("#fec_inicio").val();
     var fecha_final   =   $("#fec_fin").val();
     $.ajax({
                    type: "POST",
                    data: {transportista, fecha_inicio, fecha_final},
                    url: "general/Estructura/LiquidacionOT/getDataLiquidacion",
                    success: function (r) {
                        console.table(r);
                        var liq = JSON.parse(r); 
                        console.table(liq);
                        cargarModal(liq);
                      
                    },
                    error: function() {

                    },
                    complete: function() {
                        
                    }
                });
    
        

}




</script>