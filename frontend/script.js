let map = L.map('map').setView([5.694, 12.742], 7);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

let markers = [];
grades = [];

function getColor(d) {
    return d > grades[6] ? '#800026' :
        d > grades[5]  ? '#BD0026' :
            d > grades[4]  ? '#E31A1C' :
                d > grades[3]  ? '#FC4E2A' :
                    d > grades[2]   ? '#FD8D3C' :
                        d > grades[1]   ? '#FEB24C' :
                            d > grades[0]   ? '#FED976' :
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
        });
        fetch("api/events/latest/")
            .then(res => res.json())
            .then(events => {
                events.map(event => {
                    if (event.status === "approved"){
                        const dateParts = event.end_time.split("-");
                        const endTime = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
                        const marker = L.marker([event.lat, event.lng], {
                            icon: L.icon({
                                iconUrl: `https://i.imgur.com/${event.type === "liberation" ? "pr1H9uO" : event.type === "compagne" ? "dS4Ens6" : event.type === "culture" ? "Gn04lg5" : "ZbBIlQB" }.png`,
                                iconSize: [36, 36],
                                iconAnchor: [12, 36],
                                popupAnchor: [-3, -76],
                            })
                        }).addTo(map)
                            .bindPopup("<div class='event-card'><p class='title'>" + event.title + `</p><br><div class='card-footer'><div class='date'>Ends in: ${ endTime.toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }</div><a style='color: white' class='event-details-btn' href='./pages/event_details/?id=${ event.id }'>see details</a></div></div>`);

                        markers.push(marker)
                    }
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
                            iconSize: [36, 36],
                            iconAnchor: [12, 36],
                            popupAnchor: [-3, -76],
                        })
                    }).addTo(map)
                        .bindPopup("<div class='event-card'><p class='title'>" + event.title + `</p><br><div class='card-footer'><div class='date'>Ends in: ${ endTime.toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }</div><a style='color: white' class='event-details-btn' href='./pages/event_details/?id=${ event.id }'>see details</a></div></div>`);

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

document.addEventListener("DOMContentLoaded", () => {
    fetch("api/events/count/all/")
        .then(res => res.json())
        .then(eventsCounts => {
            const key = document.querySelector('.key');
            let html = "";

            let min = 0;
            let max = 0;
            let diff = 0;
            eventsCounts.map(item => {
                if (item.nbr_events <= min){
                    min = item.nbr_events;
                }
                if (item.nbr_events >= max){
                    max = item.nbr_events;
                }
            })
            diff = Math.ceil(max / 7);
            for (let i = 0; i < 7; i++) {
                if (i === 0 ) {
                    grades[i] = min;
                }else if ( i === grades.length - 1 ){
                    grades[grades.length - 1] = max;
                }else {
                    grades[i] = grades[i - 1] + diff;
                }
                html +=  `<div class='key-item'><div class='square' style='background-color: ${getColor(grades[i])}'></div>${ grades[ i ] + (i === 6 ? " + " : " &ndash; " + (grades[i] + diff)) }</div>`;
            }
            key.innerHTML = html;
    })
})