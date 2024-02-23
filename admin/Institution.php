<?php
require '../admin/topadmin.php';
?>
<?php

      if(isset($_GET['delete']))
      { 
         
         $id= validate($_GET['delete']);  
         $query= "DELETE FROM institutions WHERE institutionCode = '". $instID ."' and userid = '".$id."'";

         $result= $conn->query($query);
         if($result){        
            $msg="Record was deleted successfully";
         }else{
            $msg= $conn->error;
         }           
         
         header("location:Institution.php");
               
      }

      function validate($value) {
         $value = trim($value);
         $value = stripslashes($value);
         $value = htmlspecialchars($value);
         return $value;
         }

      ?>

      <?php

        if ($instID == '1vendor') {
            $sqlStat = "SELECT * FROM `institutions`";

        } else {
            $sqlStat = "SELECT * FROM `institutions` WHERE institutionCode = '". $instID ."'";

        }
      $resultStat = $conn->query($sqlStat);

      ?>

<div style="width: 90%; margin-top: 2%;" class="container-fluid">
    <div class="container">
        <div class="row">    
            <div class="col-md-6 text-left">
            <h1>Institution</h1>
            </div>
            <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" onclick="location.href='../admin/addInstitution.php';">
                Add Institution
            </button>
            </div>
        </div>
        </div>
            </h1>
            <br>
            <form action="form-submission/pdel_Institution.php" method="post">

            <div class="container mx-3">
                            
            <table id="userTable" class="table table-light table-striped">
                  <thead>
                  <tr class="table-success">
                     <th>Institution Code</th>
                     <th>Institution Name</th>
                     <th>Address 1</th>
                     <th>Address 2</th>
                     <th>Address 3</th>
                     <th>City</th> 
                     <th>State</th>               
                     <th>Postal Code</th>               
                     <th>Country</th>               
                     <th>Contact No.</th> 
                     <th>Email</th> 
                     <th>Actions</th>              
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                     while ($rowData = $resultStat->fetch_object()) {
                  ?>
                  <tr>
                     <td><?= $rowData->institutionCode ?></td>
                     <td><?= $rowData->institution ?></td>
                     <td><?= $rowData->address1 ?></td>
                     <td><?= $rowData->address2 ?></td>
                     <td><?= $rowData->address3 ?></td>
                     <td><?= $rowData->city ?></td>
                     <td><?= $rowData->state ?></td>
                     <td><?= $rowData->postcode ?></td>
                     <td><?= $rowData->country ?></td>
                     <td><?= $rowData->contactnum ?></td>
                     <td><?= $rowData->email ?></td>
                     <td>
                     <a href="../admin/editInstitution.php?id=<?php echo $rowData->institutionCode; ?>" data-toggle="tooltip" title="Edit">
                     <img src="../inc/img/edit.webp" width="30%" height="auto" class="d-inline-block align-top" onclick="edit()">
                     </a>
                     &nbsp;&nbsp;&nbsp;
                     <a href="#" onclick="confirmDelete(<?php echo $rowData->id; ?>)" data-toggle="tooltip" title="Delete">
                     <img src="../inc/img/delete.webp" width="30%" height="auto" class="d-inline-block align-top">
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

                function confirmDelete(userid) {
                    if (confirm('Are you sure you want to delete this record?')) {
                        window.location.href = 'User.php?delete=' + userid;
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