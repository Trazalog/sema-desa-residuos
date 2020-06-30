<!---//////////////////////////////////////---BOX 1---///////////////////////////////////////////////////////----->

<div class="box box-primary animated bounceInDown" id="boxDatos">
    <div class="box-header with-border">
        <div class="box-tittle">
            <h4>Ordenes Municipales Masivas</h4>
        </div>
    </div>

    <!--__________________________________________________________________________________________-->

    <div class="box-body">
        <form class="formContenedores" id="formOrdenesMuniMasivas" method="POST" autocomplete="off" class="registerForm">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Tipo de residuos-->
                    <div class="form-group">
                        <label for="tipoResiduos">Seleccione Tipo de residuo:</label>
                        <div class="input-group date" id="cargaa">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione tipo residuo"  style="width: 100%;"  id="tica_id" required>
                                    <?php
                                        foreach ($Carga as $i) {
                                        echo '<option  value="'.$i->tabl_id.'">'.$i->valor.'</option>';
                                        }
                                    ?>
                                </select>
                        </div>
                     </div>                
                <!--__________________________________________________________________________________________-->

                <!--Zonas-->
                    <div class="form-group">
                        <label for="zonas">Seleccione Zonas:</label>
                        <div class="input-group date" id="zonaa">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione zona"  style="width: 100%;"  id="zona_id" required>
                                    <?php
                                        foreach ($Zona as $j) {
                                            echo '<option  value="'.$j->zona_id.'">'.$j->nombre.'</option>';
                                        }
                                    ?>
                                </select>
                        </div>
                     </div>                
                <!--__________________________________________________________________________________________-->

            </div>


            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Estado-->
                     <div class="form-group">
                        <label for="estado">Estado:</label>
                        <div class="input-group date" id="estadoo">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione estado"  style="width: 100%;"  id="estado" required>
                                    <?php
                                        foreach ($Estado as $c) {
                                            echo '<option  value="'.$c->tabl_id.'">'.$c->valor.'</option>';
                                        }
                                    ?>
                                </select>
                        </div>
                     </div>                
                <!--__________________________________________________________________________________________-->

                <!--Circuito-->
                     <div class="form-group">
                        <label for="circuitos">Seleccione Circuitos:</label>
                        <div class="input-group date" id="circuitoo">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-check"></i></div>
                                <select class="form-control select3" multiple="multiple"  data-placeholder="Seleccione circuito"  style="width: 100%;"  id="circ_id" required>
                                    <?php
                                        foreach ($Circuito as $k) {
                                            echo '<option  value="'.$k->circ_id.'">'.$k->codigo.'</option>';
                                        }
                                    ?>
                                </select>
                        </div>
                     </div>                
                <!--__________________________________________________________________________________________-->

        </form>
    </div>
</div>

<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->

        <!-- SEPARADOR -->
        <div class="col-sm-12"></div>
        <div class="col-sm-12"></div>
        <!-- SEPARADOR -->

<!---//////////////////////////////////////--- TABLA ---///////////////////////////////////////////////////////----->

  <div class="box box-primary">
  
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>

                <!--__________________TABLA___________________________-->

                <div class="row"><div class="col-sm-12 table-scroll" id="cargar_tabla"></div>

                <!--__________________TABLA___________________________-->       

            </div>
        </div>
    </div>

    <!---//////////////////////////////////////--- FIN TABLA---///////////////////////////////////////////////////////----->


<!--Boton de guardado-->
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary pull-right" onclick="EjecutarOTs()">Ejecutar OTs</button>
    </div>            
<!--__________________________________________________________________________________________-->

 <!---//////////////////////////////////////--COMIENZO SCRIPTS--///////////////////////////////////////////////////////----->
<script>
$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/OrdenMuniMasivas/Listar_OrdenesMuniMasivas");

//SELECTORES FILTROS DE BUSQUEDAS RES, ZONA, ESTADO, CIRCUITO
//------------------------------------residuo--------------------------------
$("#tica_id").change(function(){
    var datostica = new FormData();
    datostica = formToObject(datostica);
    datostica.datos_tipo_carga= $('#tica_id').val();
    console.table(datostica.datos_tipo_carga);  

    //--------------------zona------------------------
    if($('#zona_id').val()==''){
        console.table("zona vacia");
        datostica.datos_zona= null;
    }else{
        console.table("zona no vacia");
        datostica.datos_zona= $('#zona_id').val();
        console.table(datostica.datos_zona); 
    }

    //--------------------circuito------------------------
    if($('#circ_id').val()==''){
        console.table("circuito vacio");
        datostica.datos_circuito= null;
    }else{
        console.table("circuito no vacio");
        datostica.datos_circuito= $('#circ_id').val();
        console.table(datostica.datos_circuito); 
    }

    //--------------------estado------------------------
    if($('#estado').val()==''){
        console.table("estado vacio");
        datostica.estado = null; 
    }else{
        console.table("estado no vacio");
        datostica.estado= $('#estado').val();
        console.table(datostica.estado); 
    }

    console.table(datostica);
});

//------------------------------------zona--------------------------------
$("#zona_id").change(function(){
    var datoszona = new FormData();
    datoszona = formToObject(datoszona);
    datoszona.datos_zona= $('#zona_id').val();
    console.table(datoszona.datos_zona);  

    //--------------------residuos------------------------
    if($('#tica_id').val()==''){
        console.table("residuo vacia");
        datoszona.datos_tipo_carga= null;
    }else{
        console.table("zona no vacia");
        datoszona.datos_tipo_carga= $('#tica_id').val();
        console.table(datoszona.datos_tipo_carga); 
    }

    //--------------------circuito------------------------
    if($('#circ_id').val()==''){
        console.table("circuito vacio");
        datoszona.datos_circuito= null;
    }else{
        console.table("circuito no vacio");
        datoszona.datos_circuito= $('#circ_id').val();
        console.table(datoszona.datos_circuito); 
    }

    //--------------------estado------------------------
    if($('#estado').val()==''){
        console.table("estado vacio");
        datoszona.estado = null; 
    }else{
        console.table("estado no vacio");
        datoszona.estado= $('#estado').val();
        console.table(datoszona.estado); 
    }

    console.table(datoszona);
     
});
//------------------------------------estado--------------------------------
$("#estado").change(function(){
 
    var datosestado = new FormData();
    datosestado = formToObject(datosestado);
    datosestado.estado= $('#estado').val();
    console.table(datosestado.estado);  

    //--------------------residuos------------------------
    if($('#tica_id').val()==''){
        console.table("residuo vacia");
        datosestado.datos_tipo_carga= null;
    }else{
        console.table("zona no vacia");
        datosestado.datos_tipo_carga= $('#tica_id').val();
        console.table(datosestado.datos_tipo_carga); 
    }

    //--------------------circuito------------------------
    if($('#circ_id').val()==''){
        console.table("circuito vacio");
        datosestado.datos_circuito= null;
    }else{
        console.table("circuito no vacio");
        datosestado.datos_circuito= $('#circ_id').val();
        console.table(datosestado.datos_circuito); 
    }

   //--------------------zona------------------------
   if($('#zona_id').val()==''){
        console.table("zona vacia");
        datosestado.datos_zona= null;
    }else{
        console.table("zona no vacia");
        datosestado.datos_zona= $('#zona_id').val();
        console.table(datosestado.datos_zona); 
    }

    console.table(datosestado);

});
//------------------------------------circuito--------------------------------
$("#circ_id").change(function(){

    var datoscirc = new FormData();
    datoscirc = formToObject(datoscirc);
    datoscirc.datos_circuito= $('#circ_id').val();
    console.table(datoscirc.datos_circuito);  

    //--------------------residuos------------------------
    if($('#tica_id').val()==''){
        console.table("residuo vacia");
        datoscirc.datos_tipo_carga= "null";
    }else{
        console.table("zona no vacia");
        datoscirc.datos_tipo_carga= $('#tica_id').val();
        console.table(datoscirc.datos_tipo_carga); 
    }

    //--------------------circuito------------------------
    if($('#estado').val()==''){
        console.table("estado vacio");
        datoscirc.estado= "null";
    }else{
        console.table("estado no vacio");
        datoscirc.estado= $('#estado').val();
        console.table(datoscirc.estado); 
    }

   //--------------------zona------------------------
   if($('#zona_id').val()==''){
        console.table("zona vacia");
        datoscirc.datos_zona= "null";
    }else{
        console.table("zona no vacia");
        datoscirc.datos_zona= $('#zona_id').val();
        console.table(datoscirc.datos_zona); 
    }

    console.table(datoscirc);
    console.table(datoscirc["datos_circuito"].length);
    console.table(datoscirc["datos_zona"]);
   
});

//FIN SELECTORES

</script>
<script>
  
    //Initialize Select2 Elements
    $('.select3').select2();
</script>