
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>login</title>
    <link rel="icon" href="../../../frontend/assets/icons/logo.ico">
</head>
<body>
<?php
include ("../../../config/db.php");
session_start();

$user = null;
if (!empty($db)) {
    $st = $db->prepare("Select * from user where id = :id");
    $st->bindParam(":id", $_GET['id']);
    $st->execute();
    $user = $st->fetchAll()[0];
}

if (isset($_POST['update'])){
    if (!empty($db)) {
            $password = "";

            if(isset($_POST['password']) and isset($_POST['repassword'])){
                $password_hash = "";
                if($_POST['password'] === $_POST['repassword']){
                    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $password = "`password` = :password,";
                }
            }

            $sql = "UPDATE `user` SET ".$password." `name` = :firstname, `lastname` = :lastname, `username` = :username WHERE `user`.`id` = 1;";

            $statement = $db->prepare($sql);
            $statement->bindParam(":username", $_POST['username']);
            $statement->bindParam(":password", $password_hash);
            $statement->bindParam(":firstname", $_POST['firstname']);
            $statement->bindParam(":lastname", $_POST['lastname']);
            try{
                if($statement->execute()){
                    header('Location: ../../');
                }
            }catch (Exception $ex){
                print_r($ex);
                echo "<div class='alert alert-danger' role='alert'>error registering new user".$statement->errorInfo()[2]."</div>";
            }
        }
}
?>
<div class="d-flex mx-auto p-2 gap-10" style="justify-content: center; align-items: center; min-height: 100vh; flex-wrap: wrap">
    <img src="../../../frontend/assets/icons/map.svg" alt="" width="400px" height="auto">
    <form action="#" method="POST" style="min-width: 400px">
        <div class="form-outline mb-4">
            <label class="form-label" for="firstname">Name: </label>
        <input type="text" id="firstname" value="<?=$user['name']?>" name="firstname" class="form-control" required />
        </div>
        <div class="form-outline mb-4">
            <label class="form-label" for="Taking you to the target site.lastname">Lastname: </label>
            <input type="text" id="lastname" value="<?=$user['lastname']?>" name="lastname" class="form-control" required />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="username">Email address</label>
            <input type="email" id="username" value="<?=$user['username']?>" name="username" class="form-control" required />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control"  />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="repassword">Confirm password</label>
            <input type="password" id="repassword" name="repassword" class="form-control"  />
        </div>

        <button type="submit" name="update" class="btn btn-primary btn-block mb-4 m-2">update</button>
    </form>
</div>
</body>
</html>


