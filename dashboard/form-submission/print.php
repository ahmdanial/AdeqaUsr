<?php
require '../../inc/conn.php';

$userID = $_SESSION['userID'];

$encrypted = urldecode($_GET['data']);
$key = "Adeqa2024"; // Your secret key

function decryptData($encryptedData, $key)
{
    $encryptedData = base64_decode($encryptedData);
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encryptedData, 0, $ivLength);
    $encrypted = substr($encryptedData, $ivLength);
    $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    return $decrypted;
}

$decrypted = decryptData($encrypted, $key);

$data = "$decrypted";
$parts = explode("|", $data);

$programID = $parts[0];
$reagentID = $parts[1];
$labID = $parts[2];
$instrumentID = $parts[3];
$sampleDate = $parts[4];
$dateString = $sampleDate;
$date1 = DateTime::createFromFormat('Y-m-d', $dateString);
//$formattedDate = $date1->format('j F Y');
$formattedDate = $dateString;

$sqlProgram = "SELECT programname FROM programs WHERE id = '$programID'";
$rowProgram = $conn->query($sqlProgram)->fetch_object();
$sqlReagent = "SELECT reagent FROM reagents WHERE id = '$reagentID'";
$rowReagent = $conn->query($sqlReagent)->fetch_object();
$sqlLab = "SELECT labname,institution_id FROM labs WHERE id = '$labID'";
$rowLab = $conn->query($sqlLab)->fetch_object();
$sqlInstitution = "SELECT institution FROM institutions WHERE id = '$rowLab->institution_id'";
$rowInstitution = $conn->query($sqlInstitution)->fetch_object();
$sqlInstrument = "SELECT instrumentname FROM instruments WHERE id = '$instrumentID'";
$rowInstrument = $conn->query($sqlInstrument)->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adeqa - Print Result Entry</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top: 5%">
    <h1>Result</h1>
    <table class="table table-borderless" style="margin-top: 2%">
        <thead>
        <tr>
            <th scope="col">Institution :</th>
            <td scope="col"><?= $rowInstitution->institution ?></td>
            <th scope="col">Lab :</th>
            <td scope="col"><?= $rowLab->labname ?></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="col">Program :</th>
            <td><?= $rowProgram->programname ?></td>
            <th>Instrument :</th>
            <td><?= $rowInstrument->instrumentname ?></td>
        </tr>
        <tr>
            <th scope="col">Reagent :</th>
            <td><?= $rowReagent->reagent ?></td>
        </tr>
        </tbody>
        <tr>
            <th>Sample Date:</th>
            <td><?= $formattedDate ?></td>
        </tr>
    </table>
    <hr>
    <table class="table table-borderless" style="margin-top: 2%">
        <tr>
            <th>Test Code</th>
            <th>Test Name</th>
            <th>Result #1</th>
            <th>Result #2</th>
            <th>Unit</th>
            <th>Method</th>
        </tr>
        <?php
      //  $sqlStart = "SELECT * FROM entryresults WHERE program_id = '$programID' AND reagent_id = '$reagentID'
       //        AND lab_id = '$labID' AND instrument_id = '$instrumentID' AND sampledate = '$sampleDate' AND added_by = '$userID'";
        
        $sqlStart = "SELECT AA.testcode, A.unit, C.methodname, D.testname, B.ID, AA.result_1, AA.result_2 
        FROM assign_Test B, Units A, Methods C, Tests D,  subassigntest E, entryresults AA
        WHERE AA.assignTestID =E.assign_test_id and D.Method_id = C.id and D.unit_id = A.id  and E.Testcode = D.testcode 
        and B.id = E.assign_test_id 
        AND B.prog_id = '$programID' AND B.reagent_id = '$reagentID' AND B.lab_id = '$labID' 
        AND B.instrument_id = '$instrumentID' and D.reagent_id =B.Reagent_ID";
        //and AA.sampledate = '$sampleDate'

        $resultStart = $conn->query($sqlStart);
        while ($rowStart = $resultStart->fetch_object()) {
           // $sqlTest = "SELECT * FROM tests WHERE testcode = '$rowStart->testcode'";
           // $rowTest = $conn->query($sqlTest)->fetch_object();
           // $sqlUnit = "SELECT unit FROM units WHERE id = '$rowTest->unit_id'";
          //  $rowUnit = $conn->query($sqlUnit)->fetch_object();
         //   $sqlMethod = "SELECT methodname FROM methods WHERE id = '$rowTest->method_id'";
          //  $rowMethod = $conn->query($sqlMethod)->fetch_object();
            ?>
            <tr>
                <td><?= $rowStart->testcode ?></td>
                <td><?= $rowStart->testname ?></td>
                <td><?= $rowStart->result_1 ?></td>
                <td><?= $rowStart->result_2 ?></td>
                <td><?= $rowStart->unit ?></td>
                <td><?= $rowStart->methodname ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    
    <hr>
    <?php
    $sqlUser = "SELECT fullname FROM users WHERE id = '$userID'";
    $rowUser = $conn->query($sqlUser)->fetch_object();
    ?>
    <b>Generated by: <?= $rowUser->fullname ?></b>
</div>
<script>
    window.onload = function () {
        window.print();
    };
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

