<?php
include("../../config/db.php");
if (!empty($db)) {
    $sql = "DELETE FROM event WHERE id = :id;";
    $statement = $db->prepare($sql);
    $statement->bindParam(":id", $_GET['id']);

    if ($statement->execute()){
        header('Location: ./');
    }else{
        echo "<script>alert('Something went wrong')</script>";
    }
}