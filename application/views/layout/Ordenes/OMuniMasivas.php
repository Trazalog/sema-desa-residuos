<!---//////////////////////////////////////---BOX 1---///////////////////////////////////////////////////////----->

<div class="box box-primary animated bounceInDown" id="boxDatos">
    <div class="box-header with-border">
        <div class="box-tittle">
            <h4>Ordenes Municipales Masivas</h4>
        </div>
    </div>
</div>

<!---//////////////////////////////////////---FIN BOX 1---///////////////////////////////////////////////////////----->
        
        <!-- SEPARADOR -->
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
    <!-- Modal info-->
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="form-group">
                                <label for="fechita" class="form-label">Fecha:</label>
                                <input type="text" id="fechainfo" class="form-control input-sm" readonly>
                            </div> -->
                            <div class="form-group">
                                <label for="zonita" class="form-label">Zona:</label>
                                <input type="text" id="zonainfo" class="form-control input-sm" readonly>
                            </div>
                            <div class="form-group">
                                <label for="dispofinal" class="form-label">Disposicion final</label>
                                <input type="text" id="dispofinalinfo" class="form-control input-sm" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tipores" class="form-label">Tipo de residuo:</label>
                                <input type="text" id="tiporesinfo" class="form-control input-sm" readonly>
                            </div>
                            <div class="form-group">
                                <label for="circuit" class="form-label">Circuito:</label>
                                <input type="text" id="circinfo" class="form-control input-sm" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="empresita" class="form-label">Empresa:</label>
                                <input type="text" id="empinfo" class="form-control input-sm" readonly>
                            </div>
                            <div class="form-group">
                                <label for="movi" class="form-label">Movilidad:</label>
                                <input type="text" id="movinfo" class="form-control input-sm" readonly>
                            </div>
                            <div class="form-group">
                                <label for="chof" class="form-label">Chofer:</label>
                                <input type="text" id="chofinfo" class="form-control input-sm" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-default" id="btnsave" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Fin Modal  -->
<!--Boton ejecutar Ots-->
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary pull-right" onclick="EjecutarOTs()">Ejecutar OTs</button>
    </div>            
<!--__________________________________________________________________________________________-->

 <!---//////////////////////////////////////--COMIENZO SCRIPTS--///////////////////////////////////////////////////////----->
<script>
$("#cargar_tabla").load("<?php echo base_url(); ?>index.php/general/Estructura/OrdenMuniMasivas/Listar_OrdenesMuniMasivas");


</script>
<script>

</script>

<script>
  
    //Initialize Select2 Elements
    $('.select3').select2();
</script>