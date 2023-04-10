<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>login</title>
    <link rel="icon" href="../../frontend/assets/icons/logo.ico">
</head>
<body>
<?php
    include "../../config/db.php";
    session_start();
    if(isset($_SESSION['login'])){
        header("Location: ../../");
    }
    if (isset($_POST['login'])){
        if (!empty($db)) {
            $sql = "select * from user where username = :username";
            $statement = $db->prepare($sql);
            $statement->bindParam(":username", $_POST['email']);
//            $statement->bindParam(":password", $_POST['password']);

            if($statement->execute()){
                $user = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
                if(password_verify($_POST['password'], $user['password'])){
                    $_SESSION['login'] = $user['name'].' '.$user['lastname'];
                    $_SESSION['user_id'] = $user['id'];
                    if($user['role'] === "ADMIN"){
                        header('Location: ../../pages/dashboard');
                    }else{
                        header('Location: ../../');
                    }
                }else{
                    echo "<div class='alert alert-danger' role='alert'>password wrong make sure you own this account.</div>";
                }
            }else{
                echo "<div class='alert alert-danger' role='alert'>there is no user with the specified username.</div>";
            }
        }
    }
?>
    <div class="d-flex mx-auto p-2 gap-10" style="justify-content: center; align-items: center; min-height: 100vh; flex-wrap: wrap">
        <img src="../../frontend/assets/icons/map.svg" alt="" width="400px" height="auto">
        <form action="#" method="POST" style="min-width: 400px">
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email address</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>

            <div class="row mb-4" style="flex-direction: column">
                <div class="col d-flex ">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="rememberme" checked />
                        <label class="form-check-label" for="rememberme"> Remember me </label>
                    </div>
                </div>

                <div class="col" >
                    <a href="../reset_password/">Forgot password?</a>
                </div>

                <button type="submit" name="login" class="btn btn-primary btn-block mb-4 m-2">Log in</button>
            </div>
            <div class="text-center">
                <p>Not a member? <a href="../register">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>



