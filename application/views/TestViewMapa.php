<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4>Ultimo registro del camión</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Camiones:</label>
                        <select class="form-control select2 select2-hidden-accesible" id="cami_id">
                            <option selected disable>-Seleccionar camión-</option>
                            <?php
                            foreach($camiones as $cam)
                            {
                                echo "<option value='$cam->dominio'>$cam->descripcion</option>";
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
                    <div id="mapid" style="height: 340px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

var map = L.map('mapid').setView([-31.5315272,-68.5527981], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

$('#cami_id').on('change',function(){

    // console.log(this.value);
    var dominio = this.value;
    wbox('#mapa');
    $.ajax({
        type: 'GET',
        dataType:'JSON',
        data:{dominio},
        url:'TestControllerMapa/obtenerCamion',
        success: function(rsp) {

            console.log(rsp.lat);
            var point = L.point(rsp.lat,rsp.lng);
            map.setZoomAround(point,30,true);

            L.marker([rsp.lat,rsp.lng]).addTo(map)
                .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                .openPopup();


        },
        error: function() {
        },
        complete: function() {
            wbox();
        }
    });

});


</script>