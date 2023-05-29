<div class="navbar navbar-expand-lg bg-body-tertiary" style="min-height: 10vh">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="https://i.imgur.com/jUBeM4g.png" alt="logo cameroon events" width="100" height="auto">
        </a>
        <div class="d-flex align-items-center">
            <a href="./pages/new_event" class="btn btn-primary" style="min-width: 120px; margin: 0 20px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Event</a>
            <?php
            session_start();
            if (isset($_SESSION['login']) and $_SESSION['role'] === "ADMIN"){
                echo "<a style='margin-right: 10px' href='./pages/dashboard' class='dashboard-btn btn btn-dark'>Dashboard</a>";
            }
            ?>
            <?php
                if (isset($_SESSION['login'])){
                    echo "<a href='./pages/profile' class='greeting'>".$_SESSION['login']."</a>";
                }else{
            ?>
                <a href="./pages/login" class="link text-center m-2"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
            <?php } ?>
        </div>
    </div>
</div>
