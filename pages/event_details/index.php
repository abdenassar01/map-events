<?php
include ("../../config/db.php");
if(isset($_GET['id']) && !empty($db)){
    $req = "select E.title, E.description, E.type, E.image, E.lng, E.lat, E.start_time, E.end_time, D.name as 'department', CONCAT(U.name , ' ' , U.lastname)  as 'usert' from event E inner join departement D on D.id = E.departement_id inner join user U on U.id = E.user_id where E.id = :id;";
    $st = $db->prepare($req);
    $st->bindParam(":id", $_GET['id']);
    $event = [];
    if($st->execute()){
        $event = $st->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    print_r($event);
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
</head>
<body>
<div class="container">
<!--    TODO: action populaire details page -->
</div>
</body>
</html>
