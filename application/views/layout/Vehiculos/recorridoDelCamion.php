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
                <!--filtro desde hasta, con fecha y hora-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Filtrar por fecha:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" disabled class="form-control pull-right" id="filtroFecha">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <!---------------------------------------->
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
    $('#filtroFecha').removeAttr('disabled');
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

//Date range picker
moment.locale('es');
$('#filtroFecha').daterangepicker({
        ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes': [moment().startOf('month'), moment().endOf('month')],
        'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment(),
        locale:{
            "format":"DD-MM-YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "customRangeLabel": "Rango personalizado",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Semptiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ]
        }
    }
).on('change',function(){
    var rango = this.value;
    var dominio = $('#vehi_id').val();
    var array = rango.split(' - ',2);
    wo();
    $.ajax({
        type:'GET',
        data:{dominio},
        url:'general/Estructura/Vehiculo/obtenerRecorrido/'+array[0]+'/'+array[1],
        success: function() {
        },
        error: function() {
        },
        complete: function() {
            wc();
        }
    });
});
</script>