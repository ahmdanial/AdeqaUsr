<?php
require '../../inc/conn.php';

$assignTestID = $_POST['assigntestID'];
$userID = $_SESSION['userID'];
$sampleDate = $_POST['sampleDate1'];
$result_1 =

$sqlUpdate = "UPDATE `entryresults` SET `sampledate`='[value-3]',
             `result_1`='[value-4]',`result_2`='[value-5]'
              WHERE assignTestID = '$assignTestID' AND added_by = '$userID'";