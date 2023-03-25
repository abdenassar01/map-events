<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Map</title>
    <link rel="stylesheet" href="./frontend/assets/styles/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
</head>
<body>
    <div class="container">
        <?php
            include('./components/header.php')
        ?>
        <div id="map"></div>
    </div>
</body>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="frontend/script.js"></script>
</html>
