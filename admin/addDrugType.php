<?php
    require '../admin/topadmin.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
        $CatCode = validate($_POST['CatCode']);
        $DTCode = validate($_POST['DTCode']);
        $DTName = validate($_POST['DTName']);
        $LOD = validate($_POST['LOD']);
        
        // Add more input fields as needed

        $query = "INSERT INTO drugtype (CatCode, DTCode, DTName, LOD) 
        VALUES ('$CatCode', '$DTCode', '$DTName', '$LOD')";
        $result = $conn->query($query);

        if ($result) {
            $msg = "User added successfully";

            // Redirect to User.php after successful submission
            header("Location: DrugType.php");
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
    <title>Add Drug Type</title>
    <!-- Include necessary CSS and Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div style="width: 90%; margin-top: 2%; margin-left: auto;" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Add Drug Type</h1>
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

                        <label for="institutionCode">Drug Category:</label>
                        <?php
                        // Fetch values from the "institutions" table
                        $query = "SELECT CatCode, CatName FROM drugcategory";
                        $result = $conn->query($query);
                        ?>
                        <select name="CatCode" class="form-control">
                            <?php
                            // Check if there are rows in the result set
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['CatCode']; ?>"><?php echo $row['CatName']; ?></option>
                                    <?php
                                }
                            } else {
                                // Handle the case when there are no drug category in the table
                                echo "<option value=''>No drug category available</option>";
                            }
                            ?>
                        </select>
                <br>
                    <label for="DTCode">Drug Code:</label>
                    <input type="text" name="DTCode" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <!-- Second Column -->
                    <label for="DTName">Drug Name:</label>
                    <input type="text" name="DTName" class="form-control" required>
                <br>
                    <label for="LOD">Level of Detection:</label>
                    <select name="LOD" class="form-control">
                        <option value="SCREENING">SCREENING</option>
                        <option value="CONFIRMATION">CONFIRMATION</option>
                    </select>
                </div>
            </div>
            
            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success mt-3">Save Type</button>
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