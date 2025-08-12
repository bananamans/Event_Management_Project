<?php
$sql = "SELECT * FROM service";

$result = mysqli_query($conn, $sql);
$services = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {

        $service = [
            'service_name' => $row['service_name'],
            'service_type' => $row['service_type'],
            'service_price' => $row['service_price'],
        ];

        $services[] = $service;

    }

} else {
    echo "<script> alert('database query failed'); </script>";

}
?>