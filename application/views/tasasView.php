<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4>Reporte toneladas liquidadas</h4>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Filtro de fecha:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="reportrange">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Empresa contribuyente:</label>
                                    <?php
                            echo "<select class='form-control' id='id_contribuyente'>";
                            echo "<option selected disabled> -default- </option>";
                            foreach($contribuyentes as $con){
                                echo "<option id='$con->nombre'>$con->nombre</option>";
                            }
                            echo "</select>";
                            ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipo de reciduo:</label>
                                    <?php
                            echo "<select class='form-control' id='id_reciduo'>";
                            echo "<option selected disabled> -default- </option>";
                            foreach($reciduos as $reci)
                            {
                                echo "<option id='$reci->id'>$reci->nombre</option>";
                            }
                            echo "</select>";
                            ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Estado de deuda:</label>
                                    <?php
                            echo "<select class='form-control' id='id_estado'>";
                            echo "<option selected disabled> -Default- </option>";
                            foreach($estados as $es)
                            {
                                echo "<option id='$es->id'>$es->tipo</option>";
                            }
                            echo "</select>";
                            ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3>Total Adeudado</h3>
                    </div>
                    <div class="box-body" style="text-align:center">
                        <h1>5000</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover table-bordered" id="tabla_contri">
                            <thead>
                                <tr>
                                    <th>Empresa contribuyente</th>
                                    <th>Tipo de Reciduo</th>
                                    <th>Vertido</th>
                                    <th>Pagos</th>
                                    <th>Deuda</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// $('#tabla_contri').dataTable();

$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                'month').endOf('month')]
        },

        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Personalizado",
            "weekLabel": "W",
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
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ]
        }
    }, cb);

    cb(start, end);

});

/*******CARGA TABLA CON CONTRIBUYENTES*******/
$.ajax({
    dataType: 'JSON',
    type: 'GET',
    url: 'tasas/obtenerToneladasLiquidadas',
    success: function(res) {
        $('#tabla_contri tbody').empty();
        res.forEach(function(e) {
            var htmlTags = '<tr id="' + e.empresa + '">' +
                '<td>' + e.empresa + '</td>' +
                '<td>' + e.tipo_reci + '</td>' +
                '<td>' + e.vertido + '</td>' +
                '<td>' + e.pagos + '</td>' +
                '<td>' + e.deuda + '</td>' +
                '<td>' + e.estado + '</td>' +
                '</tr>';
            $('#tabla_contri tbody').append(htmlTags);
            $('#tabla_contri tfoot').attr('hidden', true);
        });
        $('#tabla_contri').dataTable();
    },
    error: function() {},
    complete: function() {}
});

//APLICAR FILTRO POR CONTRIBUYENTE
$('#id_contribuyente').on('change', function() {
    var contribuyente = this.value;
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'tasas/toneladasPorContribuyente/' + contribuyente,
        success: function(res) {
            $('#tabla_contri tbody').empty();
            res.forEach(function(e) {
                var htmlTags = '<tr id="' + e.empresa + '">' +
                    '<td>' + e.empresa + '</td>' +
                    '<td>' + e.tipo_reci + '</td>' +
                    '<td>' + e.vertido + '</td>' +
                    '<td>' + e.pagos + '</td>' +
                    '<td>' + e.deuda + '</td>' +
                    '<td>' + e.estado + '</td>' +
                    '</tr>';
                $('#tabla_contri tbody').append(htmlTags);
                $('#tabla_contri tfoot').attr('hidden', true);
            });
            $('#tabla_contri').dataTable();
        },
        error: function() {},
        complete: function() {}
    });
});

//APLICAR FILTRO POR TIPO DE RECIDUO
$('#id_reciduo').on('change', function() {
    var reciduo = this.value;
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        data: reciduos,
        url: 'tasas/toneladasPorReciduo/' + reciduo,
        success: function(res) {
            $('#tabla_contri tbody').empty();
            res.forEach(function(e) {
                var htmlTags = '<tr id="' + e.empresa + '">' +
                    '<td>' + e.empresa + '</td>' +
                    '<td>' + e.tipo_reci + '</td>' +
                    '<td>' + e.vertido + '</td>' +
                    '<td>' + e.pagos + '</td>' +
                    '<td>' + e.deuda + '</td>' +
                    '<td>' + e.estado + '</td>' +
                    '</tr>';
                $('#tabla_contri tbody').append(htmlTags);
                $('#tabla_contri tfoot').attr('hidden', true);
            });
            $('#tabla_contri').dataTable();
        },
        error: function() {},
        complete: function() {}
    });
});

//APLICAR FILTRO POR ESTADO
$('#id_estado').on('change', function() {
    var estado = this.value;
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'tasas/toneladasPorEstado/' + estado,
        success: function(res) {
            $('#tabla_contri tbody').empty();
            res.forEach(function(e) {
                var htmlTags = '<tr id="' + e.empresa + '">' +
                    '<td>' + e.empresa + '</td>' +
                    '<td>' + e.tipo_reci + '</td>' +
                    '<td>' + e.vertido + '</td>' +
                    '<td>' + e.pagos + '</td>' +
                    '<td>' + e.deuda + '</td>' +
                    '<td>' + e.estado + '</td>' +
                    '</tr>';
                $('#tabla_contri tbody').append(htmlTags);
                $('#tabla_contri tfoot').attr('hidden', true);
            });
            $('#tabla_contri').dataTable();
        },
        error: function() {},
        complete: function() {}
    });
});

//FILTRO POR FECHA
//ESTA MAL EN TEORIA, DEBERIA SER METODO GET
$('#reportrange').on('change', function() {
    var fechas = this.value;
    console.log(fechas);
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        data: {
            fechas
        },
        url: 'tasas/toneladasPorFecha/',
        success: function(res) {
            $('#tabla_contri tbody').empty();
            res.forEach(function(e) {
                var htmlTags = '<tr id="' + e.empresa + '">' +
                    '<td>' + e.empresa + '</td>' +
                    '<td>' + e.tipo_reci + '</td>' +
                    '<td>' + e.vertido + '</td>' +
                    '<td>' + e.pagos + '</td>' +
                    '<td>' + e.deuda + '</td>' +
                    '<td>' + e.estado + '</td>' +
                    '</tr>';
                $('#tabla_contri tbody').append(htmlTags);
                $('#tabla_contri tfoot').attr('hidden', true);
            });
            $('#tabla_contri').dataTable();
        },
        error: function() {},
        complete: function() {}
    });
});
</script>