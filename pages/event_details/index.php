<?php
include ("../../config/db.php");
$event = [];
if(isset($_GET['id']) && !empty($db)){
    $req = "select E.title, E.description, E.video, E.user_id, E.type, E.image, E.lng, E.lat, E.start_time, E.end_time, D.name as 'department', CONCAT(U.name , ' ' , U.lastname)  as 'user' from event E inner join departement D on D.id = E.departement_id inner join user U on U.id = E.user_id where E.id = :id;";
    $st = $db->prepare($req);
    $st->bindParam(":id", $_GET['id']);
    if($st->execute()){
        $event = $st->fetchAll(PDO::FETCH_ASSOC)[0];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$event['title']?></title>
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="../../frontend/assets/icons/logo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
          crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<main class="container">
    <?php if (count($event)>0){ ?>
    <div class="header">
        <a href="../../" class="back-btn">
            <i class="fa fa-2x fa-chevron-circle-left back" aria-hidden="true"></i>
        </a>
        <h3 class="title">
            <?=$event['title']?>
        </h3>
    </div>
    <div class="content">
        <section class="details border">
            <p class="event-date">
                <?php

                    $start_time = date( 'F j, Y', strtotime( $event['start_time']) );
                    $end_time = date( 'F j, Y', strtotime( $event['end_time'] ) );
                ?>
                Starting from <?=$start_time?> to <?=$end_time?>
            </p>
            <p class="event-type">
                <b>Type: </b>
                <?php
                    switch ($event['type']){
                        case 'culture':
                            echo "Événement culturels actuels";break;
                        case 'liberation':
                            echo "Événement historique lies à la lutte de libération nationale";break;
                        case 'compagne':
                            echo "Événement lies à notre compagne politique actuelle";break;
                        default :
                            echo "Événement des autres acteurs société civile";break;
                    }
                ?>
            </p>
        </section>
        <div class="flex-wrapper">
            <section class="left border">
                <h3>The Event</h3>
                <img src="../../api/image/<?=$event['image']?>" alt="" class="poster" />
                <?php
                    if($event['video']){
                        ?>
                            <video src="../../api/video/<?=$event['video']?>" class="teaser" controls></video>
                        <?php
                    }
                ?>
                <div class="description">
                    <?=$event['description']?>
                </div>
            </section>
            <section class="right">
                <div class="border">
                    <div id="map"></div>
                </div>
                <div class="author border">
                    this event was created by <a href="profile" class="author"><?=$event['user']?></a>
                </div>
            </section>
        </div>
        <input type="hidden" id="lng" value="<?=$event['lng']?>">
        <input type="hidden" id="lat" value="<?=$event['lat']?>">
        <input type="hidden" id="type" value="<?=$event['type']?>">
    </div>
    <?php } else {
        ?>
        <div class="alert">
            There is no event with specified id: <?=$_GET['id']?>
        </div>
    <?php } ?>
</main>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
        crossorigin=""></script>
<script>
    const map = L.map('map').setView([5.694, 12.742], 5);

    const lat = document.getElementById("lat").value;
    const lng = document.getElementById("lng").value;
    const type = document.getElementById("type").value;

     L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    L.marker([lat, lng], {
        icon: L.icon({
            iconUrl: `https://i.imgur.com/${type === "liberation" ? "pr1H9uO" : type === "compagne" ? "dS4Ens6" : type === "culture" ? "Gn04lg5" : "ZbBIlQB" }.png`,
            iconSize: [35, 35],
            iconAnchor: [22, 94],
            popupAnchor: [-3, -76],
        })
    }).addTo(map)
</script>
</body>
</html>
