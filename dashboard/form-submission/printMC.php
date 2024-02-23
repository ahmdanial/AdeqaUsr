<?php

require '../../inc/conn.php';

$sqlProgram = "SELECT * FROM programs WHERE id = '$program'";
$rowProgram = $conn->query($sqlProgram)->fetch_object();

$sqlTest = "SELECT E.testcode, A.unit, C.methodname, D.testname, B.ID, D.expected_result FROM assign_Test B, Units A, Methods C, Tests D, 
            subassigntest E WHERE D.Method_id = C.id and D.unit_id = A.id and E.Testcode = D.testcode and B.id = E.assign_test_id AND B.prog_id = '$program'
            AND B.reagent_id = '$reagentID' AND B.lab_id = '$labID' AND B.instrument_id = '$instrumentID' and D.reagent_id =B.Reagent_ID AND D.testcode = '$testcode'";
echo "<br>";
echo $sqlTest;
$resultTests = $conn->query($sqlTest);
$rowTests = $resultTests->fetch_object();

$totalNegative = 0;
$totalEquivocal = 0;
$totalPositive = 0;

$sqlCount = "SELECT (SELECT COUNT(*) FROM entryresults ER1 WHERE ER1.assignTestID = ER.assignTestID AND ER.testcode = ER1.testcode 
             AND ER1.result_2 = 'NEGATIVE') AS NEGATIVE, (SELECT COUNT(*) FROM entryresults ER1 WHERE ER1.assignTestID = ER.assignTestID 
             AND ER.testcode = ER1.testcode AND ER1.result_2 = 'EQUIVOCAL') AS EQUIVOCAL, (SELECT COUNT(*) FROM entryresults ER1 
             WHERE ER1.assignTestID = ER.assignTestID AND ER.testcode = ER1.testcode AND ER1.result_2 = 'POSITIVE') AS POSITIVE 
             FROM entryresults ER, subassigntest SAT, assign_Test ATS, reagents R WHERE ER.Assigntestid = SAT.assign_test_id AND 
             SAT.assign_test_id = ATS.id AND ER.testcode = SAT.testcode AND ATS.prog_id = '$program' AND R.id = ATS.reagent_id AND ER.testcode='$testcode';";
$resultCount = $conn->query($sqlCount);
while($rowCount = $resultCount->fetch_object()){
    $totalNegative = $totalNegative + $rowCount->NEGATIVE;
    $totalEquivocal = $totalEquivocal + $rowCount->EQUIVOCAL;
    $totalPositive = $totalPositive + $rowCount->POSITIVE;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Page</title>
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
            <div style="display: flex; justify-content: space-between;">
                <h4>Method Comparison - <?=$rowTests->testname?>: <?=$rowTests->methodname?></h4>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <td class="col-2">&emsp;</td>
                    <td colspan="3" class="text-center" style="background-color: #242865; color: white;">Sample: <?=$rowProgram->programname?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Reagent</th>
                    <th>Negative</th>
                    <th>Equivocal</th>
                    <th>Positive</th>
                </tr>
                <tr>
                    <td>All Result</td>
                    <td>
                        <?php
                        if($totalNegative == 0){
                            $totalNegative = 4;
                        }else{
                            $totalNegative = $totalNegative + 4;
                        }

                        echo $totalNegative;
                        ?>
                    </td>
                    <td>
                        <?php
                        if($totalEquivocal == 0){
                            $totalEquivocal = 3;
                        }else{
                            $totalEquivocal = $totalEquivocal + 3;
                        }

                        echo $totalEquivocal;
                        ?>
                    </td>
                    <td>
                        <?php
                        if($totalPositive == 0){
                            $totalPositive = 12;
                        }else{
                            $totalPositive = $totalPositive + 12;
                        }

                        echo $totalPositive;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Abbot</td>
                    <td>&nbsp;</td>
                    <td>2</td>
                    <td>5</td>
                </tr>
                <?php

                $sqlReagent = "SELECT R.reagent, ATS.reagent_id, ER.Assigntestid, ER.testcode, ER.result_2, ATS.lab_id, ATS.prog_id,  
                               (SELECT COUNT(*) FROM entryresults ER1 WHERE ER1.assignTestID = ER.assignTestID AND ER.testcode = ER1.testcode 
                               AND ER1.result_2 = 'NEGATIVE') AS NEGATIVE, (SELECT COUNT(*) FROM entryresults ER1 WHERE 
                               ER1.assignTestID = ER.assignTestID AND ER.testcode = ER1.testcode AND ER1.result_2 = 'EQUIVOCAL') AS EQUIVOCAL, 
                               (SELECT COUNT(*) FROM entryresults ER1 WHERE ER1.assignTestID = ER.assignTestID AND ER.testcode = ER1.testcode 
                               AND ER1.result_2 = 'POSITIVE') AS POSITIVE FROM entryresults ER, subassigntest SAT, assign_Test ATS, reagents R 
                               WHERE ER.Assigntestid = SAT.assign_test_id AND SAT.assign_test_id = ATS.id AND ER.testcode = SAT.testcode 
                               AND ATS.prog_id = '1' AND R.id = ATS.reagent_id AND ER.testcode='CNB';";
                #$sqlReagent = "SELECT * FROM reagents WHERE reagent != 'Other' ORDER BY reagent ASC";
                $resultsReagent = $conn->query($sqlReagent);
                while($rowReagent = $resultsReagent->fetch_object()){
                    if($rowReagent->NEGATIVE == 0){
                        $negative = "";
                    }else{
                        $negative = $rowReagent->NEGATIVE;
                    }

                    if($rowReagent->EQUIVOCAL == 0){
                        $equivocal = "";
                    }else{
                        $equivocal = $rowReagent->EQUIVOCAL;
                    }

                    if($rowReagent->POSITIVE == 0){
                        $positive = "";
                    }else{
                        $positive = $rowReagent->POSITIVE;
                    }
                ?>
                <tr>
                    <td><?=$rowReagent->reagent?></td>
                    <td><?=$negative?></td>
                    <td><?=$equivocal?></td>
                    <td><?=$positive?></td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>Alere</td>
                    <td>3</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Clinitest hCG</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>Biotest hCG</td>
                    <td>1</td>
                    <td>1</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
