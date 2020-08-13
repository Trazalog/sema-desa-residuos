<div id="mapid" style="height: 340px">
</div>
<script>
///////////////////INICIALIZA EL MAPA////////////////////////
var map = L.map('mapid').setView([-31.5315272,-68.5527981], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
///////////////////CARGA UN PUNTO////////////////////////
function setPunto(latitud,longitud,html)
{
    //AGREGA PUNTO AL MAPA
    var marker = L.marker([latitud,longitud]).addTo(map);

    //AGREGA EVENTO MOUSE OVER AL PUNTO
    marker.bindPopup(html);
    marker.on('mouseover', function (e) {
        this.openPopup();
    });
    marker.on('mouseout', function (e) {
        this.closePopup();
    });

    //AGREGA EVENTO DE CLICK AL PUNTO
    marker.on('click',function(e){
        this.openPopup();
        $('#desplegable').toggle();
        $('#iconoDesplegable').remove();
    });
}
////////////////////////////////////////////////////////
function zoom(latitud,longitud)
{
    map.setZoomAround([latitud,longitud],30,true);
}
///////////////////DESPLIEGA CARTEL DEL CAMION////////////////////////
function desplegar()
{
    $('#desplegable').toggle();
    $('#iconoDesplegable').remove();
}
/////////////////////////////////////////////////////////
</script>