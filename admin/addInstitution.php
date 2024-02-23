<?php
    require '../admin/topadmin.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
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

        $query = "INSERT INTO institutions (institutionCode, institution, address1, address2, address3, postcode, city, state, country, contactnum, email) 
        VALUES ('$institutionCode', '$institution', '$address1', '$address2', '$address3', '$postcode', '$city', '$state', '$country', '$contactnum', '$email')";
        $result = $conn->query($query);

        if ($result) {
            $msg = "Institution added successfully";

            // Redirect to User.php after successful submission
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
    <title>Add Institution</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Add Institution</h1>
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
                    <label for="institutionCode">Institution Code:</label>
                    <input type="text" name="institutionCode" class="form-control" required>
                    
                    <label for="institution">Institution Name:</label>
                    <input type="text" name="institution" class="form-control" required>
                    
                    <label for="address1">Address 1:</label>
                    <input type="text" name="address1" class="form-control" required>

                    <label for="address2">Address 2:</label>
                    <input type="text" name="address2" class="form-control" required>

                    <label for="address3">Address 3:</label>
                    <input type="text" name="address3" class="form-control" required>

                    <label for="contactnum">Contact No.:</label>
                    <input type="text" name="contactnum" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="city">City:</label>
                    <input type="text" name="city" class="form-control" required>

                    <label for="state">State:</label>
                    <input type="text" name="state" class="form-control" required>

                    <label for="postcode">Postal Code:</label>
                    <input type="text" name="postcode" class="form-control" required>

                    <label for="country">Country:</label>
                    <input type="text" name="country" class="form-control" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
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