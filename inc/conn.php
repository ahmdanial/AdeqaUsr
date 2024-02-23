<?php
$conn = new mysqli("localhost", "root", "", "adeqa2");
date_default_timezone_set('Asia/Kuala_Lumpur');
$currentDate = date("j F Y");
$currentDate1 = date("Y-m-d");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}