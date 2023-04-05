let map = L.map('map').setView([5.694, 12.742], 7);

let longitudeInput = document.getElementById("longitude");
let latitudeInput = document.getElementById("latitude");
let department = document.getElementById("department");

let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

let geocoder = L.Control.geocoder({
    defaultMarkGeocode: false
}).on('markgeocode', function(e) {
        map.setView([e.geocode.center.lat, e.geocode.center.lng ], 10);
    }).addTo(map);

if (!navigator.geolocation) {
    console.log("Your browser doesn't support geolocation feature!");
} else {
    navigator.geolocation.getCurrentPosition((position) => {
        map.setView([position.coords.latitude, position.coords.longitude], 10);
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

let markers = [];

let geoJson = L.geoJson(null, {
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