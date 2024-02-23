<?php
require '../admin/topadmin.php';
?>
    <?php
 
 if (isset($_GET['delete'])) {
    $id = validate($_GET['delete']);

    try {
        // Attempt to delete the record from instrument
        $query = "DELETE FROM instrument WHERE instrumentCode = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id); // Assuming instrumentCode is a string, use "s" for string, "i" for integer
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $msg = "Record was deleted successfully";
        } else {
            $msg = "No records deleted. Record not found or there are related records.";
        }

        $stmt->close();
        } catch (mysqli_sql_exception $e) {
            // Catch any SQL exceptions (e.g., foreign key constraint violation)
            $msg = "Error: " . $e->getMessage();
        }

        // Display the message using JavaScript in a popup box
        echo '<script>alert("' . $msg . '");</script>';

        // Redirect back to the previous page after displaying the message
        echo '<script>window.location.href = document.referrer;</script>';
    }

        function validate($value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            return $value;
            }

        ?>

    <?php
      $sqlStat = "SELECT * FROM instrument";
      $resultStat = $conn->query($sqlStat);

      ?>
<!---?=$sqlStat?--->


        <div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
        <div class="container">
        <div class="row">    
            <div class="col-md-6 text-left">
            <h1>Instrument</h1>
            </div>
            <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" onclick="location.href='../admin/addInstrument.php';">
                Add Instrument
            </button>
            </div>
        </div>
        </div>
            </h1>
            <br>
            <form action="form-submission/pdel_Instrument.php" method="post">

            <div class="container">
                            
                <table id="userTable" class="table table-light table-striped">
                    <thead>
                    <tr class="table-success">
                        <th>Instrument Code</th>
                        <th>Instrument Name</th>  
                        <th>Action</th>          
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($rowData = $resultStat->fetch_object()) {
                    ?>
                    <tr>
                        <td>
                            <?= $rowData->instrumentCode ?>
                    </td>
                        <td><?= $rowData->instrumentName ?></td>
                        <td>
                        <a href="../admin/editInstrument.php?id=<?php echo $rowData->instrumentCode; ?>" data-toggle="tooltip" title="Edit">
                            <img src="../inc/img/edit.webp" width="8%" height="auto" class="d-inline-block align-top">
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="#" onclick="confirmDelete('<?php echo $rowData->instrumentCode; ?>')" data-toggle="tooltip" title="Delete">
                            <img src="../inc/img/delete.webp" width="8%" height="auto" class="d-inline-block align-top">
                        </a>
 
                    
                        </td>
                    </tr>
                    <?php
                        }
                    ?>          
                    </tbody>
                </table>
            </div>
        </form>
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
                $(document).ready(function() {
                    $('#userTable').DataTable();
                });

                function confirmDelete(instrumentCode) {
                    if (confirm('Are you sure you want to delete this record?')) {
                        window.location.href = 'Instrument.php?delete=' + instrumentCode;
                    }
                }
                
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

            </script>

</body>
</html>