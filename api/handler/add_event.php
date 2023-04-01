<?php
    echo "Longitude: ".$_POST['longitude'];
    echo ", Latitude: ".$_POST['latitude'];
    echo ", Description: ".$_POST['description'];
    echo ", department: ".$_POST['department'];
    echo ", Title: ".$_POST['title'];
    echo ", Type: ".$_POST['type'];
    echo ", Start Date: ".$_POST['start_date'];
    echo ", End Date: ".$_POST['end_date'];
    echo ", Poster: ";

    $poster = "";

    if($_FILES["poster"]){
        $filename = $_FILES["poster"]["name"];
        $tempname = $_FILES["poster"]["tmp_name"];
        $folder = "../image/" . $filename;

        if (move_uploaded_file($tempname, $folder)){
            $poster = $filename;
        }
    }

?>