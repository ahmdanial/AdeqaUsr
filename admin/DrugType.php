<?php
require '../admin/topadmin.php';
?>
    <?php
 
        if (isset($_GET['delete']) || isset($_GET['dtcode'])) {
            $id = validate($_GET['delete']);
            $dtcode = validate($_GET['dtcode']);

            $query = "DELETE FROM drugtype WHERE CatCode = ? AND DTCode = ?"; // Adjust the query to delete based on CatCode alone
    
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $id, $dtcode); // Assuming both CatCode and DTCode are strings
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $msg = "Record was deleted successfully";
            } else {
                $msg = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }

        function validate($value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            return $value;
            }

        ?>

    <?php
      $sqlStat = "SELECT * FROM drugtype";
      $resultStat = $conn->query($sqlStat);

      ?>
<!---?=$sqlStat?--->


        <div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
        <div class="container">
        <div class="row">    
            <div class="col-md-6 text-left">
            <h1>Drug Type</h1>
            </div>
            <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" onclick="location.href='../admin/addDrugType.php';">
                Add Type
            </button>
            </div>
        </div>
        </div>
            </h1>
            <br>
            <form action="form-submission/pdel_DrugType.php" method="post">

            <div class="container">
                            
                <table id="userTable" class="table table-light table-striped" data-page-length='50'>
                    <thead>
                    <tr class="table-success">
                        <th>Category Code</th>
                        <th>Drug Code</th>  
                        <th>Drug Name</th> 
                        <th>Level of Detection</th> 
                        <th>Action</th>          
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($rowData = $resultStat->fetch_object()) {
                    ?>
                    <tr>
                        <td>
                            <?= $rowData->CatCode ?>
                        </td>
                        <td>
                            <?= $rowData->DTCode ?>
                        </td>
                        <td>
                            <?= $rowData->DTName ?>
                        </td>
                        <td>
                            <?= $rowData->LOD ?>
                        </td>
                        <td>
                        <a href="../admin/editDrugType.php?id=<?php echo $rowData->CatCode; ?>&dtcode=<?php echo $rowData->DTCode; ?>" data-toggle="tooltip" title="Edit">
                            <img src="../inc/img/edit.webp" width="12%" height="auto" class="d-inline-block align-top">
                        </a>

                        &nbsp;&nbsp;&nbsp;
                        <a href="#" onclick="confirmDelete('<?php echo $rowData->CatCode; ?>', '<?php echo $rowData->DTCode; ?>')" data-toggle="tooltip" title="Delete">
                            <img src="../inc/img/delete.webp" width="12%" height="auto" class="d-inline-block align-top">
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

                function confirmDelete(id, dtcode) {
                if (confirm('Are you sure you want to delete this record?')) {
                    window.location.href = 'DrugType.php?delete=' + id + '&dtcode=' + dtcode;
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