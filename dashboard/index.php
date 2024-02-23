<?php
require '../inc/conn.php';
if (!isset($_SESSION['userID'])) {
    header("Location: ../");
}

$programID = "";
$reagentID = "";
$labID = "";
$instrumentID = "";
$sampleDate = "";
$userID = $_SESSION['userID'];
$instID = $_SESSION['userInstID'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../inc/dashboard.css">
    <title>Adeqa - Dashboard </title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="./">
        <img src="../inc/img/adeeqablack.png" width="25%" height="auto" class="d-inline-block align-top" alt="">
        <b></b>
    </a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link text-dark" href="index.php">Result Entry |</a>
        </li>

    </ul>
    <ul class="navbar-nav" style="margin-right: 1%;">
        <li class="nav-item">
            <a class="nav-link text-dark" href="sumOfPerformance.php">Summary of Performance |</a>
        </li>
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-danger" href="../logout.php">Logout</a>
        </li>
    </ul>
</nav>
<?php
$sqlLab = "SELECT * FROM labs where institution_id = '" . $instID . "'";
$resultLab = $conn->query($sqlLab);
?>
<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <h1 class="text-center">Result Entry </h1>
    <br>
    <form method="post">
        <table class="table table-borderless">
            <tr class="col-2">
                <th style="width: 25%">
                    <label for="lab">Lab :</label>
                </th>
                <td style="width: 25%">
                    <select name="lab" id="lab" class="form-control text-center" onchange="this.form.submit()">
                        <option value="" disabled selected>--Select Lab--</option>
                        <?php
                        while ($rowLab = $resultLab->fetch_object()) {
                            ?>
                            <option value="<?= $rowLab->id ?>"><?= $rowLab->labname ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>

                <th style="width: 25%">
                    <label for="program">Program/Cycle/Sample :</label>
                </th>

                <td style="width: 25%">
                    <select name="program" id="program" class="form-control text-center" onchange="this.form.submit()"
                            disabled>
                        <option value="" disabled selected>--Select Program--</option>
                        <?php
                        if (isset($_POST['lab'])) {
                            $sqlProg = "SELECT * FROM programs WHERE opendate <= '$currentDate1' AND closedate >= '$currentDate1'";

                            $resultProg = $conn->query($sqlProg);
                            while ($rowProg = $resultProg->fetch_object()) {
                                ?>
                                <option value="<?= $rowProg->id ?>"><?= $rowProg->programname ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <?php
                if (isset($_POST['lab'])) {
                    $labValue = $_POST['lab'];
                    $labID = $labValue;
                    ?>
                    <script>
                        let progElement = document.getElementById('program');
                        progElement.disabled = false;

                        document.addEventListener('DOMContentLoaded', function () {
                            let labValue = <?php echo json_encode($labValue); ?>;
                            let selectElement = document.getElementById('lab');

                            for (let i = 0; i < selectElement.options.length; i++) {
                                if (selectElement.options[i].value == labValue) {
                                    selectElement.options[i].selected = true;
                                    break;
                                }
                            }
                        });
                    </script>
                    <?php
                }
                ?>


            </tr>
            <tr class="col-2">

                <th>
                    <label for="instrument">Instrument :</label>
                </th>
                <td>
                    <select name="instrument" id="instrument" class="form-control text-center"
                            onchange="this.form.submit()" disabled>
                        <option value="" disabled selected>--Select Instrument--</option>
                        <?php
                        // if (isset($_POST['institution'])) {
                        //     $deptValue = $_POST['institution'];
                        $sqlInstrument = "SELECT * FROM assign_instruments WHERE institution_id = '$instID'";
                        $resultInstrument = $conn->query($sqlInstrument);
                        while ($rowInstrument = $resultInstrument->fetch_object()) {
                            ?>
                            <option value="<?= $rowInstrument->id ?>"><?= $rowInstrument->instrumentname ?></option>
                            <?php
                        }
                        // }
                        ?>
                    </select>
                </td>
                <?php
                if (isset($_POST['program'])) {
                    $progValue = $_POST['program'];
                    $programID = $progValue;
                    ?>
                    <script>
                        let instElement = document.getElementById('instrument');
                        instElement.disabled = false;

                        document.addEventListener('DOMContentLoaded', function () {
                            let progValue = <?php echo json_encode($progValue); ?>;
                            let selectElement = document.getElementById('program');

                            for (let i = 0; i < selectElement.options.length; i++) {
                                if (selectElement.options[i].value == progValue) {
                                    selectElement.options[i].selected = true;
                                    break;
                                }
                            }
                        });
                    </script>
                    <?php
                }
                ?>
                <th>
                    <label for="reagent">Reagent :</label>
                </th>
                <td>

                    <select name="reagent" id="reagent" class="form-control text-center" onchange="this.form.submit()"
                            disabled>
                        <option value="" disabled selected>--Select Reagent--</option>
                        <?php
                        if (isset($_POST['instrument'])) {
                            $instrVal = $_POST['instrument'];
                            $sqlReagent = "SELECT A.id, A.reagent FROM reagents A, assign_test B WHERE A.id = B.reagent_id 
                            AND A.instrument_id = B.instrument_id AND B.instrument_id = '$instrVal'
                            AND B.lab_id = '$labID' and B.prog_id = '$programID' group by A.id, A.reagent";
                            $resultReagent = $conn->query($sqlReagent);
                            while ($rowReagent = $resultReagent->fetch_object()) {
                                ?>
                                <option value="<?= $rowReagent->id ?>"><?= $rowReagent->reagent ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <?php
                if (isset($_POST['instrument'])) {
                    $instrumentVal = $_POST['instrument'];
                    $instrumentID = $instrumentVal;
                    ?>
                    <script>
                        let reagentElement = document.getElementById('reagent');
                        reagentElement.disabled = false;

                        document.addEventListener('DOMContentLoaded', function () {
                            let instrumentVal = <?php echo json_encode($instrumentVal); ?>;
                            let selectElement = document.getElementById('instrument');

                            for (let i = 0; i < selectElement.options.length; i++) {
                                if (selectElement.options[i].value == instrumentVal) {
                                    selectElement.options[i].selected = true;
                                    break;
                                }
                            }
                        });
                    </script>
                    <?php
                }
                if (isset($_POST['reagent'])) {
                    $reagentVal = $_POST['reagent'];
                    $reagentID = $reagentVal;
                    ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            let reagentVal = <?php echo json_encode($reagentVal); ?>;
                            let selectElement = document.getElementById('reagent');

                            for (let i = 0; i < selectElement.options.length; i++) {
                                if (selectElement.options[i].value == reagentVal) {
                                    selectElement.options[i].selected = true;
                                    break;
                                }
                            }
                        });
                    </script>
                    <?php
                }
                ?>
            </tr>

        </table>

        <?php
        if (isset($_POST['reagent'])) {
        $reagentValue = $_POST['reagent'];
        $sqlEntry = "SELECT A.testcode, A.testname FROM tests A, subassigntest B, assign_test C WHERE A.reagent_id = '$reagentValue'
                     AND A.testcode = B.testcode AND c.id = B.assign_test_id group by A.testcode, A.testname ";
        $resultEntry = $conn->query($sqlEntry);
        ?>

    </form>


    <?php
    if (isset($_POST['reagent'])) {
        /* $sqlDate = "SELECT A.* ,
         (select unit from units X, Tests Z where X.id=Z.Unit_id and Z.testcode = E.testcode and Z.reagent_id =B.Reagent_ID) as unit,
         (select methodname from methods Y, Tests Z where Y.id=Z.method_id and  Z.testcode = E.testcode and Z.reagent_id =B.Reagent_ID) as methodname
         FROM entryresults A, assign_Test B, subassigntest E
         WHERE A.assignTestID =E.assign_test_id and B.ID =E.assign_test_id and A.sampledate = '$sampleDate'
         AND B.prog_id = '$programID' AND B.reagent_id = '$reagentValue' AND B.lab_id = '$labID'
         AND B.instrument_id = '$instrumentID'"; */

        $sqlDate3 = "SELECT * FROM entryresults A, assign_test B, programs C, instruments D WHERE A.assignTestID = B.id 
        AND C.id = B.prog_id AND B.prog_id = '$programID' and B.instrument_id = D.id and D.institution_id = '$instID'";

        $numRowDate = $conn->query($sqlDate3)->num_rows;

        $sqlDate = "SELECT E.testcode, A.unit, C.methodname, D.testname, B.ID, AA.result_1, AA.result_2, AA.sampledate
                    FROM assign_Test B, Units A, Methods C, Tests D,  subassigntest E, entryresults AA
                    WHERE AA.assignTestID =E.assign_test_id and D.Method_id = C.id and D.unit_id = A.id  and E.Testcode = D.testcode
                    and B.id = E.assign_test_id
                    AND B.prog_id = '$programID' AND B.reagent_id = '$reagentValue' AND B.lab_id = '$labID'
                    AND B.instrument_id = '$instrumentID' and D.reagent_id =B.Reagent_ID
                    Group by E.testcode, A.unit, C.methodname, D.testname, B.ID, AA.result_1, AA.result_2, AA.sampledate";


        $sqlDate2 = "SELECT E.testcode, A.unit, C.methodname, D.testname, B.ID 
        FROM assign_Test B, Units A, Methods C, Tests D,  subassigntest E
        WHERE D.Method_id = C.id and D.unit_id = A.id  and E.Testcode = D.testcode and B.id = E.assign_test_id
        AND B.prog_id = '$programID' AND B.reagent_id = '$reagentValue' AND B.lab_id = '$labID' 
        AND B.instrument_id = '$instrumentID' and D.reagent_id =B.Reagent_ID 
        Group by E.testcode, A.unit, C.methodname, D.testname, B.ID";

        $sqlProgramSample = "SELECT * FROM programs WHERE id = $programID";
        $rowProgramSample = $conn->query($sqlProgramSample)->fetch_object();
        ?>

        <?php
        if ($numRowDate == 0) {
            ?>
            <form action="form-submission/formsubmit.php" method="post">
                <table class="table table-bordered">
                    <tr style="background-color: #dcdcdc">
                        <th>Test Code Here</th>
                        <th>Test Name</th>
                        <th>Result #1</th>
                        <th>Result #2<span style="color: red"> *</span></th>
                        <th>Unit</th>
                        <th>Method</th>
                        <th hidden>Sample Date</th>
                    </tr>
                    <?php

                    //$rowEntry = $conn->query($sqlDate2)->fetch_object();
                    //$numRow2 = $conn->query($sqlDate2)->num_rows;
                    $resultStat1 = $conn->query($sqlDate2);


                    $i = 1;
                    while ($rowEntry = $resultStat1->fetch_object()) {
                        //while ($i <= $numRow2) {
                        $unit = $rowEntry->unit;
                        $method = $rowEntry->methodname;
                        $testcode = $rowEntry->testcode;
                        $testname = $rowEntry->testname;
                        $assigntestID = $rowEntry->ID;
                        ?>
                        <tr>
                            <td>
                                <?= $rowEntry->testcode ?>
                                <input type="text" name="testcode-<?= $i ?>" value="<?= $rowEntry->testcode ?>" hidden>
                            </td>
                            <td><?= $rowEntry->testname ?><input type="date" name="sampleDate"
                                                                 value="<?= $sampleDate ?>"
                                                                 hidden></td>
                            <td><input type="number" step="0.01" name="result1-<?= $i ?>"></td>
                            <td>
                                <select name="result2-<?= $i ?>" id="result2" required>
                                    <option value="">Result</option>
                                    <option value="Positive">Positive</option>
                                    <option value="Negative">Negative</option>
                                    <option value="Equivocal">Equivocal</option>
                                </select>
                            </td>
                            <td><?= $rowEntry->unit ?></td>
                            <td><?= $rowEntry->methodname ?><input type="number" name="assigntestID-<?= $i ?>" value="<?= $assigntestID ?>" hidden></td>
                            <td hidden><input type="date" name="sampledate1-<?= $i ?>" min="<?=$rowProgramSample->opendate?>" max="<?=$rowProgramSample->closedate?>" value="<?=$currentDate1?>" required hidden></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr style="background-color: #dcdcdc">
                        <td><input type="number" name="programID" value="<?= $programID ?>" hidden></td>
                        <td><input type="number" name="labID" value="<?= $labID ?>" hidden></td>
                        <td><input type="number" name="instrumentID" value="<?= $instrumentID ?>" hidden></td>
                        <td><input type="number" name="reagentID" value="<?= $reagentID ?>" hidden></td>
                        <td><input type="number" name="count" value="<?= $i - 1 ?>" hidden></td>
                        <td class="text-center">
                            <button style="width: 100">Save</button>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
        } else {

            $resultStat = $conn->query($sqlDate);
            $numRow3 = $conn->query($sqlDate)->num_rows;

            ?>
            <form action="form-submission/updateEntry.php" method="post">
                <table class="table table-bordered">
                    <tr style="background-color: #dcdcdc">
                        <th>Test Code</th>
                        <th>Test Name</th>
                        <th>Result #1</th>
                        <th>Result #2<span style="color: red"> *</span></th>
                        <th>Unit</th>
                        <th>Method</th>
                        <th hidden>Sample Date</th>
                    </tr>
                    <?php
                    $i = 1;
                    while ($rowEntry3 = $resultStat->fetch_object()) {
                        //while ($i <= $numRow3) {
                        $unit = $rowEntry3->unit;
                        $method = $rowEntry3->methodname;
                        $testcode = $rowEntry3->testcode;
                        $testname = $rowEntry3->testname;
                        $assigntestID = $rowEntry3->ID;
                        $resultValue1 = $rowEntry3->result_1;
                        $resultValue2 = $rowEntry3->result_2;
                        ?>
                        <tr>
                            <td><?= $rowEntry3->testcode ?><input type="text" name="testcode-<?= $i ?>"
                                                                  value="<?= $rowEntry3->testcode ?>" hidden></td>
                            <td><?= $rowEntry3->testname ?><input type="date" name="sampleDate"
                                                                  value="<?= $sampleDate ?>"
                                                                  hidden></td>
                            <td><input type="number" step="0.01" name="result1-<?= $i ?>" id="result1-<?= $i ?>"
                                       value="<?= $rowEntry3->result_1 ?>"></td>
                            <td>
                                <select name="result2-<?= $i ?>" id="result2-<?= $i ?>" required>
                                    <option value="">Result</option>
                                    <option value="Positive">Positive</option>
                                    <option value="Negative">Negative</option>
                                    <option value="Equivocal">Equivocal</option>
                                    <
                                </select>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        let resultValue2 = <?php echo json_encode($resultValue2); ?>;
                                        let selectElement = document.getElementById('result2-<?=$i?>');

                                        for (let i = 0; i < selectElement.options.length; i++) {
                                            if (selectElement.options[i].value == resultValue2) {
                                                selectElement.options[i].selected = true;
                                                break;
                                            }
                                        }
                                    });
                                </script>
                            </td>
                            <td><?= $rowEntry3->unit ?></td>
                            <td><?= $rowEntry3->methodname ?></td>
                            <td hidden><input type="date" name="sampledate1-<?= $i ?>" value="<?=$rowEntry3->sampledate?>" min="<?=$rowProgramSample->opendate?>" max="<?=$rowProgramSample->closedate?>" required></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr style="background-color: #dcdcdc">
                        <td><input type="number" name="programID" value="<?= $programID ?>" hidden></td>
                        <td><input type="number" name="labID" value="<?= $labID ?>" hidden></td>
                        <td><input type="number" name="instrumentID" value="<?= $instrumentID ?>" hidden></td>
                        <td><input type="number" name="reagentID" value="<?= $reagentID ?>" hidden></td>
                        <input type="number" name="assigntestID" value="<?= $assigntestID ?>" hidden>
                        <td><input type="number" name="count" value="<?= $i - 1 ?>" hidden></td>
                        <td class="text-center">
                            <button style="width: 50%" disabled title="Update function is not yet implemented.">Update
                            </button>
                            <button type="button" onclick="print()">Print</button>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
        }
    }
    }
    ?>
</div>
<?php
function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    $encryptedData = base64_encode($iv . $encrypted);
    return $encryptedData;
}

$key = "Adeqa2024"; // Your secret key
$data = "$programID|$reagentID|$labID|$instrumentID|$sampleDate";
$encrypted = encryptData($data, $key);
?>
<script type="text/javascript">
    let inactivityTime = 0;
    let inactivityInterval = 5000;

    function checkActivity() {
        inactivityTime += inactivityInterval;
        if (inactivityTime >= 900000) {
            window.location = "../logout.php?inactivity=inactive";
        }
    }

    document.addEventListener("mousemove", function () {
        inactivityTime = 0;
    });

    setInterval(checkActivity, inactivityInterval);

    function deptSelect(input) {
        let element = document.getElementById("lab");
        element.disabled = false;
    }

    function print() {
        window.open('form-submission/print.php?data=<?=$encrypted?>', '_blank');
    }


</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>