let map = L.map('map').setView([5.694, 12.742], 7);

let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function getColor(d) {
    return d > 500 ? '#800026' :
        d > 100  ? '#BD0026' :
            d > 50  ? '#E31A1C' :
                d > 20  ? '#FC4E2A' :
                    d > 10   ? '#FD8D3C' :
                        d > 5   ? '#FEB24C' :
                            d > 0   ? '#FED976' :
                                '#FFEDA0';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.nb_events),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    }
}

let geoJson = L.geoJson(null, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

fetch("frontend/assets/data.json")
    .then(data => data.json())
    .then(res => {
        res.features.map(feature => {
           fetch("api/events/count/index.php?departement=" + feature.properties.name)
               .then(res => res.json())
               .then(data => {
                   geoJson.addData({
                       ...feature,
                       properties: {
                           ...feature.properties,
                           nb_events: data.nbr_events,
                       }
                   })
               })
        })
    })
    .catch(err => console.log(err))

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
    fetch("api/events/?departement=" + e.target.feature.properties.name)
        .then(res => res.json())
        .then(events => {
            events.map(event => {
                L.marker([event.lng, event.lat]).addTo(map)
                    .bindPopup("<b><center>" + event.title + "</center></b><br>" + event.description)
            })
        })
        .catch(err => console.log(err))
    map.fitBounds(e.target.getBounds());
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
    });
}

