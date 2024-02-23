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
            <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start;">
                    <img src="../inc/img/alfablack.jpeg" style="width: 10%;">
                    <label style="margin-top: 0.3%; margin-left: 10px;"><b>Alfa Diagnostik Sdn Bhd<br>Nombor 36, Jalan PJU 1A/13 Taman Perindustrian Jaya,<br> Ara Damansara,<br> 47301 Petaling Jaya, Selangor</b></label>
                </div>
                <img src="../inc/img/adeeqablack.png" style="width: 10%;">
            </div>
            <br><br>
            <br>
            <div style="display: flex; justify-content: space-between; margin-top: -2%">
                <label style="font-size: 260%; font-weight: bold">Summary of Performance</label>
                <label style="font-size: 120%; margin-top: 1%"><b>Report Issue Date: 28 July 2022</b></label>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="11" style="background-color: #242865; color: white"><h5>Performance Assessment</h5></th>
                </tr>
                <tr>
                    <td class="col-2">&emsp;</td>
                    <td colspan="5" class="text-center" style="background-color: #242865; color: white;">Sample: CP-UP-22-07</td>
                    <td colspan="5" class="text-center" style="background-color: #242865; color: white; border-left: 2px solid white;">Sample: CP-UP-22-08</td>
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
                    <th>Your Result</th>
                    <th>Expected Result</th>
                    <th>Review</th>
                    <th>Z-Score</th>
                    <th>APS</th>
                </tr>
                <tr>
                    <td>Human chorionic gonadotrophin:<br>Qualitative</td>
                    <td>Positive</td>
                    <td>Positive</td>
                    <td>Not Applicable</td>
                    <td></td>
                    <td></td>
                    <td>Negative</td>
                    <td>Positive</td>
                    <td>Not Applicable</td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <br>
            <div style="background-color: #ececec; padding: 0.3%">
                <h5>Overall Performance</h5><br>
                <label>All samples were not assessed in this instance. Please refer to the commentary.</label>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
