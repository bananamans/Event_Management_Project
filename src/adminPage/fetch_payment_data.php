<?php
include("sessionAndDB.php");

// Get the filter value from the AJAX request
$filter = $_POST['filter'];

// Prepare the SQL query with the WHERE clause based on the filter value
$sql = "SELECT * FROM payment WHERE ";

// Add the appropriate condition based on the filter value
if ($filter === "daily") {
    $sql .= "DATE(payment_date) = CURDATE()";
} elseif ($filter === "weekly") {
    $sql .= "WEEK(payment_date) = WEEK(CURDATE())";
} elseif ($filter === "monthly") {
    $sql .= "MONTH(payment_date) = MONTH(CURDATE())";
}

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    echo "<script>
        alert('Database query failed');
    </script>";
} else {
    // Fetch the payment data and store it in an array
    $paymentData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $paymentData[] = $row;
    }

    // Return the payment data as JSON
    echo json_encode($paymentData);
}
mysqli_close($conn);
?>