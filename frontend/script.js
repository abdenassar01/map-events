let map = L.map('map').setView([5.694, 12.742], 7);

let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

let markers = [];

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

    markers.forEach(marker => map.removeLayer(marker));

    fetch("api/events/?departement=" + e.target.feature.properties.name)
        .then(res => res.json())
        .then(events => {
            events.map(event => {
                if (event.status === "approved"){
                    const dateParts = event.end_time.split("-");
                    const endTime = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
                    const marker = L.marker([event.lat, event.lng], {
                        icon: L.icon({
                            iconUrl: `https://i.imgur.com/${event.type === "liberation" ? "pr1H9uO" : event.type === "compagne" ? "dS4Ens6" : event.type === "culture" ? "Gn04lg5" : "ZbBIlQB" }.png`,
                            iconSize: [35, 35],
                            iconAnchor: [22, 94],
                            popupAnchor: [-3, -76],
                        })
                    }).addTo(map)
                        .bindPopup("<div style='position: relative; width: 400px; padding-bottom: 50px; '><b class='title'>" + event.title + `</b><br><div class='date'>Ends in: ${ endTime.toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }</div><div style='padding: 10px'>${ event.description }</div><a class='btn btn-dark' style='position: absolute; bottom: 10px; right: 10px; color: white' href='./pages/event_details/?id=${ event.id }'>see details</a></div>`);

                    markers.push(marker)
                }
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

let legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {

    let div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 10, 20, 50, 100, 200, 500, 1000];

    let items = "";
    for (let i = 0; i < grades.length; i++) {
        items +=
            '<div><i class="fa-solid fa-square" style="width: 35px; height: 35px; background:' + getColor(grades[i] + 1) + '"></i> ' +
            grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '</div>' : '+');
    }

    div.innerHTML = "<div style='display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 5px; border-radius: 5px; background-color: white; min-height: 150px; min-width: 100px'><div>" + items + "</div></div>"

    return div;
};

legend.addTo(map);