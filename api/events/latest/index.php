<?php

include("../../../config/db.php");

if(!empty($db)){
    $req = "SELECT * FROM event ORDER BY date_created LIMIT 20;";
    $st = $db->prepare($req);
    if($st->execute()){
        echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>