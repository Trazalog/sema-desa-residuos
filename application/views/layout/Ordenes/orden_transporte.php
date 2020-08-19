<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Orden de Transporte</h4>
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




<!---//////////////////////////////////////--- BOX 1---///////////////////////////////////////////////////////----->


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

    <!--___________________BOX BODY__________________________-->

    <div class="box-body">

        <div class="col-md-12 col-sm-12 col-xs-12"><br></div>

          
            
        
           

            <!--**********************************************-->

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
            

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary animated fadeInLeft">
                            <div class="box-header with-border">
                                <h4>Orden de transporte</h4>
                            </div>
                        </div>
                    </div>

                    <form class="formOrden" id="formOrden" name="formOrden">

                        <div class="col-md-12 col-sm-12 col-xs-12">   
                                <div class="col-md-6 ">
                                    <!--_______________________-->
                                    <!--camion-->
                                    <div class="form-group">
                                        <label for="equipo" class="form-label">Camion:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-check"></i>
                                            </div>
                                                <select class="form-control select2 select2-hidden-accesible" id="equipo"
                                                    name="tipo_residuo" required>
                                                    <option value="" disabled selected>-Seleccione opcion-</option>
                                                    <?php
                                                    foreach ($equipo as $d) {
                                                        echo '<option  value="'.$d->equi_id.'">'.$d->dominio.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                     </div>
                                   
                                    <div class="form-group">
                                     <label for="transp" class="form-label">Transportista:</label>
                                     <input type="text" class="form-control"   name="nro" id="transp" readonly>
                                     <input type="text" id="tran_id" style="display:none">
                                     </div>
                                    
                                   
                                </div>
                                <div class="col-md-6">

                                
                                    <div class="form-group">
                                                <label for="fecha" class="form-label">Fecha de Retiro:</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="date" class="form-control"   name="fecha" id="Fecha" value="<?php echo date("Y-m-d");?>" >
                                                        <input type="text" style="display:none" value="<?php echo $sotrid?>" id="sotr_id" >
                                                    </div>
                                    </div>
                                    <!-- chofer -->
                                    <div class="form-group">
                                        <label for="chofer" class="form-label">Chofer:</label>
                                        <select class="form-control select2 select2-hidden-accesible" id="chofer" readonly>
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                            // foreach ($chofer as $i) {
                                            //     echo '<option  value="'.$i->documento.'">'.$i->nombre.'</option>';
                                            // }
                                            ?>
                                        </select>
                                    </div>
                                     
                                  
                                
                                </div>
                            <!--_______________________-->
                            <!--Numero-->
                            <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="Nro" class="form-label">Nro:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-check"></i>
                                        </div>
                                        <input type="text" name="nro" id="Nro" value="<?php //if($=='' ){echo 'value="'.$->.'"';}?>"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div> -->
                            <!--_______________________-->
                            <!--Fecha-->
                            <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                <label for="fecha" class="form-label">Fecha de Retiro:</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control"   name="fecha" id="Fecha">
                                            </div>
                                </div>
                            </div> -->
                            
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="col-md-6 col-sm-6 col-xs-12"></div>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <!--_______________________-->
                                <!--Disposicion Final-->
                                <div class="form-group">
                                    <label for="dispfinal" class="form-label">Disposicion final:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-check"></i>
                                        </div>
                                        <select class="form-control" id="dispfinal">
                                            <option value="" disabled selected>-Seleccione opcion-</option>
                                            <?php
                                        foreach ($dispfinal as $j) {
                                            echo '<option value="'.$j->tabl_id.'">'.$j->valor.'</option>';
                                        }
                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>

            <!--_______________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--_______________________-->
            <div class="col-md-12 col-sm-12 col-xs-12">
            
                
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <!--_______________________-->
                        <!--Tipo residuo-->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           
                            <!--_______________________-->
                            <!--Porcentaje llenado-->
                            <!-- <div class="form-group">
                                <label for="porcentajell" class="form-label">% de llenado:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                    <input type="number" step="0.0001" id="porcentajell" name="porcent_llenado"
                                        class="form-control" required>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-6  col-sm-6 col-xs-12">
                            <!--_______________________-->
                            <!--Contenedor-->
                            <!-- <div class="form-group">
                                    <label for="cont_ent">Contenedores:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-check"></i>
                                            </div>
                                            <select class="form-control select2 select2-hidden-accesible" name="cont_ent" id="cont_ent">
                                            <?php
                                            // foreach ($contenedores as $c) {     
                                            //         echo '<option  value="'.$c->cont_id.'">'.$c->codigo.'</option>';
                                            //}
                                            ?>
                                            </select>
                                        </div>
                            </div> -->
                            <!--_______________________-->
                            <!--Metros cubicos-->
                            <!-- <div class="form-group">
                                <label for="metroscubicos" class="form-label">Metros cubicos:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </div>
                                    <input type="number" step="0.0001" name="metroscubicos" class="form-control"
                                        id="metroscubicos" min="0" required>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!--_______________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--_______________________-->

            <!-- <div class="row"> -->

                <!--_______________________-->
                <!--BOTON AGREGAR-->

                <!-- <div class="col-md-10 col-lg-11 col-xs-12"></div>
                <div class="col-md-2 col-lg-1 col-xs-12 text-center"> -->
                    <!-- <div class="form-group">
                        <button class="btn btn-primary btn-circle" onclick="Agregar_Residuo()" aria-label="Left Align">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <small for="agregar" class="form-label">Agregar</small>
                    </div> -->

                <!-- </div>
            </div> -->

            <!--_______________________-->

            <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div> -->

            <!--_______________________-->

            </form>
            
<!--_________________BTN AGREGAR_________________-->
<!-- <div class="col-md-12"> -->
  <!-- <button type="submit" class="btn btn-primary btn-circle pull-right" onclick="Agregar_contenedor()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button> -->
  <!-- <button type="submit" class="btn btn-default pull-right" onclick="">AGREGAR</button> -->
<!-- </div> -->

<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
<!--_________________SEPARADOR_________________-->

<!--_________________Tabla para enviar_________________-->
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="box " id="contenedores" style="display:none">
    <!-- <div class="box " id="contenedores"> -->
    <div class="box-body table-responsive">
      <!--__________________HEADER TABLA___________________________-->
      <table class="table table-striped" id="tbl_cont">
        <thead class="thead-dark" bgcolor="#eeeeee">
        <th>Acciones</th>
          <th>Contenedor</th>
          <th>tipo carga</th>
          <th>porcentaje llenado</th>
          <th>mts cubicos</th>
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
<!--_________________SEPARADOR_________________-->
<div class="col-md-12 col-sm-12 col-xs-12"> <br></div>
<!--_________________SEPARADOR_________________-->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary pull-right"
                    onclick="Guardar_Orden_transporte()">Guardar</button>
            </div>
        </div>

        
        


            <!--____________________________TABLA RESIDUOS____________________________-->

            <div class="row">
                <div class="box box-primary" id="box-tabla" style="display:none">
                    <div class="box-body table-responsive">
                        <table class="table table-striped" id="contenedores">
                            <thead>
                                <th>Tipo residuo</th>
                                <th>Contenedor</th>
                                <th>% llenado</th>
                                <th>Metros cubicos</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
         

        <!--____________________________-->
        <!--Boton de guardado-->

      
           


       
         
    </div>

    <!--___________________FIN BOX BODY__________________________-->



</div>


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




<!---//////////////////////////////////////--- SCRIPT---///////////////////////////////////////////////////////----->


<!--_____________________________________________________________-->
<!-- REGISTRAR Orden Transporte-->
<script>
function  obtenerTemplateOT()
{ 
    var sotrid = $("#sotr_id").val();
    $.ajax({
      type: "POST",
      data: {sotr_id: sotrid},
      dataType: 'json',
      url: "general/Estructura/OrdenTransporte/Obtenerteot",
      success: function($respuesta) {
        
        var resp = $respuesta;
      
      }
     
    });
}

// funcion agregar contenedores a tabla 
function AgregarCont($datos) {
   
    // var contenedores = $datos.vehiculoAsignadoARetiro.contenedores;
    // console.table(contenedores);
    var cont = $datos.vehiculoAsignadoARetiro.contenedores.contenedor;
    console.table(cont);
    
    if(!cont)
    {
        alert("ATENCION!!! EL Camion que selecciono no posee Contenedores asociados");
        $('#contenedores').show();
        var table = $('#tbl_cont').DataTable();
                        table.clear().draw();
        
    }else{
        console.table($datos.vehiculoAsignadoARetiro.contenedores);
        // }
        $('#contenedores').show();
        var table = $('#tbl_cont').DataTable();
                        table.clear().draw();

        //var data = new FormData($('#formPedidos')[0]);
        var data = new FormData();
        data = formToObject(data);
        for(var i=0; i<$datos.vehiculoAsignadoARetiro.contenedores.contenedor.length; i++){
            var data = new FormData();
            data = formToObject(data);
            data.cont_id = $datos.vehiculoAsignadoARetiro.contenedores.contenedor[i].cont_id;
            data.tipo_carga = $datos.vehiculoAsignadoARetiro.contenedores.contenedor[i].tipo_carga;
            data.porc_llenado = $datos.vehiculoAsignadoARetiro.contenedores.contenedor[i].porc_llenado;
            data.mts_cubicos = $datos.vehiculoAsignadoARetiro.contenedores.contenedor[i].mts_cubicos;
            var table = $('#tbl_cont').DataTable();
            var row = `<tr data-json='${JSON.stringify(data)}'>  
                                <td><i class="fa fa-wa fa-minus text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Quitar"></i></td>        
                                <td>${data.cont_id}</td>
                                <td>${data.tipo_carga}</td>
                                <td>${data.porc_llenado}</td>
                                <td>${data.mts_cubicos}</td>		
                        </tr>`;
                        
            table.row.add($(row)).draw();
        }
    }
                // data.cont_id = $datos.vehiculoAsignadoARetiro.
                // // data.cont_id = $("#cont_ent").val();
                // var table = $('#tbl_cont').DataTable();
                // var row = `<tr data-json='${JSON.stringify(data)}'>  
                //                     <td><i class="fa fa-wa fa-minus text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Quitar"></i></td>        
                //                     <td>${data.cont_id}</td>		
                //             </tr>`;
                            
                // table.row.add($(row)).draw();
                // $('#formTransportista')[0].reset();
}
</script>
<script>
function obtenerchoftran($aux)
{
   
$.ajax({
      type: "POST",
      data: {tran_id: $aux},
      dataType: 'json',
      url: "general/Estructura/OrdenTransporte/GetChoferyTransportista",
      success: function($datos) {
          $("#chofer").removeAttr('readonly');
          var res = $datos;
          console.table(res.chofer);
        //   console.table(res.chofer[1].nom_chofer);
          console.table(res.chofer.length);
          console.table(res.transp.razon_social);
          $("#transp").val(res.transp.razon_social);
          $("#chofer").empty();
          for(var c =0; c<res.chofer.length; c++){
            console.table(res.chofer[c].nom_chofer);
            $('#chofer').append("<option value='" + res.chofer[c].documento + "'>" +res.chofer[c].nom_chofer+"</option");

          }
          obtenerTemplateOT();
        //   console.table(resp.vehiculoAsignadoARetiro.descripcion);
        //   console.table(resp.vehiculoAsignadoARetiro.codigo);
        //   console.table(resp.vehiculoAsignadoARetiro.contenedores.contenedor[0].mts_cubicos);
        //   console.table(resp.vehiculoAsignadoARetiro.contenedores.contenedor);
        //   Agregar_contenedor(resp);
      
      },
      error: function() {
							
      },
      complete: function() {
        
      }
})
}

$("#equipo").change(function(){
 
// var dominio_equipo = this.value;
//  var dominio_equipo = this.selectedOptions[0].textContent;
//  var dom_equipo = $("#equipo").val();
var dominio_equipo = $("#equipo option:selected" ).text();
    // datos.equi_id = dominio_equipo;
 console.table(dominio_equipo);
var aux;
$.ajax({
      type: "POST",
      data: {dom_id: dominio_equipo},
      dataType: 'json',
      url: "general/Estructura/OrdenTransporte/ObtenerinfoOt",
      success: function($respuesta) {
          
        // var respuesta = JSON.parse($respuesta);
          var resp = $respuesta;
          aux = resp.vehiculoAsignadoARetiro.tran_id; // esto guardarlo en algun input oculto
          console.table(resp);
          console.table(resp.vehiculoAsignadoARetiro.descripcion);
          console.table(resp.vehiculoAsignadoARetiro.codigo);
          $("#tran_id").val(aux);
        //   console.table(resp.vehiculoAsignadoARetiro.contenedores.contenedor[0].mts_cubicos);
        //   console.table(resp.vehiculoAsignadoARetiro.contenedores.contenedor);
           AgregarCont(resp);
      
      },
      error: function() {
        alert("ATENCION!!! no hay contenedores asignados para el Vehiculo que selecciono");
      },
      complete: function() {
        
        obtenerchoftran(aux);
      }
    });

   

})

</script>

<script>
// remueve registro de tabla temporal 
$(document).on("click",".fa-minus",function() {
			$('#tbl_cont').DataTable().row( $(this).closest('tr') ).remove().draw();
		});



//CODIGO PARA PROBAR CUANDO ESTE EL SERVICIO...AGREGA A LA TABLA LOS CONT QUE VIENEN EN EL JSON
//EL SERV DE BONITA DEBERIA AGREGARSE tipo_carga, porc_llenado, mts_cubico para que funcione bien 
// for(var i=0; i<res.contenedores.lenght; i++)
// {
//     var data = new FormData();
//     data = formToObject(data);
//     data.cont_id = res.contenedores[i].cont_id;
//     data.tipo_carga = res.contendores[i].tipo_carga;
//     data.porc_llenado = res.contenedores[i].porc_llenado;
//     data.mts_cubicos = res.contendores[i].mts_cubicos;
//     var table = $('#tbl_cont').DataTable();
//     var row = `<tr data-json='${JSON.stringify(data)}'>  
//                         <td><i class="fa fa-wa fa-minus text-light-blue" style="cursor: pointer; margin-left: 15px;" title="Quitar"></i></td>        
//                         <td>${data.cont_id}</td>
//                         <td>${data.tipo_carga}</td>
//                         <td>${data.porc_llenado}</td>
//                         <td>${data.mts_cubico}</td>		
//                 </tr>`;
                
//     table.row.add($(row)).draw();
// }

function Agregar_Residuo() {

    $('#puntos_criticos').show();

    var data = new FormData($('#formPuntos')[0]);
    data = formToObject(data);

    $('#datos tbody').append(
        `<tr data-json='${JSON.stringify(data)}'>       
            <td>${data.nombre}</td>
            <td>${data.descripcion}</td>
            <td>${data.lat}</td>
            <td>${data.lng}</td>            
        </tr>`
    );

    // $('#formPuntos')[0].reset();
    $('select').select2().trigger('change');
}
TODO: //fec_retiro, teot_id, cont_id
function Guardar_Orden_transporte(){
   debugger;
    if(  $('#tbl_cont').DataTable().data().any() ) 
    {console.table($("#dispfinal").val());
        if($("#dispfinal").val() != null)
        {
                var datos = new FormData();
            datos = formToObject(datos);

            // datos.fec_retiro = '02-07-2020';         
            datos.fec_retiro = $("#Fecha").val();
            // var auxfecha = datos.fec_retiro[8]+datos.fec_retiro[9]+"-"+datos.fec_retiro[5]+datos.fec_retiro[6]+"-"+datos.fec_retiro[0]+datos.fec_retiro[1]+datos.fec_retiro[2]+datos.fec_retiro[3]; 
            // datos.fec_retiro = auxfecha;
            datos.difi_id = $("#dispfinal").val();
            datos.sotr_id = $("#sotr_id").val();
            datos.tran_id = $("#tran_id").val();
            // var dominio_equipo = $("#equipo" ).selectedOptions[0].textContent;
            // var dominio_equipo = $("#equipo option:selected" ).text();
            // datos.equi_id = dominio_equipo;
            datos.equi_id = $("#equipo").val();
            datos.chof_id = $("#chofer").val();
            datos.usuario_app = "HugoDS";
        // datos.teot_id = 7;
            //aca agregarle el cont_id

            var datos_contenedor = [];
            var rows = $('#tbl_cont tbody tr');
            // console.table(rows[0].dataset.json);
            // var auxx = JSON.parse(rows[0].dataset.json);
            // console.table(auxx);
            // console.table(auxx.cont_id);
            // console.table(rows[0].dataset.json.cont_id);
            console.table(rows.length);
            // var cont = new FormData();
            // cont = formToObject(cont);
            TODO:
            // cont.cont_id =  111;
            //    datos_contenedor.push(cont);
            
            for(var c=0; c<rows.length; c++){
            auxx = JSON.parse(rows[c].dataset.json);
            var cont = new FormData();
            cont = formToObject(cont);
            cont.cont_id =  auxx.cont_id;
            datos_contenedor.push(cont);
            }
            console.log(cont.cont_id);
            // rows.each(function(i,e) {  
            // 			datos_contenedor.push(getJson(e));
            // 			// datos_contenedores.push("usuarioAp:");
            // 			// datos_contenedores.push("otro:");
            // 	});	
            datos.contenedores = datos_contenedor;

            console.table(datos_contenedor);

            if (datos_contenedor.lenght == 0) {
            alert('Sin Datos para Registrar.');
            return;
            }

            $.ajax({
            type: "POST",
            data: {datos},
            url: "general/Estructura/OrdenTransporte/Guardar_ordentransporte",
            success: function(respuesta) {
                debugger;
                console.log(respuesta);
                if (respuesta == "ok") {
                    
                
                alertify.success("Agregado con exito");
                $("#formOrden")[0].reset();
                $("#boxDatos").hide(500);
                $("#botonAgregar").removeAttr("disabled");
                $("#chofer").attr('readonly');
                $('#contenedores').show();
                var table = $('#tbl_cont').DataTable();
                table.clear().draw();
                //  $('#formCircuitos').data('bootstrapValidator').resetForm();
                //  $("#formCircuitos")[0].reset();


                //  $("#boxDatos").hide(500);
                //  $("#botonAgregar").removeAttr("disabled");

                } else {
                console.log(respuesta);
                alertify.error("error al lanzar Orden de trabajo con el contenedor seleccionado");
                $("#formOrden")[0].reset();
                $("#boxDatos").hide(500);
                $("#botonAgregar").removeAttr("disabled");
                $("#chofer").attr('readonly');
                $('#contenedores').show();
                var table = $('#tbl_cont').DataTable();
                table.clear().draw();
                }
            }
            });
        }else{
            alert("ATENCION!!! No selecciono Disposicion Final");
        }
    }else{
        alert("ATENCION!!! no se puede generar la orden de trabajo sin contenedores asignados");
    }
    
}


//<!--______________________________--> 
//<!-- SCRIPT GUARDAR CIRCUITO -->


$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/OrdenTransporte/lista_orden_transporte");

function Guardar_Orden() {

    // datos = $('#formCircuitos').serialize();

    var datos = new FormData($('#formCircuitos')[0]);
    datos = formToObject(datos);
    // datos.imagen = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBAUEBAYFBQUGBgYHCQ4JCQgICRINDQoOFRIWFhUSFBQXGiEcFxgfGRQUHScdHyIjJSUlFhwpLCgkKyEkJST/2wBDAQYGBgkICREJCREkGBQYJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCT/qZtBbZ5Dgu9jNCsrsLjQMxGR2ki2sWDpsEFRQHXKDZkrGAjbKdG32rZcSt9J2KSoLHrYT8Ubr8VhhNDsudf6ABGYCd1jD83HjQWss27BTo1YU1s+iipSU7doMEYy71FIDsBuIr7I2UdbQAzh5hGAr2YNoqN2r1uaxis5AdGOFAx9sQ+IbO250AlxNZXkYW202fTO8OuqKBCjYRlUYYWX/8AH8dK3/IjwLsQrKxkAGlhb4zXoP8AHE1Yn8o4YRl6yjYQuuPr+pyLexkigpLDsc5Pt4m2kBhbeKPKqbK7h4VsCy4WQsYAAEG0wsLFSbGB7NqQPORjzFPhrP8AEluI7LNi6+dwVC+2Pa7PX+4hCSwho2M5iKXmjE1VdoCF4QBAo0VtCznU3Bgn4nG0ZDt/6LJ5DWAFrV1bQgBGVcEz9TBeaEQDaeEmuBplyuxmJj2ZQ68nimieQP2TAMzsYMDBdEtwwI1ZgoM/RAmniLuZkzwBsTA/4dZMrHnwpFwML/njrnU1zODOP+TPUN";
    datos.usuario_app = "nachete"; //HARCODE - falta asignar funcion que asigne tipo usuario
    console.log(datos);




    //--------------------------------------------------------------

    if ($("#formCircuitos").data('bootstrapValidator').isValid()) {
        $.ajax({
            type: "POST",
            data: {
                datos
            },
            url: "general/Estructura/Zona/Guardar_Circuito",
            success: function(r) {
                console.log(r);
                if (r == "ok") {

                    $("#cargar_tabla").load(
                        "<?php echo base_url(); ?>index.php/general/Estructura/OrdenTransporte/lista_orden_transporte"
                    );
                    alertify.success("Agregado con exito");

                    $('#formCircuitos').data('bootstrapValidator').resetForm();
                    $("#formCircuitos")[0].reset();


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


<!--_____________________________________________________________-->
<!-- Script para mostrar por empresa las movilidades y choferes disponibles y por movilidad su respectiva informacion -->
<script>
$(".emp").on('click', function() {

    var json = this.dataset.json;

    json = JSON.parse(json);

    var html_mov = " ",
        html_chof = "";

    json.movilidades.movilidad.forEach(function(valor) {
        html_mov += "<option class='movilito' data-reg='" + valor.registro + "' data-dom='" + valor
            .dominio + "'>" + valor.nom_movil + "</option>"
    });

    json.choferes.chofer.forEach(function(valor) {
        html_chof += "<option class='chof'>" + valor.nom_chofer + "</option>"
    });

    $('#selecmov').html(html_mov);
    $("#chofer").html("<option value='' disabled selected>-Seleccione opcion-</option>" + html_chof);

    $("#registron").val("");
    $("#dominio").val("");
});

$("#selecmov").on('change', function() {

    var sel = $(this).find(":selected");
    $("#registron").val(sel.data('reg'));
    $("#dominio").val(sel.data('dom'));

});
</script>

<!--_____________________________________________________________-->
<!--Script Bootstrap Validacion.-->

<script>
$('#formContenedores').bootstrapValidator({
    message: 'This value is not valid',
    /*feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },*/
    //excluded: ':disabled',
    fields: {
        codigo: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
                regexp: {
                    regexp: /^[a-zA-Z0-9_]*$/,
                    message: 'la entrada no debe ser un numero entero'
                }
            }
        },
        descripcion: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
            }
        },
        fec_alta: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
            }
        },
        reci_id: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },
                regexp: {
                    regexp: /^(0|[1-9][0-9]*)$/,
                    message: 'la entrada debe ser un numero entero'
                }
            }
        },
        anio_elaboracion: {
            message: 'la entrada no es valida',
            validators: {
                notEmpty: {
                    message: 'la entrada no puede ser vacia'
                },

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
                },
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
                },
            }
        },
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
    //guardar();
});
</script>

<!-- Script Agregar datos -->

<script>
function guardar() {

    datos = $('#formDatos').serialize();

    //datos para mostrar a modo de ejemplo para DEMO---------------
    //Serialize the Form
    var values = {};
    $.each($("#formDatos").serializeArray(), function(i, field) {
        values[field.name] = field.value;
    });
    //Value Retrieval Function
    var getValue = function(valueName) {
        return values[valueName];
    };
    //Retrieve the Values
    var tipo_residuo = getValue("tipo_residuo");
    var contenedor = getValue("contenedor");
    var porcent_llenado = getValue("porcent_llenado");
    var metroscubicos = getValue("metroscubicos");
    //--------------------------------------------------------------

    if ($("#formDatos").data('bootstrapValidator').isValid()) {

        $.ajax({
            type: "POST",
            data: datos,
            url: "ajax/Ordentrabajo/guardarResiduo",
            success: function(r) {
                if (r == "ok") {
                    //console.log(datos);
                    html = '<tr role="row" class="even"><td>' + tipo_residuo + '</td><td>' + contenedor +
                        '</td><td>' + porcent_llenado + '</td><td>' + metroscubicos + '</td></tr>';
                    $('#primero').after(html);
                    $('#formDatos').data('bootstrapValidator').resetForm(true);
                    alertify.success("Agregado con exito");
                } else {
                    //console.log(r);
                    alertify.error("error al agregar");
                }
            }
        });
    }
}
</script>


<!-- Script Agregar Residuo -->

<script>
function agregarResiduo() {

    $('#formResiduo').on('submit', function(e) {
        //console.log("aloha madrefoca");
        e.preventDefault();
        var me = $(this);
        if (me.data('requestRunning')) {
            return;
        }
        me.data('requestRunning', true);

        datos = $('#formResiduo').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "ajax/Ordentrabajo/guardarResiduo",
            success: function(r) {
                if (r == "ok") {
                    console.log(r);
                    $('#formResiduo')[0].reset();
                    alertify.success("Agregado con exito");
                }
            },
            complete: function() {
                me.data('requestRunning', false);
            }
        });

    });

}
</script>


<!--_____________________________________________________________-->
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
</script>

<script>
$("#btnclose").on("click", function() {
    $("#boxDatos").hide(500);
    $("#botonAgregar").removeAttr("disabled");
    $('#formDatos').data('bootstrapValidator').resetForm();
    $("#formDatos")[0].reset();
    $('#selecmov').find('option').remove();
    $('#chofer').find('option').remove();
});
</script>


<!--_____________________________________________________________-->
 <!-- script Fecha-->

 <script>
$('#fecha').daterangepicker({
    "autoApply": true,
    "singleDatePicker": true,
    "timePicker": true,
    "toggleActive":false,
    "todayHighlight":false,    
    "locale": {
              "format":'YYYY/MM/DD h:mm:ss',
              "applyLabel": "Aplicar",
              "cancelLabel": "Cancelar"
              //format: 'MM/DD/YYYY h:mm:ss'
            }
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD hh:mm:ss') + ' to ' + end.format('YYYY-MM-DD hh:mm:ss') + ' (predefined range: ' + label + ')');
});

</script>

