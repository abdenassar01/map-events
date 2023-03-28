
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
session_start();
$_SESSION['login'] = "nassar";

if (isset($_POST['signin'])){
    echo $_POST['email']." - ".$_POST['password'];
}
?>
<div class="d-flex mx-auto p-2 gap-10" style="justify-content: center; align-items: center; min-height: 100vh; flex-wrap: wrap">
    <img src="../../frontend/assets/icons/map.svg" alt="" width="400px" height="auto">
    <form action="#" method="POST" style="min-width: 400px">
        <div class="form-outline mb-4">
            <label class="form-label" for="email">Name: </label>
            <input type="email" id="email" name="email" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="email">Lastname: </label>
            <input type="email" id="email" name="email" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" name="email" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" />
        </div>

        <button type="submit" name="signin" class="btn btn-primary btn-block mb-4 m-2">Sign up</button>

        <div class="text-center">
            <p>Already have an account ? <a href="../login">Log in</a></p>
        </div>
    </form>
</div>
</body>
</html>



