<?php
include("connectDB.php");
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    $_SESSION['alert'] = true;
    header("Location: login.php");
    mysqli_close($conn);
    exit();
}

$type = $_POST['type'];
$eventName = trim($_POST['event-name']);
$contactNumber = trim($_POST['contact-number']);
$startDate = trim($_POST['start-date']);
$endDate = trim($_POST['end-date']);
$startTime = trim($_POST['start-time']);
$endTime = trim($_POST['end-time']);
$venue = trim($_POST['venue']);
$guest = trim($_POST['guest']);

$theme = isset($_POST['event-theme']) ? trim($_POST['event-theme']) : "none";

$doorGift = isset($_POST['door-gift']) ? trim($_POST['door-gift']) : "none";
$liveBand = isset($_POST['hire-live-band']) ? trim($_POST['hire-live-band']) : "none";
$MC = isset($_POST['hire-mc']) ? trim($_POST['hire-mc']) : "none";


$decorations;
if (isset($_POST['decorations']) && is_array($_POST['decorations']) && !empty($_POST['decorations'])) {
    $decorations = $_POST['decorations'];
} else {
    $decorations = [];
}
$audioVisuals;
if (isset($_POST['audio-visual']) && is_array($_POST['audio-visual']) && !empty($_POST['audio-visual'])) {
    $audioVisuals = $_POST['audio-visual'];
} else {
    $audioVisuals = [];
}
$catering;
if (isset($_POST['catering']) && is_array($_POST['catering']) && !empty($_POST['catering'])) {
    $catering = $_POST['catering'];
} else {
    $catering = [];
}


$errors = array();
$valid = true;

if (empty($eventName)) {
    $valid = false;
    $errors[] = "Please enter your event name.";
}

if (empty($contactNumber)) {
    $valid = false;
    $errors[] = "Please enter your contact number.";
}

if (empty($startDate)) {
    $valid = false;
    $errors[] = "Please enter the start date.";
}

if (empty($endDate)) {
    $valid = false;
    $errors[] = "Please enter the end date.";
}

if (empty($startTime)) {
    $valid = false;
    $errors[] = "Please enter the start time.";
}

if (empty($endTime)) {
    $valid = false;
    $errors[] = "Please enter the end time.";
}

if (empty($venue)) {
    $valid = false;
    $errors[] = "Please enter the venue.";
}

if (empty($guest)) {
    $valid = false;
    $errors[] = "Please enter the number of guests.";
}

if (isset($_POST['event-theme'])) {
    if (empty($_POST['event-theme'])) {
        $valid = false;
        $errors[] = "Please select an event theme.";
    }
}

if ($valid) {
    if (!preg_match('/^\d+$/', $contactNumber)) {
        $valid = false;
        $errors[] = "Contact number must only contain digits.";
    }
    if (strlen($contactNumber) < 9 || strlen($contactNumber) > 10) {
        $valid = false;
        $errors[] = "Contact number must be between 9-10 digits.";
    }
    if (!preg_match('/^\d+$/', $guest)) {
        $valid = false;
        $errors[] = "Number of guests must only contain digits.";
    }
    if (strtotime($endDate) < strtotime($startDate)) {
        $valid = false;
        $errors[] = "End date cannot be before start date";
    } elseif (strtotime($endDate) == strtotime($startDate) && strtotime($endTime) <= strtotime($startTime)) {
        $valid = false;
        $errors[] = "End time must be after start time";
    }
}

if ($valid) {
    $_SESSION['type'] = $type;
    $_SESSION['eventName'] = $eventName;
    $_SESSION['contactNumber'] = $contactNumber;
    $_SESSION['startDate'] = $startDate;
    $_SESSION['endDate'] = $endDate;
    $_SESSION['startTime'] = $startTime;
    $_SESSION['endTime'] = $endTime;
    $_SESSION['venue'] = $venue;
    $_SESSION['guest'] = $guest;
    $_SESSION['theme'] = $theme;
    $_SESSION['decorations'] = $decorations;
    $_SESSION['audioVisuals'] = $audioVisuals;
    $_SESSION['catering'] = $catering;
    $_SESSION['doorGift'] = $doorGift;
    $_SESSION['liveBand'] = $liveBand;
    $_SESSION['MC'] = $MC;

    header("Location: TransactionDetails.php");
    mysqli_close($conn);
} else {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo "please book again";
}
mysqli_close($conn);
?>