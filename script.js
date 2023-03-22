let map = L.map('map').setView([5.694, 12.742], 7);

let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function getColor(d) {
    return d > 10 ? '#800026' :
        d > 5  ? '#BD0026' :
            d > 2  ? '#E31A1C' :
                d > 1  ? '#FC4E2A' :
                    d > 5   ? '#FD8D3C' :
                        d > 2   ? '#FEB24C' :
                            d > 1   ? '#FED976' :
                                '#FFEDA0';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.nbrEvents),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}

let geoJson = L.geoJson(null, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

fetch("./data.json")
    .then(data => data.json())
    .then(res => geoJson.addData(res))

function highlightFeature(e) {
    let layer = e.target;

    layer.setStyle({
        weight: 2,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
    });

    layer.bringToFront();
}

function resetHighlight(e) {
    geoJson.resetStyle(e.target);
}

function zoomToFeature(e) {

    //TODO: fetch data and create markers
    console.log(e.target)
    map.fitBounds(e.target.getBounds());
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
    });
}