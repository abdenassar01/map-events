<?php

    $teaser = "";
    if($_FILES["teaser"]){
        $teaser_filename = $_FILES["teaser"]["name"];
        $teaser_tempname = $_FILES["teaser"]["tmp_name"];
        $teaser_folder = "../video/" . $teaser_filename;

        $isSuccess = move_uploaded_file($teaser_tempname, $teaser_folder);
        if ($isSuccess){
            $teaser = $teaser_filename;
        }
    }

    echo json_encode(array("ok" => $isSuccess, "teaser" => $teaser, "file" => $_FILES))
?>