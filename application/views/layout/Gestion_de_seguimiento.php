<!-- /// ----------------------------------- HEADER ----------------------------------- /// -->

<div class="box box-primary animated fadeInLeft">
    <div class="box-header with-border">
        <h4>Gestion de seguimiento</h4>
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

<!---//////////////////////////////////////--- BOX 1 ---///////////////////////////////////////////////////////----->

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

    <!--____________________________________________________________________-->

    <div class="box-body">
        <form class="formGestionSeguimiento" id="formGestionSeguimiento" method="POST" autocomplete="off">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!--Estado-->
                <div class="form-group">
                    <label for="Estado">Estado:</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-check"></i>
                            </div>
                        <select class="form-control select2 select2-hidden-accesible"  name="Estado" id="Estado">
                            <option value="" disabled selected>-Seleccione opcion-</option>
                            <?php
                            foreach ($Estado as $i) {
                                echo '<option  value="'.$i->depa_id.'">'.$i->nombre.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!--____________________________________________________________________-->

            </div>

                <!--Buscador-->
                
                <!--____________________________________________________________________-->

        </form>
    </div>




</div>