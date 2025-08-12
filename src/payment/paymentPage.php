<?php
session_start();
include("../connectDB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['card-num'] = $_POST['card-num'];
    $_SESSION['expiry-date'] = $_POST['expiry-date'];
    $_SESSION['cvv'] = $_POST['cvv'];
    $_SESSION['card-holder-name'] = $_POST['card-holder-name'];

    $total = $_SESSION['totalPrice'];
    $username = $_SESSION['username'];

    $type = $_SESSION['type'];
    $eventName = $_SESSION['eventName'];
    $contactNumber = $_SESSION['contactNumber'];
    $startDate = $_SESSION['startDate'];
    $endDate = $_SESSION['endDate'];
    $startTime = $_SESSION['startTime'];
    $endTime = $_SESSION['endTime'];
    $venue = $_SESSION['venue'];
    $guest = $_SESSION['guest'];
    $theme = $_SESSION['theme'];

    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");

    $sql1 = "INSERT INTO payment (payment_amount, payment_date, payment_time, username) VALUES ($total, '$currentDate', '$currentTime', '$username')";
    $result1 = mysqli_query($conn, $sql1);

    if (!$result1) {
        $_SESSION['DBerror'] = true;
    }

    $stmt = $conn->prepare("INSERT INTO event (event_name, contact_number, start_date, end_date, start_time, end_time, event_venue, event_guest, event_type, event_theme, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $eventName, $contactNumber, $startDate, $endDate, $startTime, $endTime, $venue, $guest, $type, $theme, $username);
    $result2 = $stmt->execute();

    if (!$result2) {
        $_SESSION['DBerror'] = true;
    }

    if ($result1 && $result2) {
        $_SESSION['mail'] = true;
    }

    mysqli_close($conn);
    header("Location: ../memberDashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,
            initial-scale=1.0" />
    <link rel="icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="paymentPage.css" class="css" />
</head>

<body>
    <div class="container">
        <div class="main-content">
            <p class="text"></p>
        </div>

        <div class="centre-content">
            <p class="course">
                Payment Gateway
            </p>
        </div>

        <div class="last-content">
            <div class="pay-now-btn">
                Pay with Netbanking
            </div>
        </div>

        <div class="card-details">
            <p>Pay using Credit or Debit card</p>
            <form method="post">
                <div class="card-number">
                    <label> Card Number </label>
                    <input type="text" name="card-num" class="card-number-field" placeholder="####-####-####" required
                        maxlength="16" />
                </div>
                <br />
                <div class="date-number">
                    <label> Expiry Date </label>
                    <input type="text" name="expiry-date" class="date-number-field" placeholder="DD-MM-YY" required
                        maxlength="11" />
                </div>

                <div class="cvv-number">
                    <label> CVV number </label>
                    <input type="text" name="cvv" class="cvv-number-field" placeholder="xxx" required maxlength="3" />
                </div>
                <div class="nameholder-number">
                    <label> Card Holder name </label>
                    <input type="text" name="card-holder-name" class="card-name-field" placeholder="Enter your Name"
                        required maxlength="30" />
                </div>
                <button type="submit" class="submit-now-btn" onclick="window.open('receipt.php', '_blank')">
                    Submit
                </button>
            </form>
        </div>
    </div>
</body>

</html>