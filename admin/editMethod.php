<?php
require '../admin/topadmin.php';

// Check if user ID is provided in the query parameters
if (!isset($_GET['id'])) {
    // Redirect to Method.php if no ID is provided
    header("Location: Method.php");
    exit();
}

// Get the Method ID from the query parameters
$id = validate($_GET['id']);

// Retrieve Method data from the database based on the ID
$query = "SELECT * FROM method WHERE methodCode = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // Redirect to Method.php if no Method is found with the given ID
    header("Location: Method.php");
    exit();
}

// Fetch the Method data
$userData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission for editing Method
    $methodCode = validate($_POST['methodCode']);
    $methodName = validate($_POST['methodName']);

    // Add more input fields as needed

    // Update Method data in the database
    $updateQuery = "UPDATE method SET methodCode='$methodCode', methodName='$methodName' WHERE methodCode = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        $msg = "Drug Method updated successfully";

        // Redirect to Method.php after successful update
        header("Location: Method.php");
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
    <title>Edit Method</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Edit Method</h1>
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
                    <label for="methodCode">Method Code:</label>
                    <input type="text" name="methodCode" class="form-control" value="<?php echo $userData['methodCode']; ?>" required>
                    
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="methodName">Method Name:</label>
                    <input type="text" name="methodName" class="form-control" value="<?php echo $userData['methodName']; ?>" required>

                </div>

            </div>
            
            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success mt-3">Save Method</button>
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
