<?php require '../admin/topadmin.php'; ?>

<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CatCode'])) {
        // Handling AJAX request to fetch drug types based on the selected CatCode

        $selectedCatCode = $_POST['CatCode'];
        // Debug: Print the selected CatCode to the console
        error_log("Selected CatCode: $selectedCatCode");

        // Fetch drug types for the selected CatCode
        $query = "SELECT DTCode, DTName FROM drugtype WHERE CatCode = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$selectedCatCode]);

        // Build options for DTCode dropdown
        $options = "<option value=''>Select Drug Type</option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= "<option value='{$row['DTCode']}'>{$row['DTName']}</option>";
        }

        // Send options as the response
        echo $options;

        // Terminate the script after sending the response
        exit();
    }

    ?>

    <?php

        $sqlStat = "SELECT * FROM `institutions` WHERE institutionCode = '". $instID ."'";
        $resultStat = $conn->query($sqlStat);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drug Testing</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .column {
            float: left;
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }

        .column label,
        .column input,
        .column select {
            display: block;
            margin-bottom: 10px;
        }

        .column-group {
            display: flex;
            justify-content: space-between;
        }

        .column-group .column {
            width: 48%; /* Adjust as needed */
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .form-box {
            width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .form-box {
            width: 47%;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .submit-container {
            text-align: right;
        }

        .submit-container input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
        } 

    /* Your existing styles for the "Add" button */
    button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 4px;
    }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Drug Testing</h1>
        <form action="drug_testing_action.php" method="post">
            <label for="screening_type">Select Program:</label>
            <select name="screening_type" id="screening_type" onchange="showHideForm(this.value)">
                <option value="" disabled selected>-- Select Program --</option>
                <option value="screening_only">Screening only</option>
                <option value="screening_confirmation">Screening & Confirmation</option>
            </select>
            <br><br>

            <div class="row">
                <div class="form-box column" id="screening_form">
                    <h1> Screening </h1>
                    <div class="column-group">
                        <div class="column">
                            <label for="instrument">Instrument:</label>
                            <?php
                                // Fetch values from the "institutions" table
                                $query = "SELECT * FROM instrument";
                                $result = $conn->query($query);
                                ?>
                                <select name="institutionCode">
                                    <?php
                                    // Check if there are rows in the result set
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row['instrumentCode']; ?>"><?php echo $row['instrumentName']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        // Handle the case when there are no institutions in the table
                                        echo "<option value=''>No institutions available</option>";
                                    }
                                ?>
                        </select>
                        
                        </div>
                        <div class="column">
                        <label for="method">Method:</label>
                        <?php
                                // Fetch values from the "institutions" table
                                $query = "SELECT * FROM method";
                                $result = $conn->query($query);
                                ?>
                                <select name="methodCode">
                                    <?php
                                    // Check if there are rows in the result set
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row['methodCode']; ?>"><?php echo $row['methodName']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        // Handle the case when there are no institutions in the table
                                        echo "<option value=''>No institutions available</option>";
                                    }
                                ?>
                        </select>
                        </div>
                    
                    </div>
                    <div class="column-group">
                        <div class="column">
                        <label for="sample">Sample:</label>
                            <input type="text" name="sample" id="sample" required>
                        </div>
                        <div class="column">
                            <label for="cycle">Cycle:</label>
                            <input type="text" name="cycle" id="cycle" required>
                        </div>
                    </div>

                    <div class="column-group">
                        <div class="column">
                            <label for="opening_date">Opening Date:</label>
                            <input type="date" name="opening_date" id="opening_date" required>
                        </div>
                        <div class="column">
                            <label for="closing_date">Closing Date:</label>
                            <input type="date" name="closing_date" id="closing_date" required>
                        </div>
                    </div>

                    <div id="container" style="display: grid; grid-template-columns: repeat(3, auto); gap: 10px; overflow: auto; max-height: 150px;">
                    <div>
                        <label for="CatCode">Drug Category:</label>
                        <?php
                            // Fetch distinct values from the "drugtype" table for the "CatCode" column
                            $query = "SELECT DISTINCT CatCode FROM drugtype";
                            $result = $conn->query($query);
                        ?>

                        <select name="CatCode" id="CatCode">
                            <?php
                                // Check if there are rows in the result set
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row['CatCode']; ?>"><?php echo $row['CatCode']; ?></option>
                                        <?php
                                    }
                                } else {
                                    // Handle the case when there are no distinct values for CatCode in the table
                                    echo "<option value=''>No Drug Category available</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="DTCode">Drug Type:</label>
                        <select name="DTCode" id="DTCode">
                            <!-- Options will be dynamically populated based on the selected CatCode -->
                        </select>
                    </div>
                    <div>
                        <label for="result">Result:</label>
                        <input type="text" name="result[]" id="result" required>
                    </div>
                </div>
                <button type="button" onclick="addInput('screening')">
                    Add
                </button>
                </div>

                <div class="form-box column" id="confirmation_form" style="margin-left: 50px; display: none;">  
                <h1> Confirmation </h1>                  
                <div class="column-group">
                        <div class="column">
                            <label for="confirmation_instrument">Instrument (Confirmation):</label>
                            <?php
                                // Fetch values from the "institutions" table
                                $query = "SELECT * FROM instrument";
                                $result = $conn->query($query);
                                ?>
                                <select name="institutionCode">
                                    <?php
                                    // Check if there are rows in the result set
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row['instrumentCode']; ?>"><?php echo $row['instrumentName']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        // Handle the case when there are no institutions in the table
                                        echo "<option value=''>No institutions available</option>";
                                    }
                                ?>
                        </select>
                        </div>
                        
                        <div class="column">
                            <label for="confirmation_method">Method (Confirmation):</label>
                            <?php
                                // Fetch values from the "institutions" table
                                $query = "SELECT * FROM method";
                                $result = $conn->query($query);
                                ?>
                                <select name="methodCode">
                                    <?php
                                    // Check if there are rows in the result set
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row['methodCode']; ?>"><?php echo $row['methodName']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        // Handle the case when there are no institutions in the table
                                        echo "<option value=''>No institutions available</option>";
                                    }
                                ?>
                        </select>
                        </div>
                        
                    </div>
                    <div class="column-group">
                        <div class="column">
                                <label for="confirmation_sample">Sample (Confirmation):</label>
                                <input type="text" name="confirmation_sample" id="confirmation_sample" required>
                            </div>
                        <div class="column">
                            <label for="confirmation_cycle">Cycle (Confirmation):</label>
                            <input type="text" name="confirmation_cycle" id="confirmation_cycle" required>
                        </div>
                    </div>
                    <div class="column-group">
                        <div class="column">
                                <label for="confirmation_opening_date">Opening Date:</label>
                                <input type="date" name="confirmation_opening_date" id="confirmation_opening_date" required>
                            </div>
                        <div class="column">
                            <label for="confirmation_closing_date">Closing Date:</label>
                            <input type="date" name="confirmation_closing_date" id="confirmation_closing_date" required>
                        </div>
                    </div>

                    <div id="confirmation_container" style="display: grid; grid-template-columns: repeat(3, auto); gap: 10px; overflow: auto; max-height: 150px;">
                    <div>
                        <label for="drugcategory">Drug Category:</label>
                        <?php
                            // Fetch distinct values from the "drugtype" table for the "CatCode" column
                            $query = "SELECT DISTINCT CatCode FROM drugtype";
                            $result = $conn->query($query);
                        ?>

                        <select name="CatCode" id="CatCode">
                            <?php
                                // Check if there are rows in the result set
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row['CatCode']; ?>"><?php echo $row['CatCode']; ?></option>
                                        <?php
                                    }
                                } else {
                                    // Handle the case when there are no distinct values for CatCode in the table
                                    echo "<option value=''>No Drug Category available</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="drugtype">Drug Type:</label>
                        <?php
                            // Fetch distinct values from the "drugtype" table for the "CatCode" column
                            $query = "SELECT DTCode, DTName FROM drugtype";
                            $result = $conn->query($query);
                        ?>

                        <select name="DTCode" id="DTCode">
                            <?php
                                // Check if there are rows in the result set
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row['DTCode']; ?>"><?php echo $row['DTName']; ?></option>
                                        <?php
                                    }
                                } else {
                                    // Handle the case when there are no distinct values for CatCode in the table
                                    echo "<option value=''>No Drug Category available</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="result">Result:</label>
                        <input type="text" name="result[]" id="result" required>
                    </div>
                </div>
                <button type="button" onclick="addInput('confirmation')">
                    Add
                </button>

                </div>
            </div>
            <br>

            <div class="submit-container">
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>
    <script type="text/javascript">
        function showHideForm(value) {
            if (value == "screening_only") {
                document.getElementById("screening_form").style.display = "block";
                document.getElementById("confirmation_form").style.display = "none";
                document.getElementById("instrument_method_form").style.display = "block";
            } else {
                document.getElementById("screening_form").style.display = "block";
                document.getElementById("confirmation_form").style.display = "block";
                document.getElementById("instrument_method_form").style.display = "block";
            }
        }

        function addInput(formType) {
            var containerId = formType === 'screening' ? 'container' : 'confirmation_container';
            var container = document.getElementById(containerId);

            // Create a new set of divs for drug category, drug type, and result
            var drugCategoryDiv = document.createElement("div");
            var drugTypeDiv = document.createElement("div");
            var resultDiv = document.createElement("div");

            // Create input elements for each div
            var drugCategoryInput = document.createElement("input");
            drugCategoryInput.type = "text";
            drugCategoryInput.name = formType === 'screening' ? "drugcategory[]" : "confirmation_drugcategory[]";
            drugCategoryInput.required = true;
            drugCategoryDiv.appendChild(document.createTextNode("Drug Category: "));
            drugCategoryDiv.appendChild(drugCategoryInput);

            var drugTypeInput = document.createElement("input");
            drugTypeInput.type = "text";
            drugTypeInput.name = formType === 'screening' ? "drugtype[]" : "confirmation_drugtype[]";
            drugTypeInput.required = true;
            drugTypeDiv.appendChild(document.createTextNode("Drug Type: "));
            drugTypeDiv.appendChild(drugTypeInput);

            var resultInput = document.createElement("input");
            resultInput.type = "text";
            resultInput.name = formType === 'screening' ? "result[]" : "confirmation_result[]";
            resultInput.required = true;
            resultDiv.appendChild(document.createTextNode("Result: "));
            resultDiv.appendChild(resultInput);

            // Append the new set of divs to the container
            container.appendChild(drugCategoryDiv);
            container.appendChild(drugTypeDiv);
            container.appendChild(resultDiv);
        }
            // Attach an event listener to the CatCode dropdown
            $(document).ready(function() {
                $('#CatCode').change(function() {
                    // Get the selected CatCode
                    var selectedCatCode = $(this).val();

                    // Fetch corresponding drug types for the selected CatCode using AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'AssignProgram.php',
                        data: {CatCode: selectedCatCode},
                        success: function(response) {
                            // Update the DTCode dropdown with the fetched options
                            $('#DTCode').html(response);
                        }
                    });
                });
            });
        
    </script>
</body>
</html>