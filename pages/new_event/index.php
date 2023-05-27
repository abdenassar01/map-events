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
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map{
            border-radius: 10px;
            height: 20px;
            width: 100%;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<?php
    session_start();
    include_once("../../config/db.php");
    if(!isset($_SESSION['login'])){
        header("Location: ../login");
    }

    $event = [];

    if(isset($_GET['id']) && !empty($db)){
        $req = "select * from event where id = :id;";
        $st = $db->prepare($req);
        $st->bindParam(":id", $_GET['id']);
        if($st->execute()){
            $event = $st->fetchAll(PDO::FETCH_ASSOC)[0];
        }
    }
?>
<body>
    <div class="container content-center mt-5" >
        <p>Chose event location: </p>
        <div id="map" ></div>
        <br />
        <form class="row g-2" method="post" enctype="multipart/form-data" action="../../api/handler/add_event.php">
            <?php
                if(isset($_GET['id'])){
                    echo "<input type='hidden' name='id' value='".$_GET['id']."' />";
                }
            ?>
            <div class="col-md-6">
                <label class="form-label" for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?=isset($event['title']) ? $event['title'] : '' ?>" required />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="type">Type:</label>
                <select class="form-select" name="type" aria-label="event type" required>
                    <option value="liberation"<?=(isset($event['type']) && $event['type'] === 'liberation') ? 'selected' : '' ?>>Événement Historique</option>
                    <option value="compagne"<?=(isset($event['type']) && $event['type'] === 'compagne') ? 'selected' : '' ?>>Événement Compagne</option>
                    <option value="culture"<?=(isset($event['type']) && $event['type'] === 'culture') ? 'selected' : '' ?>>Événement Culturels</option>
                    <option value="traditionnel"<?=(isset($event['type']) && $event['type'] === 'traditionnel') ? 'selected' : '' ?>>Autres Traditionnel </option>
                    <option value="autre"<?=(isset($event['type']) && $event['type'] === 'autre') ? 'selected' : '' ?>>Autres Événement </option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required value="<?php
                    if (isset($event['start_time'])) {
                        $phpdate = strtotime( $event['start_time']);
                        echo date( 'Y-m-d', $phpdate );
                    }
                ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required value="<?php
                    if (isset($event['end_time'])) {
                        $phpdate = strtotime( $event['end_time']);
                        echo date( 'Y-m-d', $phpdate );
                    }
                ?>" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="poster">Poster:</label>
                <input type="file" accept="image/png, image/jpeg" id="poster" name="poster" class="form-control"  />
                <?php
                    if (isset($event['image'])){
                        echo "<img class='event-image' src='../../api/image/".$event['image']."' />";
                    }
                ?>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="teaser">Teaser:</label>
                <input type="file" accept="video/mp4, video/mkv" id="teaser" name="teaser" class="form-control"  />
                <?php
                    if (isset($event['video'])){
                        echo "<video class='event-video' src='../../api/video/".$event['video']."' controls/>";
                    }
                ?>
            </div>
            <div class="form-outline mb-4 mt-5">
                <label class="form-label" for="description">Description:</label>
                <div data-tiny-editor data-bold="no">
                    <?= isset($event['description']) ? $event['description'] : '' ?>
                </div>
            </div>
            <input type="hidden" name="longitude" id="longitude" value="<?=isset($event['lng']) ? $event['lng'] : '' ?>" />
            <input type="hidden" name="latitude" id="latitude" value="<?=isset($event['lat']) ? $event['lat'] : '' ?>" />
            <input type="hidden" name="department" id="department" value="<?=isset($event['departement_id']) ? $event['departement_id'] : '' ?>" />
            <input type="hidden" name="description" id="description" value="<?=isset($event['description']) ? $event['description'] : '' ?>" />
            <input type="submit" name="submit" class="btn btn-primary btn-block mb-4 m-2" value="<?=isset($_GET['id']) ? "update" : "add"?> event">
        </form>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>
    <script src="index.js"></script>
</body>
</html>
