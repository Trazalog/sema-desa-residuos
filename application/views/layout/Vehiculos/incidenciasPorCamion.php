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
    url:'general/Estructura/Vehiculo/obtenerIncidencias',
    success: function(rsp) {
        console.log(rsp);
        for(var i=0;i<rsp.length;i++)
        {
            var html = `<h4 style='text-align:center'>${rsp[i].dominio}</h4><b>Chofer</b>: ${rsp[i].nombre_chofer}<br><div id='desplegable' hidden><b>Transportista</b>: ${rsp[i].transportista}<br><b>ID OT</b>: ${rsp[i].ortr_id}<br><b>ID incidencia</b>: ${rsp[i].inci_id}<br><b>Descrición</b>: ${rsp[i].descripcion}<br><b>Fecha</b>: ${rsp[i].fecha}<br><b>Usuario app</b>: ${rsp[i].usuario_app}<br><b>Tipo incidencia</b>: ${rsp[i].tipo_incidencia}<br><b>N° acta</b>: ${rsp[i].numero_acta}<br><b>Disposición final</b>: ${rsp[i].disposicion_final}<br><b>Tipo de carga</b>: ${rsp[i].tipo_carga}</div>`;
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
    url:'general/Estructura/Vehiculo/obtenerIncidenciasPorVehiculo',
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