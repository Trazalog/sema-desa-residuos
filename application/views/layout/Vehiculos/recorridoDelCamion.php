<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4>Recorrido del camión</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Camiones:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="vehi_id">
                            <option selected disabled>-Seleccionar camión-</option>
                            <?php
                            foreach($vehiculos as $ve)
                            {
                                echo "<option value='$ve->dominio'>$ve->descripcion</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4>Mapa</h4>
        </div>
        <div class="box-body" id='mapa'>
            <div class="row">
                <div class="col-md-12">
                <?php
                    $this->load->view('mapa/mapa');
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$('#vehi_id').on('change',function(){

var dominio = this.value;
wo();
$.ajax({
    type: 'GET',
    dataType:'JSON',
    data:{dominio},
    url:'general/Estructura/Vehiculo/obtenerRecorrido',
    success: function(rsp) {
        trazarCamino(rsp);
    },
    error: function() {
    },
    complete: function() {
        wc();
    }
});

});
</script>