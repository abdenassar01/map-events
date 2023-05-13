let map = L.map('map').setView([5.694, 12.742], 7);

let longitudeInput = document.getElementById("longitude");
let latitudeInput = document.getElementById("latitude");
let department = document.getElementById("department");
let markers = [];

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

document.addEventListener('DOMContentLoaded', () => {
    if((longitudeInput.value !== "") && (latitudeInput.value !== "")){
        map.setView([latitudeInput.value, longitudeInput.value], 10);
        let marker = L.marker([latitudeInput.value, longitudeInput.value]).addTo(map);
        markers.push(marker);
    }
})

const teaser = document.getElementById('teaser')

teaser.addEventListener('change', (event) => {
    const target = event.target
    if (target.files && target.files[0]) {
        const maxAllowedSize = 5 * 1024 * 1024;
        if (target.files[0].size > maxAllowedSize) {
            alert('video is bigger than allowed size. make sure to upload a video smaller than 5Mo');
            target.value = ''
        }
    }
})

const poster = document.querySelector('#poster');

function loadData(selector, tag) {
    return (e) => {
        const preview = document.querySelector(selector);
        const file = tag.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", () => {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    };
}

poster.addEventListener('change', loadData('.event-image', poster), false)

teaser.addEventListener('change', loadData('.event-video', teaser), false)

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