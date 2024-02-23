<?php
require '../admin/topadmin.php';

// Check if user ID is provided in the query parameters
if (!isset($_GET['id'])) {
    // Redirect to Drug Categroy.php if no ID is provided
    header("Location: DrugCategory.php");
    exit();
}

// Get the DrugCategory ID from the query parameters
$id = validate($_GET['id']);

// Retrieve DrugCategory data from the database based on the ID
$query = "SELECT * FROM DrugCategory WHERE CatCode = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // Redirect to DrugCategory.php if no DrugCategory is found with the given ID
    header("Location: DrugCategory.php");
    exit();
}

// Fetch the DrugCategory data
$userData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission for editing DrugCategory
    $CatCode = validate($_POST['CatCode']);
    $CatName = validate($_POST['CatName']);

    // Add more input fields as needed

    // Update DrugCategory data in the database
    $updateQuery = "UPDATE drugcategory SET CatCode='$CatCode', CatName='$CatName' WHERE CatCode = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        $msg = "Drug Category updated successfully";

        // Redirect to DrugCategory.php after successful update
        header("Location: DrugCategory.php");
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
    <title>Edit Drug Categroy</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Edit Drug Categroy</h1>
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
                    <label for="CatCode">Category Code:</label>
                    <input type="text" name="CatCode" class="form-control" value="<?php echo $userData['CatCode']; ?>" required>
                    
                </div>
                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="CatName">Category Name:</label>
                    <input type="text" name="CatName" class="form-control" value="<?php echo $userData['CatName']; ?>" required>

                </div>

            </div>
            
            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success mt-3">Save Category</button>
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
