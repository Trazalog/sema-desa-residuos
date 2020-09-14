<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
<<<<<<< Updated upstream
                <h4>Alta Deposito</h4>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="Tipo_incidencia" name="deposito">Selecione Deposito:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="tipo_incidencia">
                            <option value="0" disabled selected>-Seleccione opcion-</option>
                            <?php
                                // foreach($depositos as $depo)
                                // {
                                //     echo "<option value='$depo->depo_id'>$depo->descripcion</option>";
                                // }
                            ?>
                        </select>
                    </div>
                </div> -->
                <form id="formEstablecimiento" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <label style="margin-left:10px" for="">Establecimiento:</label>
                                <div class="col-md-12  input-group" style="margin-left:15px">
                                    <select class="form-control select2 select2-hidden-accesible" id="establecimiento"
                                        name="establecimiento" onchange="selectEstablecimiento()" <?php echo req() ?>>
                                        <option value="" disabled selected>Seleccionar</option>
                                        <?php
                                            foreach ($establecimiento as $i) {
                                            echo "<option value = $i->esta_id>$i->nombre</option>";
                                            }
                                        ?>
                                    </select>
                                    <span id="estabSelected" style="color: forestgreen;"></span>
                                </div>
                            </div>
                            <!-- ___________________________________________________ -->
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <label for="" style="margin-left:10px">Depósito:</label>
                                <div class="col-md-12  input-group" style="margin-left:15px">
                                    <select class="form-control select2 select2-hidden-accesible" id="depositos"
                                        name="depositos" onchange="selectDeposito()" <?php echo req() ?>>
                                    </select>
                                    <span id="deposSelected" style="color: forestgreen;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
=======
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
>>>>>>> Stashed changes
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<< Updated upstream

<script>

$('#tipo_incidencia').on('change', function() {
    var aux = this.value;
    wbox('#boxes');
    $.ajax({
        type: 'GET',
        url: 'Test/obtenerRecipientes/' + aux,
        success: function(rsp) {
            $('#grid >').remove();
            $('#grid').prepend(rsp);
        },
        error: function() {},
        complete: function() {
            wbox();
        }
    });
});

function btnVolcarRecidest(comp) {
    console.log(this.value);
    let id = comp.id;
    console.table("btnVolcar");
    var idfinal = "";

    // obtiene el id del boton que se selecciono
    for (var i = 0; i < id.length; i++) {
        if (id[i] != "/") {
            if (id[i] != "@") {
                idfinal = idfinal + id[i];
            }

        }

        if (id[i] == "@") {
            i = id.length;
        }
    }

    $("#idBox").val(idfinal); // Guarda el id en un input que esta oculto
    $("." + idfinal).attr("style", "background: #56bd4f"); // cambio el color de fondo del boton
    $(".btnMatriz").attr("disabled",
    ""); // a todos lo demas botones que de hecho todos tienen la misma clase btnMatriz se los desactiva
    datareci = JSON.parse($("." + idfinal).attr("data-json")); // aca obtenego todos los datos de ese recipiente
    console.table(datareci);
    $("#reci_id").val(datareci.reci_id); // en este input guardo el id del recipiente que luego usare 
    //  console.table($("#reci_id").val());
    wbox('#boxes');
    $.ajax({
        type: 'POST',
        data: datareci,
        url: 'Test/llenarDeposito',
        success: function() {},
        error: function() {},
        complete: function() {
            wbox();
        }
    });

}

function selectEstablecimiento() {
    var esta_id = $('#establecimiento').val();
    $('#estabSelected').text('');
    $('#deposSelected').text('');
    $('#recipSelected').text('');

    wo();
    $.ajax({
      type: 'GET',
      data: {
        esta_id: esta_id
      },
      dataType: 'JSON',
      url: 'Test/obtenerEstablecimientos/',
      success: function(rsp) {
          console.log(rsp);
        var datos = "<option value='' disabled selected>Seleccionar</option>";
        for (let i = 0; i < rsp.length; i++) {
          datos += "<option value=" + rsp[i].depo_id + ">" + rsp[i].descripcion + "</option>";
        }
        selectSearch('establecimiento', 'estabSelected');
        $('#depositos').html(datos);
      },
      error: function(rsp) {
        if (rsp) {
          alert(rsp.responseText);
        } else {
          alert("No se pudieron cargar los depositos del establecimiento seleccionado.");
        }
      },
      complete: function(rsp) {
        wc();
      },
    })
  }

  function selectDeposito() {
    var esta_id = $('#establecimiento').val();
    var depo_id = $('#depositos').val();
    $('#deposSelected').text('');
    $('#recipSelected').text('');
    wo();
    $.ajax({
      type: 'GET',
      data: {
        esta_id: esta_id,
        depo_id: depo_id
      },
      dataType: 'JSON',
      url: 'Test/obtenerRecipientesDeposito/',
      success: function(rsp) {
        var datos = "<option value='' disabled selected>Seleccionar</option>";
        for (let i = 0; i < rsp.length; i++) {
          datos += "<option value=" + rsp[i].nombre + ">" + rsp[i].nombre + "</option>";
        }
        selectSearch('depositos', 'deposSelected');
        $('#tipo_residuo').html(datos);
      },
      error: function(rsp) {
        if (rsp) {
          alert(rsp.responseText);
        } else {
          alert("No se pudieron cargar los recipientes.");
        }
      },
      complete: function(rsp) {
        wc();
      },
    })
  }
=======
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
>>>>>>> Stashed changes
</script>