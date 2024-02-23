<?php
    require '../admin/topadmin.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
        $username = validate($_POST['username']);
        $fullname = validate($_POST['fullname']);
        $email = validate($_POST['email']);
        $acctnum = validate($_POST['acctnum']);
        $institutionCode = validate($_POST['institutionCode']);
        $designation = validate($_POST['designation']);
        $department = validate($_POST['department']);
        $roles = validate($_POST['roles']);
        $password = password_hash(validate($_POST['password']), PASSWORD_DEFAULT);

        // Add more input fields as needed

        $query = "INSERT INTO users (username, fullname, email, acctnum, institutionCode, designation, department, roles, password) 
        VALUES ('$username', '$fullname', '$email', '$acctnum', '$institutionCode', '$designation', '$department', '$roles', '$password')";
        $result = $conn->query($query);

        if ($result) {
            $msg = "User added successfully";

            // Redirect to User.php after successful submission
            header("Location: User.php");
            exit(); // Ensure no further code execution after the header redirect
        } else {
            $msg = $conn->error;
        }
    }

    function validate($value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Add User</h1>
            </div>
            <!-- You can add more customization or buttons here if needed -->
        </div>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- Add your form fields for adding a user here -->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- First Column -->
                    <label for="acctnum">Account Num:</label>
                    <input type="text" name="acctnum" class="form-control" required>
                    
                    <label for="institutionCode">Institution:</label>
                    <input type="text" name="institutionCode" class="form-control" required>

                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="fullname">Fullname:</label>
                    <input type="text" name="fullname" class="form-control" required>

                    <label for="designation">Designation:</label>
                    <input type="text" name="designation" class="form-control" required>

                    <label for="department">Department:</label>
                    <input type="text" name="department" class="form-control" required>

                    <label for="roles">Roles:</label>
                    <select name="roles" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <!-- Third Column -->
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                    </select>
            </div>
            
            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success mt-3">Save User</button>
        </div>
    </form>

    <?php
    // Display success or error message if applicable
    if (isset($msg)) {
        echo '<div class="container mt-3">' . $msg . '</div>';
    }
    ?>

</div>

<!-- Include necessary Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>