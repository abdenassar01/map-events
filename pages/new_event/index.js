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

teaser.addEventListener('change', uploadFileHandler, false)
// teaser.addEventListener('change', loadData('.event-video', teaser), false)

function uploadFileHandler() {
    document.getElementById('progressDiv').style.display='block';
    const file = document.getElementById("teaser").files[0];
    const formdata = new FormData();
    formdata.append("teaser", file);
    const ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "../../api/handler/upload_video.php");
    ajax.send(formdata);
}
function progressHandler(event) {
    document.getElementById("progress-wrapper").style.display = "block"
    let loaded = new Number((event.loaded / 1048576));//Make loaded a "number" and divide bytes to get Megabytes
    let total = new Number((event.total / 1048576));//Make total file size a "number" and divide bytes to get Megabytes
    document.getElementById("uploaded_progress").innerHTML = "Uploaded " + loaded.toPrecision(5) + " Megabytes of " + total.toPrecision(5);//String output
    let percent = (event.loaded / event.total) * 100;//Get percentage of upload progress
    document.getElementById("progressBar").value = Math.round(percent);//Round value to solid
    document.getElementById("status").innerHTML = Math.round(percent) + "% uploaded";//String output
}
function completeHandler(event) {
    const data = JSON.parse(event.target.responseText)
    const videoInput = document.getElementById("teaser-input")
    videoInput.value = data?.file?.teaser?.name
    document.getElementById("teaser").value = ""
    // console.log(data.file.teaser.name);
    document.getElementById("progressBar").value = 0;//Set progress bar to 0
    document.getElementById('progressDiv').style.display = 'none';//Hide progress bar
}
function errorHandler(event) {
    document.getElementById("status").innerHTML = "Upload Failed";//Switch status to upload failed
}
function abortHandler(event) {
    document.getElementById("status").innerHTML = "Upload Aborted";//Switch status to aborted
}

fetch("../../api/events/count/all")
    .then(res => res.json())
    .then(data => {
            let departments = [];
            data.map(item => {
                departments.push({
                    name: item.name,
                    nbr_events: item.nbr_events
                })
            })
            return departments;
        }
    ).then(
    departments =>
        fetch("../../frontend/assets/data.json")
            .then(data => data.json())
            .then(res => {
                res?.features.map(
                    feature => {
                        departments.map(department => {
                            if(department.name === feature.properties.name){
                                geoJson.addData({
                                    ...feature,
                                    properties: {
                                        ...feature.properties,
                                        nb_events: department.nbr_events,
                                    }
                                })
                            }
                        })
                    });
                fetch("../../api/events/latest/")
                    .then(res => res.json())
                    .then(events => {
                        events.map(event => {
                            if (event.status === "approved"){
                                const dateParts = event.end_time.split("-");
                                const endTime = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
                                const marker = L.marker([event.lat, event.lng], {
                                    icon: L.icon({
                                        iconUrl: `https://i.imgur.com/${event.type === "liberation" ? "pr1H9uO" : event.type === "compagne" ? "dS4Ens6" : event.type === "culture" ? "F0wThWc" : event.type === "autre" ? "Gn04lg5" : "ZbBIlQB" }.png`,
                                        iconSize: [36, 36],
                                        iconAnchor: [12, 36],
                                        popupAnchor: [5, 0],
                                    })
                                }).addTo(map)
                                    .bindPopup("<div class='event-card'><p class='title'>" + event.title + `</p><br><div class='card-footer'><div class='date'>Ends in: ${ endTime.toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }</div><a style='color: white' class='event-details-btn' href='./pages/event_details/?id=${ event.id }'>see details</a></div></div>`);

                                markers.push(marker)
                            }
                        })
                    })
            })
            .catch(err => console.log(err))
)
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

function validateAddingEvent() {
    const langitude = document.getElementById('longitude');
    const latitude = document.getElementById('latitude');


    if ((langitude.value === "" || langitude.value === null) || (latitude.value === "" || latitude.value === null)) {
        alert("You have to select the location first");
        return false;
    }
}

document
    .querySelectorAll('[data-tiny-editor]')
    .forEach(editor =>
        editor.addEventListener('input', e => {
                let description = document.getElementById("description")
                description.value = e.target.innerHTML;
            }
        )
    );