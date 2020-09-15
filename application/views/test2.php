<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4>Reporte de Interno</h4>
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
                                    <th>Empresa</th>
                                    <th>TN RSU</th>
                                    <th>U.T. RSU</th>
                                    <th>$ RSU</th>
                                    <th>TN ESCOMBRERA</th>
                                    <th>U.T. ESCOMBRERA</th>
                                    <th>$ ESCOMBRERA</th>
                                    <th>TN VALORIZADO</th>
                                    <th>UT. VALORIZADO</th>
                                    <th>$ VALORIZADO</th>
                                    <th>TOTAL EN TN EMPRESA</th>
                                    <th>TOTAL UT. EMPRESA</th>
                                    <th>TOTAL EN $ EMPRESA</th>
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

/*******CARGA TABLA CON LAS EMPRESAS*******/
$.ajax({
    dataType: 'JSON',
    type: 'GET',
    url: 'Test/obtenerEmpresas',
    success: function(res) {
        console.log(res);
        $('#tabla_contri tbody').empty();
        res.forEach(function(e) {
            var htmlTags = '<tr id="' + e.emp_id + '">' +
                '<td>' + e.nombre + '</td>' +
                '<td>' + e.TN_RSU + '</td>' +
                '<td>' + e.UT_RSU + '</td>' +
                '<td>' + e.RSU + '</td>' +
                '<td>' + e.TN_ESCOMBRERA + '</td>' +
                '<td>' + e.UT_ESCOMBRERA + '</td>' +
                '<td>' + e.ESCOMBRERA + '</td>' +
                '<td>' + e.TN_VALORIZADO + '</td>' +
                '<td>' + e.UT_VALORIZADO + '</td>' +
                '<td>' + e.VALORIZADO + '</td>' +
                '<td>' + e.TOTAL_TN_EMPRESA + '</td>' +
                '<td>' + e.TOTAL_UT_EMPRESA + '</td>' +
                '<td>' + e.TOTAL_PESOS_EMPRESA + '</td>' +
                '</tr>';
            $('#tabla_contri tbody').append(htmlTags);
            $('#tabla_contri tfoot').attr('hidden', true);
        });
        $('#tabla_contri').dataTable();
    },
    error: function() {},
    complete: function() {}
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
        url: 'Test/filtrarEmpresas/',
        success: function(res) {
            $('#tabla_contri tbody').empty();
            res.forEach(function(e) {
                var htmlTags = '<tr id="' + e.emp_id + '">' +
                '<td>' + e.nombre + '</td>' +
                '<td>' + e.TN_RSU + '</td>' +
                '<td>' + e.UT_RSU + '</td>' +
                '<td>' + e.RSU + '</td>' +
                '<td>' + e.TN_ESCOMBRERA + '</td>' +
                '<td>' + e.UT_ESCOMBRERA + '</td>' +
                '<td>' + e.ESCOMBRERA + '</td>' +
                '<td>' + e.TN_VALORIZADO + '</td>' +
                '<td>' + e.UT_VALORIZADO + '</td>' +
                '<td>' + e.VALORIZADO + '</td>' +
                '<td>' + e.TOTAL_TN_EMPRESA + '</td>' +
                '<td>' + e.TOTAL_UT_EMPRESA + '</td>' +
                '<td>' + e.TOTAL_PESOS_EMPRESA + '</td>' +
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