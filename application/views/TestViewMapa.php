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
///////////////////CARGA MAPA CON CAMIONES////////////////////////
wo();
$.ajax({
    type: 'GET',
    dataType:'JSON',
    url:'TestControllerMapa/obtenerUbicaciones',
    success: function(rsp) {
        for(var i=0;i<rsp.length;i++)
        {
            L.marker([rsp[i].lat,rsp[i].lng]).addTo(map)
                .bindPopup("<h4 style='text-align:center'>"+rsp[i].dominio+"</h4>Chofer: "+rsp[i].nombre_chofer+"<br><div id='desplegable' hidden>DNI: "+rsp[i].dni_chofer+"<br>Transportista: "+rsp[i].transportista+"<br>Cuit: "+rsp[i].cuit+"<br>Fecha: "+rsp[i].fecha+"<br>Estado de OT: "+rsp[i].ortr_estado+"<br>Id OT: "+rsp[i].ortr_id+"</div><div onclick='desplegar()' style='text-align:center;padding-top:5px;color:blue'><i class='fa fa-chevron-down' id='iconoDesplegable'></i></div>")
                .addTo(map);
        }
    },
    error: function() {
    },
    complete: function() {
        wc();
    }
});
//////////////////////////////////////////////////////////
///////////////////DESPLIEGA CARTEL DEL CAMION////////////////////////
function desplegar()
{
    $('#desplegable').toggle();
    $('#iconoDesplegable').remove();
}
/////////////////////////////////////////////////////////
///////////////////MUESTRA EN EL MAPA UN CAMION////////////////////////
$('#cami_id').on('change',function(){

    var dominio = this.value;
    wo();
    $.ajax({
        type: 'GET',
        dataType:'JSON',
        data:{dominio},
        url:'TestControllerMapa/obtenerUbicacion',
        success: function(rsp) {
            console.log(rsp);
            L.marker([rsp.lat,rsp.lng]).addTo(map)
                .bindPopup("<h4 style='text-align:center'>"+rsp.dominio+"</h4>Chofer: "+rsp.nombre_chofer+"<br><div id='desplegable' hidden>DNI: "+rsp.dni_chofer+"<br>Transportista: "+rsp.transportista+"<br>Cuit: "+rsp.cuit+"<br>Fecha: "+rsp.fecha+"<br>Estado de OT: "+rsp.ortr_estado+"<br>Id OT: "+rsp.ortr_id+"</div><div onclick='desplegar()' style='text-align:center;padding-top:5px;color:blue'><i class='fa fa-chevron-down' id='iconoDesplegable'></i></div>").openPopup();

            map.setZoomAround([rsp.lat,rsp.lng],30,true);
        },
        error: function() {
        },
        complete: function() {
            wc();
        }
    });

});
////////////////////////////////////////////////////////
</script>