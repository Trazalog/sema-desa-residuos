<style>
    .form-control,
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border-radius: 0px !important;
    }
</style>
<div id="filtros" class="row" style="padding-left:20px;padding-right:20px">
    <div class="col-md-12" >
        <div>
            <!--class="box-body" -->
            <div class="form-group">
                <input value="<?php echo $funcion ?>" class="hidden funcion"></input>
                    <?php foreach ($filtro as $key => $o) { ?>
                        <div class="form-group col-md-4">
                            <label class="text-withe" for="flt-<?php echo $key ?>"><?php echo ucfirst($key) ?>:</label>
                            <select id="flt-<?php echo $key ?>" name="<?php echo $key ?>" class="form-control filtro">
                                <option value="" selected >Todos</option>
                                <?php foreach ($o as $opt) {
                                    // if ($opt->id) {
                                    //     echo "<option value='$opt->id'>$opt->nombre</option>";
                                    // } else {
                                    //     echo "<option value='$opt->nombre'>$opt->nombre</option>";
                                    // }
                                    echo "<option value='$opt'>$opt</option>";
                                } ?>
                            </select>
                        </div>
                    <?php } ?>
            </div>
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


    //script para filtrar al elegir una opcion 
    $('.filtro').change(function(){
        // alert(this.value);
        data = this.value;
        aux = $('.funcion').val();
        // alert(aux);
        $.ajax({
            type: 'POST',
            data: {
                data
            },
            url: 'Reportes/' + aux,
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
    });
</script>