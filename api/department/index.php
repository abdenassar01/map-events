<?php

    include("../../config/db.php");
    if(!empty($db)){
        if(isset($_GET['name'])) {
            $req = "select * from departement where name = :name;";
            $st = $db->prepare($req);
            $st->bindParam(":name", $_GET['name']);
            try {
                if ($st->execute()) {
                    echo json_encode($st->fetchAll(PDO::FETCH_ASSOC)[0]);
                }
            }catch (Exception $ex){
               print_r($ex);
            }
        }
    }

?>