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

    $sql = "";

    if(isset($_POST['id'])){
        $sql = "UPDATE `event` SET `departement_id` = :department, `title` = :title, `description` = :description, `type` = :type, `image` = :poster, `video` = :teaser ,`lng` = :lng, `lat` = :lat, `user_id` = :user, `start_time` = :start_date, `end_time` = :end_date WHERE id = :id;";
    }else{
        $sql = "INSERT INTO `event` (`departement_id`, `title`, `description`, `type`, `image`, `video`, `lng`, `lat`, `user_id`, `start_time`, `end_time`, `date_created`) VALUES (:department, :title, :description, :type, :poster, :teaser, :lng, :lat, :user, :start_date, :end_date, CURDATE());";
    }

    include("../../config/db.php");
    try {
        if(!empty($db)){
            $st = $db->prepare($sql);
            $st->bindParam(":department", $_POST['department']);
            $st->bindParam(":description", $_POST['description']);
            $st->bindParam(":title", $_POST['title']);
            $st->bindParam(":type", $_POST['type']);
            $st->bindParam(":poster", $poster);
            $st->bindParam(":teaser", $_POST['teaser-input']);
            $st->bindParam(":lng", $_POST['longitude']);
            $st->bindParam(":lat", $_POST['latitude']);
            $st->bindParam(":user", $user);
            $st->bindParam(":start_date", $_POST['start_date']);
            $st->bindParam(":end_date", $_POST['end_date']);

            if (isset($_POST['id'])){
                $st->bindParam(":id", $_POST['id']);
            }

            if ($st->execute()) {
                header("Location: ../../");
            }
        }
    }catch (Exception $ex){
        print_r($ex);
    }
?>