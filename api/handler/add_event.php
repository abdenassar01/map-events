<?php
    session_start();
    $poster = "";
    $user = $_SESSION['user_id'];

    if($_FILES["poster"]){
        $filename = $_FILES["poster"]["name"];
        $tempname = $_FILES["poster"]["tmp_name"];
        $folder = "../image/" . $filename;

        if (move_uploaded_file($tempname, $folder)){
            $poster = $filename;
        }
    }

    $sql = "INSERT INTO `event` (`departement_id`, `title`, `description`, `type`, `image`, `lng`, `lat`, `user_id`, `start_time`, `end_time`) VALUES ( :department, :title, :description, :type, :poster, :lng, :lat, :user, :start_date, :end_date);";

    include("../../config/db.php");
    if(!empty($db)){
        $st = $db->prepare($sql);
        if ($st->execute(array(
            ":department" => $_POST['department'],
            ":description" => $_POST['description'],
            ":title" => $_POST['title'],
            ":type" => $_POST['type'],
            ":poster" => $poster,
            ":lng" => $_POST['longitude'],
            ":lat" => $_POST['latitude'],
            ":user" => $user,
            ":start_date" => $_POST['start_date'],
            ":end_date" => $_POST['end_date']
        ))) {
            header("Location: ../../");
        }
    }

?>