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
                            <option selected disabled>-Seleccionar camión-</option>
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
///////////////////INICIALIZA EL MAPA////////////////////////
var map = L.map('mapid').setView([-31.5315272,-68.5527981], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
/////////////////////////////////////////////////////////////
var latlngs = [
    [[45.51, -122.68],
     [37.77, -122.43],
     [34.04, -118.2]],
    [[40.78, -73.91],
     [41.83, -87.62],
     [32.76, -96.72]]
];
var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
map.fitBounds(polyline.getBounds());
</script>