<?php
require 'inc/conn.php';
$usernameStatus = "dark";
$passStatus = "dark";
$error = "";

if (isset($_SESSION['inactivity'])) {
    ?>
    <script>
        alert("You have been logged out due to inactivity.");
        location.reload();
    </script>
    <?php
} 

if(isset($_SESSION['error'])){
    $errorCode = $_SESSION['error'];

    if($errorCode == 1){
        $usernameStatus = "danger";
        $passStatus = "danger";
        $error = "Account doesnt exist.";
    }else if($errorCode == 2){
        $passStatus = "danger";
        $error = "Incorrect password.";
    }
}
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <title>Adeqa - Login</title>
    </head>
    <body>
    <div style="width: 40%; padding-top: 10%; margin-left: 30%">
        <h1 class="text-center">
            <img src="inc/img/alfablack.jpeg" style="width: 10%">
            <img src="inc/img/adeeqablack.png" style="width: 30%">
        </h1>
        <form name="login" method="post" action="login.php">
            <input type="text" name="username" id="username" value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];} ?>" class="form-control border border-<?=$usernameStatus?>" placeholder="Username">
            <br>
            <input type="password" name="password" id="password" class="form-control border border-<?=$passStatus?>" placeholder="Password">
            <label id="passError" style="color: red"><?=$error?></label>
            <br>
            <input type="submit" value="Login" class="form-control" style="background-color: #222622; color: white">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    </html>

<?php
session_unset();