<?php
session_start();
session_destroy();
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $inactivity = $_GET['inactivity'];

    if (!empty($inactivity)) {
        $_SESSION['inactivity'] = 'inactive';
    }
}
header("Location: ./");