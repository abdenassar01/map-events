let map = L.map('map').setView([5.694, 12.742], 7);

let longitudeInput = document.getElementById("longitude");
let latitudeInput = document.getElementById("latitude");
let department = document.getElementById("department");

let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

if (!navigator.geolocation) {
    console.log("Your browser doesn't support geolocation feature!");
} else {
    navigator.geolocation.getCurrentPosition((position) => {
        const currentLocation = L.marker([position.coords.latitude, position.coords.longitude])
                                    .addTo(map);
        longitudeInput.value = position.coords.longitude;
        latitudeInput.value = position.coords.latitude;
        markers.push(currentLocation);
    })
}

fetch("../../frontend/assets/data.json")
    .then(data => data.json())
    .then(res => {
        res.features.map(feature => {
            fetch("../../api/events/count/index.php?departement=" + feature.properties.name)
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
let markers = [];

let geoJson = L.geoJson(null, {
    style: style,
    onEachFeature: function(feature,layer){
        layer.on('click', function(evt) {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            let position = L.marker(evt.latlng, {
                title: feature.properties.name
            }).addTo(map);
            fetch("../../api/department/?name=" + feature.properties.name)
                .then(res => res.json())
                .then(data => {
                    department.value = data.id;
                })
            longitudeInput.value = evt.latlng.lng;
            latitudeInput.value = evt.latlng.lat;
            markers.push(position);
        });
    },
}).addTo(map);


map.on('click', function(e) {

    markers.forEach(marker => map.removeLayer(marker));

    let position = L.marker(e.latlng).addTo(map);
    markers.push(position);
});

document
    .querySelectorAll('[data-tiny-editor]')
    .forEach(editor =>
        editor.addEventListener('input', e => {
                let description = document.getElementById("description")
                description.value = e.target.innerHTML;
            }
        )
    );