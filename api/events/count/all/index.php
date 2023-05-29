<?php

    include("../../../../config/db.php");
    if(!empty($db)){

        $req = "SELECT  D.id, D.name, COUNT(E.id) as 'nbr_events' FROM `departement` D LEFT JOIN `event` E on E.departement_id = D.id GROUP BY D.id;";
        $st = $db->prepare($req);
        if($st->execute()){
            header("Content-Type: application/json");
            echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        }
    }

?>