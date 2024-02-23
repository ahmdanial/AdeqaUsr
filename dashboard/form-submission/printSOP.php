<?php
require '../../inc/conn.php';

$userID = $_SESSION['userID'];

$encrypted = urldecode($_GET['data']);
$key = "Adeqa2024JmPEfQ8quhQhWZfNYmFVCK3"; // Your secret key

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
$reagentID = $parts[0];
$program = $parts[1];
$institutionID = $parts[2];
$labID = $parts[3];
$instrumentID = $parts[4];
$testcode = $parts[5];

$sqlProgram = "SELECT * FROM programs WHERE id = '$program'";
$rowProgram = $conn->query($sqlProgram)->fetch_object();


#$sqlEntry = "SELECT A.* FROM tests A, subassigntest B, assign_test C WHERE A.reagent_id = '$reagentID'
#AND A.testcode = B.testcode AND c.id = B.assign_test_id";
#$resultEntry = $conn->query($sqlEntry);


$sqlTest = "SELECT E.testcode, A.unit, C.methodname, D.testname, B.ID, D.expected_result FROM assign_Test B, Units A, Methods C, Tests D, 
            subassigntest E WHERE D.Method_id = C.id and D.unit_id = A.id and E.Testcode = D.testcode and B.id = E.assign_test_id AND B.prog_id = '$program'
            AND B.reagent_id = '$reagentID' AND B.lab_id = '$labID' AND B.instrument_id = '$instrumentID' and D.reagent_id =B.Reagent_ID";
echo "<br>";
$resultTests = $conn->query($sqlTest);
$rowTests = $resultTests->fetch_object();

$sqlResult = "SELECT * FROM entryresults WHERE assignTestID = '$rowTests->ID'";
$resultResult = $conn->query($sqlResult);
$rowResult = $resultResult->fetch_object();

$sqlReagent = "SELECT reagent FROM reagents WHERE id = '$reagentID'";
$rowReagent = $conn->query($sqlReagent)->fetch_object();

$sqlInstrument = "SELECT instrumentname FROM instruments WHERE id = '$instrumentID'";
$rowInstrument = $conn->query($sqlInstrument)->fetch_object();

$sqlLab = "SELECT labname FROM labs WHERE id = $labID";
$rowLab = $conn->query($sqlLab)->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adeqa - Summary of Performance</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            /* Hide non-printable elements */
            .no-print {
                display: none;
            }

            /* Define header */
            @page {
                size: A4 landscape;
                margin: 80px 25px 30px 25px;
                counter-increment: page;
                @top-center {
                    content: "Header content";
                }
            }

            /* Define footer */
            @page {
                @bottom-center {
                    content: counter(page);
                }
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .container-fluid {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .row {
            margin: 0;
        }

        .col {
            padding: 10px;
        }

        /* Adjustments for printing */
        @media print {
            body {
                font-size: 10px;
            }

            h3 {
                font-size: 14px;
            }

            .table th,
            .table td {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start;">
                    <img src="../../inc/img/alfablack.jpeg" style="width: 10%;">
                    <label style="margin-top: 0.3%; margin-left: 10px;"><b>Alfa Diagnostik Sdn Bhd<br>Nombor 36, Jalan PJU 1A/13 Taman Perindustrian Jaya,<br> Ara Damansara,<br> 47301 Petaling Jaya, Selangor</b></label>
                </div>
                <img src="../../inc/img/adeeqablack.png" style="width: 10%;">
            </div>
            <hr>
            <br>
            <div style="display: flex; justify-content: space-between; margin-top: -2%; margin-bottom: 1%">
                <label style="font-size: 260%; font-weight: bold">&emsp;</label>
                <div style="font-size: 120%; margin-top: 1%">
                    <table class="table table-borderless">
                        <tr>
                            <th>Lab: </th>
                            <td><?=$rowLab->labname?></td>
                        </tr>
                        <tr>
                            <th>Instrument: </th>
                            <td><?=$rowInstrument->instrumentname?></td>
                        </tr>
                        <tr>
                            <th>Reagent: </th>
                            <td><?=$rowReagent->reagent?></td>
                        </tr>
                        <tr>
                            <th>Report Issue Date: </th>
                            <td><?=$currentDate?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <br>
            <div style="display: flex; justify-content: space-between; margin-top: -2%">
                <label style="font-size: 260%; font-weight: bold">Summary of Performance</label>
                <label style="font-size: 122%; margin-top: 1%"><b></b></label>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="6" style="background-color: #242865; color: white"><h5>Performance Assessment</h5></th>
                </tr>
                <tr>
                    <td class="col-2">&emsp;</td>
                    <td colspan="5" class="text-center" style="background-color: #242865; color: white;">Sample: <?=$rowProgram->programname?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Test</th>
                    <th>Your Result</th>
                    <th>Expected Result</th>
                    <th>Review</th>
                    <th>Z-Score</th>
                    <th>APS</th>
                </tr>
                <tr>
                    <td><?=$rowTests->testname?>:<br><?=$rowTests->methodname?></td>
                    <td><?=$rowResult->result_2?></td>
                    <td><?=$rowTests->expected_result?></td>
                    <td>Not Applicable</td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <br>
            <div style="background-color: #ececec; padding: 0.3%; margin-top: 1%;">
                <h5>Overall Performance</h5><br>
                <label>All samples were not assessed in this instance. Please refer to the commentary.</label>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

