<?php
    session_start();
    include("../../config/db.php");

    if (!$_SESSION['user_id']){
        header('Location: ../login/');
    }

    $user = [];
    if (!empty($db)) {
        $sql = "select * from user where id = :id;";
        $statement = $db->prepare($sql);
        $statement->bindParam(":id", $_SESSION['user_id']);

        if($statement->execute()){
            $user = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?="Profile | ".$user['name']." ".$user['lastname']?></title>
    <link rel="icon" href="../../frontend/assets/icons/logo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">
    <div class="card border">
        <img src="https://i.imgur.com/uJ5eRQs.jpg" alt="<?=$user['name']." ".$user['lastname']?>" class="avatar">
        <div class="text">
            <h3><?=$user['name']." ".$user['lastname']?></h3>
            <p><?=$user['username']?></p>
        </div>
        <div class="role">
            <?=$user['role']?>
        </div>
        <a class="logout" href="./logout.php">
            logout <i class="fa fa-sign-out" aria-hidden="true"></i>
        </a>
    </div>
    <?php
        include("./uploaded_events.php");
    ?>
</div>
</body>
</html>

