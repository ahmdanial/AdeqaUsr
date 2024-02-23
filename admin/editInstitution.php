<?php
require '../admin/topadmin.php';

// Check if user ID is provided in the query parameters
if (!isset($_GET['id'])) {
    // Redirect to Institution.php if no ID is provided
    header("Location: Institution.php");
    exit();
}

// Get the user ID from the query parameters
$id = validate($_GET['id']);

// Retrieve user data from the database based on the ID
$query = "SELECT * FROM institutions WHERE institutionCode = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // Redirect to Institution.php if no user is found with the given ID
    header("Location: Institution.php");
    exit();
}

// Fetch the user data
$institutionData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission for editing user
    $institutionCode = validate($_POST['institutionCode']);
    $institution = validate($_POST['institution']);
    $address1 = validate($_POST['address1']);
    $address2 = validate($_POST['address2']);
    $address3 = validate($_POST['address3']);
    $postcode = validate($_POST['postcode']);
    $city = validate($_POST['city']);
    $state = validate($_POST['state']);
    $country = validate($_POST['country']);
    $contactnum = validate($_POST['contactnum']);
    $email = validate($_POST['email']);

    // Add more input fields as needed

    // Update user data in the database
    $updateQuery = "UPDATE institutions SET institutionCode='$institutionCode', institution='$institution', address1='$address1', address2='$address2', address3='$address3', postcode='$postcode', city='$city', state='$state', country='$country', contactnum='$contactnum', email='$email' WHERE institutionCode = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        $msg = "User updated successfully";

        // Redirect to Institution.php after successful update
        header("Location: Institution.php");
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
    <title>Edit Institution</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Edit Institution</h1>
            </div>
            <!-- You can add more customization or buttons here if needed -->
        </div>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
        <!-- Add your form fields for editing Institution here -->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- First Column -->
                    <label for="institutionCode">Institution Code:</label>
                    <input type="text" name="institutionCode" class="form-control" value="<?php echo $institutionData['institutionCode']; ?>" required>

                    <label for="institution">Institution Name:</label>
                    <input type="text" name="institution" class="form-control" value="<?php echo $institutionData['institution']; ?>" required>
                    
                    <label for="address1">Address 1:</label>
                    <input type="text" name="address1" class="form-control" value="<?php echo $institutionData['address1']; ?>" required>
                    
                    <label for="address2">Address 2:</label>
                    <input type="text" name="address2" class="form-control" value="<?php echo $institutionData['address2']; ?>" required>
                    
                    <label for="address3">Address 3:</label>
                    <input type="text" name="address3" class="form-control" value="<?php echo $institutionData['address3']; ?>" required>

                    <label for="contactnum">Contact No:</label>
                    <input type="phone" name="contactnum" class="form-control" value="<?php echo $institutionData['contactnum']; ?>" required>
                
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="city">City:</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $institutionData['city']; ?>" required>

                    <label for="state">State:</label>
                    <input type="text" name="state" class="form-control" value="<?php echo $institutionData['state']; ?>" required>

                    <label for="postcode">Postal Code:</label>
                    <input type="text" name="postcode" class="form-control" value="<?php echo $institutionData['postcode']; ?>" required>

                    <label for="country">Country:</label>
                    <input type="text" name="country" class="form-control" value="<?php echo $institutionData['country']; ?>" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $institutionData['email']; ?>" required>
                </div>

            </div>
            
            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success mt-3">Save Institution</button>
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
