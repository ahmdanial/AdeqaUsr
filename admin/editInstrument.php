<?php
require '../admin/topadmin.php';

// Check if user ID is provided in the query parameters
if (!isset($_GET['id'])) {
    // Redirect to Instrument.php if no ID is provided
    header("Location: Instrument.php");
    exit();
}

// Get the Instrument ID from the query parameters
$id = validate($_GET['id']);

// Retrieve Instrument data from the database based on the ID
$query = "SELECT * FROM instrument WHERE instrumentCode = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // Redirect to Instrument.php if no Instrument is found with the given ID
    header("Location: Instrument.php");
    exit();
}

// Fetch the Instrument data
$userData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission for editing Instrument
    $instrumentCode = validate($_POST['instrumentCode']);
    $instrumentName = validate($_POST['instrumentName']);

    // Add more input fields as needed

    // Update Instrument data in the database
    $updateQuery = "UPDATE instrument SET instrumentCode='$instrumentCode', instrumentName='$instrumentName' WHERE instrumentCode = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        $msg = "Drug Instrument updated successfully";

        // Redirect to Instrument.php after successful update
        header("Location: Instrument.php");
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
    <title>Edit Instrument</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Edit Instrument</h1>
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
                    <label for="instrumentCode">Instrument Code:</label>
                    <input type="text" name="instrumentCode" class="form-control" value="<?php echo $userData['instrumentCode']; ?>" required>
                    
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="instrumentName">Instrument Name:</label>
                    <input type="text" name="instrumentName" class="form-control" value="<?php echo $userData['instrumentName']; ?>" required>

                </div>

            </div>
            
            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success mt-3">Save Instrument</button>
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
