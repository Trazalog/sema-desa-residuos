<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4>Alta Deposito</h4>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Tipo_incidencia" name="deposito">Selecione Deposito:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tipo_incidencia">
                            <option value="0" disabled selected>-Seleccione opcion-</option>
                            <?php
                                foreach($depositos as $depo)
                                {
                                    echo "<option value='$depo->depo_id'>$depo->descripcion</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary animated bounceInDown" id="boxes">
            <div class="box-header with-border">
                <h5>Tamaño del deposito</h5>
                <div class="box-tools pull-right">
                    <button type="button" id="btnclose" title="cerrar" class="btn btn-box-tool" data-widget="remove"
                        data-toggle="tooltip" data-original-title="Remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <!-- <div class="col-md-12">
                    <button type="button" id="botonAgregar" class="btn btn-success" aria-label="Left Align"
                        onclick="agregarElemento()">
                        <i class="fa fa-plus"></i> Agregar elemento
                    </button><br><br>
                </div> -->
                <div class="col-md-12" id="grid">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#tipo_incidencia').on('change', function() {
    var aux = this.value;
    wbox('#boxes');
    $.ajax({
        type: 'GET',
        url: 'Test/obtenerRecipientes/' + aux,
        success: function(rsp) {
            console.log(rsp);
            $('#grid >').remove();
            $('#grid').prepend(rsp);
        },
        error: function() {},
        complete: function() {
            wbox();
        }
    });
});
</script>