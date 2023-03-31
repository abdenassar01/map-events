<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>add event</title>
    <link rel="icon" href="../../frontend/assets/icons/logo.ico">
    <link rel="stylesheet" href="../../frontend/assets/styles/styles.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
          crossorigin=""/>

    <style>
        #map{
            height: 200px;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
    <?php
        include "../../components/header.php";
    ?>
    <div id="map" ></div>
    <div class="container content-center mt-5" >
        <form class="row g-2" onsubmit="validate(e)">

            <div class="col-md-6">
                <label class="form-label" for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="type">Type:</label>
                <select class="form-select" aria-label="event type">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="poster">Poster:</label>
                <input type="file" id="poster" name="poster" class="form-control" />
            </div>
            <div class="form-outline mb-4 mt-5">
                <label class="form-label" for="description">Description:</label>
                <div data-tiny-editor data-bold="no"></div>
            </div>

            <input type="submit" name="signin" class="btn btn-primary btn-block mb-4 m-2" value="add event">
        </form>
    </div>
    <?php

    ?>
    <script>
        let map = L.map('map').setView([5.694, 12.742], 7);

        let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        document
            .querySelectorAll('[data-tiny-editor]')
            .forEach(editor =>
                editor.addEventListener('input', e => console.log(e.target.innerHTML)
                )
            );
    </script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>

</body>
</html>
