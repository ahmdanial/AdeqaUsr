<?php
require '../inc/conn.php';
if (!isset($_SESSION['userID'])) {
    header("Location: ../");
}

if (isset($_POST['program'])) {
    $viewBtn = "";
} else {
    $viewBtn = "hidden";
}

$testcode = "";
$reagentID = "";
$labID = "";
$instrumentID = "";
$sampleDate = "";
$institutionsValue = "";
$programID = "";
$selectedPrograms = isset($_POST['program']) ? $_POST['program'] : array();
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
    <title>Adeqa - Dashboard</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="./">
        <img src="../inc/img/adeeqablack.png" width="25%" height="auto" class="d-inline-block align-top" alt="">
        <b></b>
    </a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link text-dark" href="index.php">Entry Data |</a>
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
    <h1 class="text-center">Summary of Performance</h1>
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
                            $sqlProg = "SELECT * FROM programs";
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
                        $sqlInstrument = "SELECT * FROM instruments WHERE institution_id = '$instID'";
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
            <tr>
                <th>
                    <label for="testcode">Testname :</label>
                </th>
                <td>
                    <select name="testcode" id="testcode" class="form-control text-center" disabled
                            onchange="this.form.submit()">
                        <option value="" disabled selected>--Select Testname--</option>
                        <?php
                        if (isset($_POST['reagent'])) {
                            $sqltestcode = "SELECT E.testcode, D.testname                                
                                            FROM assign_Test B, Units A, Methods C, Tests D,  subassigntest E                                      
                                            WHERE D.Method_id = C.id and D.unit_id = A.id  and E.Testcode = D.testcode and B.id = E.assign_test_id 
                                            AND B.prog_id = '$programID' AND B.reagent_id = '$reagentID' AND B.lab_id = '$labID'                
                                            AND B.instrument_id = '21' and D.reagent_id =B.Reagent_ID                                   
                                            Group by E.testcode, A.unit, C.methodname, D.testname, B.ID";
                            //$sqltestcode = "SELECT * FROM tests WHERE reagent_id = '$reagentID'";
                            $resulttestcode = $conn->query($sqltestcode);
                            while ($rowtestcode = $resulttestcode->fetch_object()) {
                                ?>
                                <option value="<?= $rowtestcode->testcode ?>"><?= $rowtestcode->testname ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php
            if (isset($_POST['reagent'])) {
                ?>
                <script>
                    let testcodeElement = document.getElementById('testcode');
                    testcodeElement.disabled = false;
                </script>
                <?php
            }
            ?>
            <tr>
                <td colspan="3"></td>
                <?php
                if (isset($_POST['testcode'])) {
                    $testcode = $_POST['testcode'];
                    ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            let testcodeVal = <?php echo json_encode($testcode); ?>;
                            let selectElement = document.getElementById('testcode');

                            for (let i = 0; i < selectElement.options.length; i++) {
                                if (selectElement.options[i].value == testcodeVal) {
                                    selectElement.options[i].selected = true;
                                    break;
                                }
                            }
                        });
                    </script>
                <?php
                ?>
                    <td>
                        <button style="width: 50%; margin-left: 25%" onclick="view()" type="button">View</button>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </table>
    </form>

    <?php
    function encryptData($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        $encryptedData = base64_encode($iv . $encrypted);
        return $encryptedData;
    }

    $key = "Adeqa2024JmPEfQ8quhQhWZfNYmFVCK3"; // Your secret key
    $data = "$reagentID|$programID|$instID|$labID|$instrumentID|$testcode";
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

        function view() {
            window.open('form-submission/printSumOfPerformance.php?data=<?=$encrypted?>', '_blank');
        }


    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
