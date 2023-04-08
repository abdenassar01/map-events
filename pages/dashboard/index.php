<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../../frontend/assets/icons/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<?php
    session_start();
    include_once("../../config/db.php")
?>
    <div class="container-fluid py-4" >
        <div class="d-flex p-2 justify-content-between">
            <h2>Welcome <span style="color: #2450ff"><?=$_SESSION['login']?></span></h2>
            <a href="../../" class="btn btn-primary">Home</a>
        </div>
        <p class="pt-2">This is the list of event awaiting your approval</p>
        <a href="../new_event/" class="btn btn-success my-2">New Event</a>
        <table class="table align-items-center mb-0" style="border: 1px solid #F2F2F2">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Title</th>
                <th scope="col">operation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($db)) {
                $condition = isset($_GET['status']) ? " WHERE status = '".$_GET['status']."' ;" : ";";
                $sql = "SELECT * FROM `event` ".$condition;

                $statement = $db->prepare($sql);
                if ($statement->execute()){
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    if (count($result) === 0){
                        echo "<div class='alert alert-info' role='alert'>No events at the moment.</div>";
                    }
                    foreach ($result as $value){
                        ?>
                            <tr>
                                <th scope="row" class="text-xs font-weight-bold mb-0"><?=$value['id']?></th>
                                <td>
                                    <img style="border-radius: 50px; object-fit: cover;" width="40" height="40" src="../../api/image/<?=$value['image']?>" alt="<?=$value['title']?>">
                                    <?=$value['title']?>
                                </td>
                                <td>
                                    <a href='../new_event/?id=<?=$value['id']?>' class='btn btn-success' >update</a>
                                    <a href='delete.php?id=<?=$value['id']?>' class='btn btn-danger' onclick='return confirm("Are you sure you want to delete this event?")'>Delete</a>
                                    <?php
                                    if($value['status'] === 'unapproved'){
                                        ?>
                                        <a href='approve.php?id=<?=$value['id']?>' class='btn btn-primary'>Approve</a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                    }
                }else{
                    echo "<div class='alert alert-info' role='alert'>Something went wrong</div>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
