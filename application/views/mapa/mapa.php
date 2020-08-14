<div id="mapid" style="height: 340px">
</div>
<script>
///////////////////INICIALIZA EL MAPA////////////////////////
var map = L.map('mapid').setView([-31.5315272,-68.5527981], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
////////////////CARGA UN MARCADOR EN EL MAPA/////////////////////
/*NECESITA DE LA LATITUD,LONGITUD,Y EL CARTEL*/
function setMarcador(latitud,longitud,html)
{
    //AGREGA PUNTO AL MAPA
    var marker = L.marker([latitud,longitud]).addTo(map);
    //-----------------------------//
    //AGREGA EVENTO MOUSE OVER AL PUNTO
    marker.bindPopup(html);
    marker.on('mouseover', function (e) {
        this.openPopup();
    });
    //-----------------------------//
    //AGREGA EVENTO DE CLICK AL PUNTO
    marker.on('click',function(e){
        this.openPopup();
        $('#desplegable').toggle();
        $('#iconoDesplegable').remove();
    });
    //-----------------------------//
}
///////////////////////ZOOM/////////////////////////////
/*NECESITA LATITUD Y LONGITUD*/
function zoom(latitud,longitud)
{
    map.setZoomAround([latitud,longitud],30,true);
}
////////////////COLOCA UN PUNTO EN EL MAPA/////////////////////
/*NECESITA LATITUD Y LONGITUD*/
function setPunto()
{
    $('#desplegable').toggle();
    $('#iconoDesplegable').remove();
}
///////////////////TRAZAR CAMINO//////////////////////////////
/*NECESITA UN ARREGLO DE PUNTOS*/
function trazarCamino(latlngs)
{
    console.log(latlngs);
    var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
    map.fitBounds(polyline.getBounds());
}

</script>