<?php

    include("../../../config/db.php");
    if(!empty($db)){
        if(isset($_GET['department'])){

            $req = "select count(E.id) as 'nbr_events' from event E inner join department D on E.departement_id = D.id where D.name = :department;";
            $st = $db->prepare($req);
            $st->bindParam(":department", $_GET['department']);
            if($st->execute()){
                echo json_encode($st->fetchAll(PDO::FETCH_ASSOC)[0]);
            }
        }else{
            $req = "select count(E.id) as 'nbr_events' from event E inner join department D on E.departement_id = D.id;";
            $st = $db->prepare($req);
            if($st->execute()){
                echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
            }
        }
    }

    ?>