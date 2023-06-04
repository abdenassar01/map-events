<?php

    include("../../../config/db.php");
    try {
        if(!empty($db)){
            if(isset($_GET['departement'])){
                $req = "select count(E.id) as 'nbr_events' from event E inner join departement D on E.departement_id = D.id where D.name = :department and E.status = 'approved';";
                $st = $db->prepare($req);
                $st->bindParam(":department", $_GET['departement']);
                if($st->execute()){
                    header("Content-Type: application/json");
                    echo json_encode($st->fetchAll(PDO::FETCH_ASSOC)[0]);
                }
            }else{
                $req = "select count(*) as 'nbr_events' from event where status = 'approved';";
                $st = $db->prepare($req);
                if($st->execute()){
                    header("Content-Type: application/json");
                    echo json_encode($st->fetchAll(PDO::FETCH_ASSOC)[0]);
                }
            }
        }
    }catch (Exception $ex){
        print_r($ex);
    }


    ?>
