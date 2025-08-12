<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    // Redirect the admin to the login page if not logged in
    header("Location: ../adminLogin.php");
    exit();
}

include("../connectDB.php");

?>