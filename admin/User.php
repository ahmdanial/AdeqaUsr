<?php
require '../admin/topadmin.php';
?>
    <?php

        if(isset($_GET['delete']))
        { 

        $id= validate($_GET['delete']); 
            if ($instID == '1vendor') {
                $query= "DELETE FROM users WHERE userid = '".$id."'";

            } else {
                $query= "DELETE FROM users WHERE institutionCode = '". $instID ."' and userid = '".$id."'";

            }
             

            $result= $conn->query($query);
            if($result){        
                $msg="Record was deleted successfully";
            }else{
                $msg= $conn->error;
            }           
            
            //header("location:User.php");
                
        }


        function validate($value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            return $value;
            }

        ?>

        <?php
       /* hide 1vendor
        $sqlStat = "SELECT A.*
        FROM users A  WHERE A.institutionCode = '".$instID."' and A.institutionCode <> '1vendor'";
        */

        if ($instID == '1vendor') {
            $sqlStat = "SELECT * FROM `users`";

        } else {
            $sqlStat = "SELECT * FROM `users` WHERE institutionCode = '". $instID ."'";

        }
      
       $resultStat = $conn->query($sqlStat);
          
  
        ?>
<!---?=$sqlStat?--->


        <div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
        <div class="container">
        <div class="row">    
            <div class="col-md-6 text-left">
            <h1>User</h1>
            </div>
            <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" onclick="location.href='../admin/addUser.php';">
                Add User
            </button>
            </div>
        </div>
        </div>
            </h1>
            <br>
            <form action="form-submission/pdel_assignUser.php" method="post">

            <div class="container">
                            
                <table id="userTable" class="table table-light table-striped">
                    <thead>
                    <tr class="table-success">
                        <th>User ID</th>
                        <th>Account Num</th>
                        <th>Username</th> 
                        <th>Full Name</th> 
                        <th>Email</th> 
                        <th>Institution</th> 
                        <th>Designation</th> 
                        <th>Department</th> 
                        <th>Actions</th>               
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($rowData = $resultStat->fetch_object()) {
                    ?>
                    <tr>
                        <td><?= $rowData->userid ?></td>
                        <td><?= $rowData->acctnum ?></td>
                        <td><?= $rowData->username ?></td>
                        <td><?= $rowData->fullname ?></td>
                        <td><?= $rowData->email ?></td>
                        <td><?= $rowData->institutionCode ?></td>
                        <td><?= $rowData->designation ?></td>
                        <td><?= $rowData->department ?></td>
                        <td>
                        <a href="../admin/editUser.php?id=<?php echo $rowData->userid; ?>" data-toggle="tooltip" title="Edit">
                            <img src="../inc/img/edit.webp" width="25%" height="auto" class="d-inline-block align-top">
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="#" onclick="confirmDelete(<?php echo $rowData->userid; ?>)" data-toggle="tooltip" title="Delete">
                        <img src="../inc/img/delete.webp" width="25%" height="auto" class="d-inline-block align-top">
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