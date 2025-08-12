<?php

if (!isset($_SESSION['type'])) {
    //Redirect user if event has not been booked
    header("Location: memberDashboard.php");
    exit();
}
?>