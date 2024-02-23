<?php
require '../../inc/conn.php';
$userID = $_SESSION['userID'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $count = $_POST['count'];
    for ($i = 0; $i < $count; $i++) {
       // $programID = $_POST['programID'];
       // $labID = $_POST['labID'];
       // $instrumentID = $_POST['instrumentID'];
      //  $reagentID = $_POST['reagentID'];
        $assigntestID = $_POST['assigntestID'];
        $testcode = $_POST['testcode-' . ($i + 1)];
        $result1 = $_POST['result1-' . ($i + 1)];
        $result2 = $_POST['result2-' . ($i + 1)];
        $sampleDate = $_POST['sampleDate'];

        $sql = "INSERT INTO `entryresults`(`assigntestID`, `testcode`, `sampledate`, `result_1`, `result_2`, 
        `added_by`) VALUES ('$assigntestID','$testcode','$sampleDate','$result1','$result2','$userID')";
        $conn->query($sql);

    }
    ?>
    <script>
        alert("Data added succesfully!");
        window.location = "../index.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("Invalid request method.");
        window.location = "../index.php";
    </script>
    <?php
}
