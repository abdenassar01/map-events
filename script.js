// import { CAMEROUN_DEPARTEMEMT } from "./data";

let map = L.map('map').setView([37.8, -96], 4);

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

let states = [{
    "type": "Feature",
    "properties": {
        "nbrEvents": 10,
        "events": []
    },
    "geometry": {
        "type": "Polygon",
        "coordinates": [[
            [-104.05, 48.99],
            [-97.22,  48.98],
            [-96.58,  45.94],
            [-104.03, 45.94],
            [-104.05, 48.99]
        ]]
    }
}, {
    "type": "Feature",
    "properties": {
        "nbrEvents": 5,
        "events": [
            [39.02416845410678, -105.57041564629472],
            [38.14259283857374, -106.77781996978813]
        ]
    },
    "geometry": {
        "type": "Polygon",
        "coordinates": [[
            [-109.05, 41.00],
            [-102.06, 40.99],
            [-102.03, 36.99],
            [-109.04, 36.99],
            [-109.05, 41.00]
        ]]
    }
}];

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

let geoJson = L.geoJson(states, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

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

    map.fitBounds(e.target.getBounds());
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
    });
}