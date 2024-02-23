<?php
require '../admin/topadmin.php';

// Check if user ID is provided in the query parameters
if (!isset($_GET['id'])) {
    // Redirect to User.php if no ID is provided
    header("Location: User.php");
    exit();
}

// Get the user ID from the query parameters
$id = validate($_GET['id']);

// Retrieve user data from the database based on the ID
$query = "SELECT * FROM users WHERE userid = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // Redirect to User.php if no user is found with the given ID
    header("Location: User.php");
    exit();
}

// Fetch the user data
$userData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission for editing user
    $username = validate($_POST['username']);
    $fullname = validate($_POST['fullname']);
    $email = validate($_POST['email']);
    $acctnum = validate($_POST['acctnum']);
    $institutionCode = validate($_POST['institutionCode']);
    $designation = validate($_POST['designation']);
    $department = validate($_POST['department']);
    $roles = validate($_POST['roles']);

    // Add more input fields as needed

    // Update user data in the database
    $updateQuery = "UPDATE users SET username='$username', fullname='$fullname', email='$email', acctnum='$acctnum', institutionCode='$institutionCode', designation='$designation', department='$department', roles='$roles' WHERE userid = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        $msg = "User updated successfully";

        // Redirect to User.php after successful update
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
    <title>Edit User</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Edit User</h1>
            </div>
            <!-- You can add more customization or buttons here if needed -->
        </div>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
        <!-- Add your form fields for editing a user here -->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- First Column -->
                    <label for="acctnum">Account Num:</label>
                    <input type="text" name="acctnum" class="form-control" value="<?php echo $userData['acctnum']; ?>" required>
                    
                    <?php
                    if ($instID == '1vendor') {
                        ?>
                        <label for="institutionCode">Institution:</label>
                        <?php
                        // Fetch values from the "institutions" table
                        $query = "SELECT institutionCode, institution FROM institutions";
                        $result = $conn->query($query);
                        ?>
                        <select name="institutionCode" class="form-control">
                            <?php
                            // Check if there are rows in the result set
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['institutionCode']; ?>"><?php echo $row['institution']; ?></option>
                                    <?php
                                }
                            } else {
                                // Handle the case when there are no institutions in the table
                                echo "<option value=''>No institutions available</option>";
                            }
                            ?>
                        </select>
                        <?php
                    }
                            else { ?>
                        <input type="hidden" name="institutionCode" class="form-control" value="<?php echo $instID; ?>">
                    <?php }
                    ?>

                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $userData['username']; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $userData['email']; ?>" required>
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="fullname">Fullname:</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo $userData['fullname']; ?>" required>

                    <label for="designation">Designation:</label>
                    <input type="text" name="designation" class="form-control" value="<?php echo $userData['designation']; ?>" required>

                    <label for="department">Department:</label>
                    <input type="text" name="department" class="form-control" value="<?php echo $userData['department']; ?>" required>

                    <label for="roles">Roles:</label>
                    <select name="roles" class="form-control" required>
                        <option value="user" <?php echo ($userData['roles'] == 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($userData['roles'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

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
