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
                    <button type="button" id="botonAgregar" class="btn btn-success" aria-label="Left Align" onclick="agregarElemento()">
                        <i class="fa fa-plus"></i> Agregar elemento
                    </button><br><br>
                </div> -->
                <div class="col-md-2">
                    <div id="trash" style="padding: 15px; margin-bottom: 15px;" class="text-center">
                        <div>
                            <ion-icon name="trash" style="font-size: 400%"></ion-icon>
                        </div>
                        <div>
                            <span>Drop here to remove!</span>
                        </div>
                    </div>
                    <div class="newWidget grid-stack-item">
                        <div class="card-body grid-stack-item-content bg-black">
                            <div>
                                <ion-icon name="add-circle" style="font-size: 400%"></ion-icon>
                            </div>
                            <div>
                                <span>Drag me in into the dashboard!</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-10">
                    <div class="grid-stack" data-gs-animate="yes">
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="4" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">1</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="4" data-gs-y="0" data-gs-width="4" data-gs-height="4"
                            data-gs-no-move="yes" data-gs-no-resize="yes" data-gs-locked="yes">
                            <div class="grid-stack-item-content bg-black">I can't be moved or dragged!
                                <br>
                                <ion-icon name="ios-lock" style="font-size:300%"></ion-icon>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="8" data-gs-y="0" data-gs-width="2" data-gs-height="2"
                            data-gs-min-width="2" data-gs-no-resize="yes">
                            <div class="grid-stack-item-content bg-black" style="overflow: hidden">
                                <p class="card-text text-center" style="margin-bottom: 0">
                                    Drag me!
                                    <p class="card-text text-center" style="margin-bottom: 0">
                                        <ion-icon name="hand" style="font-size: 300%"></ion-icon>
                                        <p class="card-text text-center" style="margin-bottom: 0">
                                            ...but don't resize me!
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="10" data-gs-y="0" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black"> 4</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="2" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">5</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="2" data-gs-y="2" data-gs-width="2" data-gs-height="4">
                            <div class="grid-stack-item-content bg-black">6</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="8" data-gs-y="2" data-gs-width="4" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">7</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="4" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">8</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="4" data-gs-y="4" data-gs-width="4" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">9</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="8" data-gs-y="4" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">10</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="10" data-gs-y="4" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content bg-black">11</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var grid = GridStack.init();

$('#tipo_incidencia').on('change', function() {
    var aux = this.value;
    wbox('#boxes');
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'Test/obtenerRecipientes/' + aux,
        success: function(rsp) {
            console.log(rsp);
        },
        error: function() {},
        complete: function() {
            wbox();
        }
    });
});

// function agregarElemento()
// {
//     var htmlTags = '<div class="grid-stack-item" data-gs-width="1" data-gs-height="1" data-gs-auto-position="yes"><div class="grid-stack-item-content bg-black "></div>';
//     $('.grid-stack').append(htmlTags);
//     var grid = GridStack.init();
// }

var grid = GridStack.init({
    alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
    ),
    resizable: {
        handles: 'e, se, s, sw, w'
    },
    removable: '#trash',
    removeTimeout: 100,
    acceptWidgets: '.newWidget'
});

grid.on('added', function(e, items) {
    log('added ', items)
});
grid.on('removed', function(e, items) {
    log('removed ', items)
});
grid.on('change', function(e, items) {
    log('change ', items)
});

function log(type, items) {
    var str = '';
    items.forEach(function(item) {
        str += ' (x,y)=' + item.x + ',' + item.y;
    });
    console.log(type + items.length + ' items.' + str);
}

// TODO: switch jquery-ui out
$('.newWidget').draggable({
    revert: 'invalid',
    scroll: false,
    appendTo: 'body',
    helper: 'clone'
});
</script>