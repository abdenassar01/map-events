<?php

    include("../config/db.php");

    if(isset($_GET['departement']) && !empty($db)){
        $req = "select E.*, D.name from event E inner join departement D on E.departement_id = D.id where D.name = :departement;";
        $st = $db->prepare($req);
        $st->bindParam(":departement", $_GET['departement']);
        if($st->execute()){
            echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        }
    }else if(isset($_GET['id']) && !empty($db)){
        $req = "select * from event where id = :id;";
        $st = $db->prepare($req);
        $st->bindParam(":id", $_GET['id']);
        if($st->execute()){
            echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        }
    }




?>