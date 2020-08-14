<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4>Registro de incidencias</h4>
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
wo();
$.ajax({
    type: 'GET',
    dataType:'JSON',
    url:'general/Estructura/Vehiculo/obtenerUbicaciones',
    success: function(rsp) {
        for(var i=0;i<rsp.length;i++)
        {
            var html = `<h4 style='text-align:center'>${rsp[i].dominio}</h4><b>Chofer</b>: ${rsp[i].nombre_chofer}<br><div id='desplegable' hidden><b>DNI</b>: ${rsp[i].dni_chofer}<br>Transportista: ${rsp[i].transportista}<br><b>Cuit</b>: ${rsp[i].cuit}<br><b>Fecha</b>: ${rsp[i].fecha}<br><b>Estado de OT</b>: ${rsp[i].ortr_estado}<br><b>Id OT</b>: ${rsp[i].ortr_id}</div>`;
            setMarcador(rsp[i].lat,rsp[i].lng,html);
        }
    },
    error: function() {
    },
    complete: function() {
        wc();
    }
});

$('#vehi_id').on('change',function(){

var dominio = this.value;
console.log(dominio);
wo();
$.ajax({
    type: 'GET',
    dataType:'JSON',
    data:{dominio},
    url:'general/Estructura/Vehiculo/obtenerUbicacion',
    success: function(rsp) {
        zoom(rsp.lat,rsp.lng);
    },
    error: function() {
    },
    complete: function() {
        wc();
    }
});

});
</script>