<style>
    .form-control,
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border-radius: 0px !important;
    }
</style>
<div id="filtros" class="row" style="padding-left:20px;padding-right:20px">
    <div class="col-md-12">
        <div>
            <!--class="box-body" -->
            <form id="formulario">
                <div class="form-group">

                    <?php if (isset($desde) && $desde) { ?>
                        <div class="form-group col-md-3">
                            <label for='flt-desde'><?php echo $numero ?> desde:</label>
                            <input id='flt-desde' name="desde" placeholder='Ingrese valor' class='form-control'>
                        </div>
                    <?php } ?>
                    <?php if (isset($hasta) && $hasta) { ?>
                        <div class="form-group col-md-3">
                            <label for='flt-hasta'><?php echo $numero ?> hasta:</label>
                            <input id='flt-hasta' name="hasta" placeholder='Ingrese valor' class='form-control'>
                        </div>
                    <?php } ?>
                    <?php if (isset($calendarioDesde) && $calendarioDesde) { ?>
                        <div class="form-group col-md-3">
                            <label for="datepickerDesde">Fecha desde:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" id="datepickerDesde" name="datepickerDesde" placeholder="Seleccione fecha">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($calendarioHasta) && $calendarioHasta) { ?>
                        <div class="form-group col-md-3">
                            <label for="datepickerHasta">Fecha hasta:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" id="datepickerHasta" name="datepickerHasta" placeholder="Seleccione fecha">
                            </div>
                        </div>
                    <?php } ?>
                    <?php foreach ($filtro as $key => $o) { ?>
                        <div class="form-group col-md-3">
                            <label class="text-withe" for="flt-<?php echo $key ?>"><?php echo ucfirst($key) ?>:</label>
                            <select id="flt-<?php echo $key ?>" name="<?php echo $key ?>" class="form-control">
                                <option value="" selected>Todos</option>
                                <?php foreach ($o as $opt) {
                                    if ($opt->id) {
                                        echo "<option value='$opt->id' onchange='nombreDeLaFuncion(this)'>$opt->nombre</option>";
                                    } else {
                                        echo "<option value='$opt->nombre'>$opt->nombre</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                    <?php } ?>
                    
                    <br>
                    <!-- <div class="form-group col-md-4">
                        <button type="button" value="Limpiar" class="btn btn-block btn-danger btn-flat flt-clear">Limpiar Todo</button>
                        <button type="button" value="Filtrar" class="btn btn-block btn-success btn-flat" onclick="filtrar()">Filtrar</button>
                        <input type="hidden" value="<?php echo $op ?>" id="op" hidden="true">
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- bootstrap datepicker -->

<script>    

    $('.flt-clear').click(function() {
        $('#formulario')[0].reset();       
    });
    $('.datepicker').datepicker({
        autoclose: true
    })



    $('.filtro').onchange(this, function({

    }));



    function nombreDeLaFuncion(valor){
        var data = $(valor).val();
        var filtro = 'zona';
        filtroAajax(data, filtro);
    }

    function filtroAajax(data, filtro){
        $.ajax({
            type: 'POST',
            data: {
                data
            },
            url: 'Reportes/' + filtro,
            success: function(result) {
                console.log(result);
                $('#reportContent').empty();
                $('#reportContent').html(result);
            },
            error: function() {
                alert('Error');
            },
            complete: function(data) {
                wc();
            }
        })
    }

    // function filtrar() {
    //     var data = new FormData($('#formulario')[0]);
    //     data = formToObject(data);
    //     console.log(data);
    //     wo();
    //     var url = $('#op').val();
    //     $.ajax({
    //         type: 'POST',

    //         data: {
    //             data
    //         },
    //         url: 'Reportes/' + url,
    //         success: function(result) {
    //             console.log(result);
    //             $('#reportContent').empty();
    //             $('#reportContent').html(result);
    //         },
    //         error: function() {
    //             alert('Error');
    //         },
    //         complete: function(data) {
    //             wc();
    //         }
    //     });
    }
</script>