<?php
require '../inc/conn.php';
if (!isset($_SESSION['userID'])) {
    header("Location: ../");
}

if(!isset($_POST['reagent'])){
    $isHidden = "hidden";
}else{
    $isHidden = "";
}

$programID = "";
$reagentID = "";
$labID = "";
$instrumentID = "";
$sampleDate = "";
$institutionValue = "";
$program1 = "";
$program2 = "";
$selectedPrograms = isset($_POST['program']) ? $_POST['program'] : array();
$userID = $_SESSION['userID'];
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
$sqlInstitution = "SELECT * FROM institutions";
$resultInstitution = $conn->query($sqlInstitution);
?>
<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <h1 class="text-center">Summary of Performance</h1>
    <br>
    <form method="post" id="sopform">
        <table class="table table-borderless">
            <tr class="col-2">
                <th style="width: 25%">
                    <label for="institution">Institution :</label>
                </th>
                <td style="width: 25%">
                    <select name="institution" id="institution" class="form-control text-center"
                            onchange="this.form.submit()" required>
                        <option value="" disabled selected>--Select Institution--</option>
                        <?php
                        while ($rowInstitution = $resultInstitution->fetch_object()) {
                            ?>
                            <option value="<?= $rowInstitution->id ?>"><?= $rowInstitution->institution ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>

                <th style="width: 25%">
                    <label for="lab">Lab :</label>
                </th>
                <td style="width: 25%">
                    <select name="lab" id="lab" class="form-control text-center" onchange="this.form.submit()" disabled
                            required>
                        <option value="" disabled selected>--Select Lab--</option>
                        <?php
                        if (isset($_POST['institution'])) {
                            $institutionValue = $_POST['institution'];
                            $sqlLab = "SELECT * FROM labs WHERE institution_id = '$institutionValue'";
                            $resultLab = $conn->query($sqlLab);
                            while ($rowLab = $resultLab->fetch_object()) {
                                ?>
                                <option value="<?= $rowLab->id ?>"><?= $rowLab->labname ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <?php
                if (isset($_POST['institution'])) {
                    $institutionValue = $_POST['institution'];
                    ?>
                    <script>
                        let element = document.getElementById('lab');
                        element.disabled = false;

                        document.addEventListener('DOMContentLoaded', function () {
                            let institutionValue = <?php echo json_encode($institutionValue); ?>;
                            let selectElement = document.getElementById('institution');

                            for (let i = 0; i < selectElement.options.length; i++) {
                                if (selectElement.options[i].value == institutionValue) {
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
                            onchange="this.form.submit()" disabled required>
                        <option value="" disabled selected>--Select Instrument--</option>
                        <?php
                        if (isset($_POST['institution'])) {
                            $deptValue = $_POST['institution'];
                            $sqlInstrument = "SELECT * FROM instruments WHERE institution_id = '$deptValue'";
                            $resultInstrument = $conn->query($sqlInstrument);
                            while ($rowInstrument = $resultInstrument->fetch_object()) {
                                ?>
                                <option value="<?= $rowInstrument->id ?>"><?= $rowInstrument->instrumentname ?></option>
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
                        let progElement = document.getElementById('instrument');
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
                <th>
                    <label for="reagent">Reagent :</label>
                </th>
                <td>
                    <select name="reagent" id="reagent" class="form-control text-center" onchange="this.form.submit()"
                            disabled required>
                        <option value="" disabled selected>--Select Reagent--</option>
                        <?php
                        if (isset($_POST['instrument'])) {
                            $instrVal = $_POST['instrument'];
                            $sqlReagent = "SELECT * FROM reagents A, assign_test B WHERE A.id = B.reagent_id AND A.instrument_id = B.instrument_id AND B.instrument_id = '$instrVal'";
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
                <th><label for="program">Program :</label></th>
                <td>
                    <?php
                    if (isset($_POST['reagent'])) {
                        $reagentValue = $_POST['institution'];
                        $sqlProgram = "SELECT * FROM programs";
                        $resultProgram = $conn->query($sqlProgram);
                        $i = 1;
                        while ($rowProgram = $resultProgram->fetch_object()) {
                            $isChecked = in_array($rowProgram->id, $selectedPrograms) ? 'checked' : ''; // Check if the program is selected
                            if ($i != 2) {
                                ?>
                                <input type="checkbox" name="program[]" id="<?= $rowProgram->id ?>"
                                       value="<?= $rowProgram->id ?>" <?= $isChecked ?>> <?= $rowProgram->programname ?>
                                <?php
                                $i++;
                            } else {
                                ?>
                                <input type="checkbox" name="program[]" id="<?= $rowProgram->id ?>"
                                       value="<?= $rowProgram->id ?>"
                                       style="margin-left: 5%;" <?= $isChecked ?>> <?= $rowProgram->programname ?><br>
                                <?php
                                $i = 1;
                            }
                        }
                    }
                    ?>
                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                            const maxAllowed = 2;

                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', function () {
                                    const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;

                                    if (checkedCount > maxAllowed) {
                                        this.checked = false;
                                    }
                                });
                            });
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" id="viewbBtn" style="width: 30%; margin-left: 50%" <?=$isHidden?>>Confirm?</button>
                </td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($_POST['program']) && is_array($_POST['program'])) {
        $selectedPrograms = $_POST['program'];
        if (count($selectedPrograms) >= 2) {
            $program1 = $selectedPrograms[0];
            $program2 = $selectedPrograms[1];
        }
    }
    function encryptData($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        $encryptedData = base64_encode($iv . $encrypted);
        return $encryptedData;
    }

    $key = "Adeqa2024"; // Your secret key
    $data = "$institutionValue|$labID|$instrumentID|$reagentID|$program1|$program2";
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
            window.open('form-submission/printSOP.php?data=<?=$encrypted?>', '_blank');
        }


    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
