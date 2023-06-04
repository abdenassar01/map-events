<?php

    include("../../../../../config/db.php");
    if(!empty($db)){
    
     function utf8ize($d){ 
	if (is_array($d) || is_object($d))
	foreach ($d as &$v) $v = utf8ize($v);
	else
	return utf8_encode($d);

	return $d;
     }

        $req = "SELECT  D.id, D.name, COUNT(E.id) as 'nbr_events' FROM `departement` D INNER JOIN `event` E on E.departement_id = D.id GROUP BY D.id";
     
     $st = $db->prepare($req);
        if($st->execute()){
        	// echo "I'm testing again inside execute second";
        	header("Content-Type: application/json");
             //echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
             $data = $st->fetchAll(PDO::FETCH_ASSOC);
             echo json_encode(utf8ize($data));
        }
    }

?>
