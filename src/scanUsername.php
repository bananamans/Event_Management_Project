<?php

include("connectDB.php");

$username = $_POST['username'];

$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  // Username is already taken
  $response = array('status' => 'taken');
} else {
  // Username is available
  $response = array('status' => 'available');
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($conn);
?>