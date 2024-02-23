<?php
if (isset($_GET['program']) && is_array($_GET['program'])) {
    $selectedPrograms = $_GET['program'];

    // Check if at least two programs were selected
    if (count($selectedPrograms) >= 2) {
        // Save the first selected program as $program1
        $program1 = $selectedPrograms[0];

        // Save the second selected program as $program2
        $program2 = $selectedPrograms[1];

        // Output the values of $program1 and $program2
        echo "First selected program: $program1<br>";
        echo "Second selected program: $program2<br>";

        // You can perform further processing with $program1 and $program2 here
    } else {
        // Output a message indicating that at least two programs need to be selected
        echo "Please select at least two programs.";
    }
} else {
    // Output a message indicating that no programs were selected
    echo "No programs selected.";
}
?>
