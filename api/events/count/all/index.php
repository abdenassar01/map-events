<?php

    include("../../../../config/db.php");
    if(!empty($db)){

        $req = "select departement_id as 'departement', count(id) as 'nbr_events' from event where status = 'approved' group by departement_id;";
        $st = $db->prepare($req);
        if($st->execute()){
            echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
        }
    }

?>