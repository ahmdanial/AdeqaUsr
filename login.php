<?php
require 'inc/conn.php';
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT userid, password, institutionCode, acctnum, roles FROM users WHERE username = '$username'";
$result = $conn->query($sql);
$row = $result->fetch_object();
$error = "";

if ($result->num_rows > 0) {
    if (password_verify($password, $row->password)) {
        $_SESSION['userID'] = $row->userid;
        $_SESSION['userInstID'] = $row->institutionCode;
        $_SESSION['userRoles'] = $row->roles;
        $_SESSION['userAcct'] = $row->acctnum;
        ?>
        <script>            
            alert("You have successfully logged in!");          
            <?php if ($row->roles =="user") { ?>
                window.location = "dashboard/index.php";
            <?php } else { ?>
                window.location = "admin/index.php";      
            
            <?php }  ?>
        </script>
        <?php
    } else {
        $_SESSION['username'] = $username;
        $error = 2;
        $_SESSION['error'] = $error;
        header("Location: ./");
    }
} else {
    $error = 1;
    $_SESSION['error'] = $error;
    header("Location: ./");
}
