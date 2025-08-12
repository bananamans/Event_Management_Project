<?php
include("check_login.php");
include("connectDB.php");

if (isset($_SESSION['DBerror']) && $_SESSION['DBerror']) {
    echo "<script>alert('Database connection failed, please try again'); </script>";
    unset($_SESSION['DBerror']);
}

if (isset($_SESSION['mail']) && $_SESSION['mail']) {
    include("sendmail.php");
    unset($_SESSION['mail']);
}

$username = $_SESSION['username'];

$query = "SELECT * FROM event WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    mysqli_close($conn);
    $_SESSION['DBerror'] = true;
    header("Location: memberDashboard.php");
    exit();
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="memberDashboard.css" />
    <title>Techvent</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>
    <div class="dashboard">
        <h1>Welcome,
            <?php echo $username; ?>!
        </h1>
        <h2>Let's take a look at your events</h2>
        <div id="showEvent">

            <?php
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Event ID</th>";
                echo "<th>Event Name</th>";
                echo "<th>Contact Number</th>";
                echo "<th>Start Date</th>";
                echo "<th>End Date</th>";
                echo "<th>Start Time</th>";
                echo "<th>End Time</th>";
                echo "<th>Event Venue</th>";
                echo "<th>Event Guest</th>";
                echo "<th>Event Type</th>";
                echo "<th>Event Theme</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['event_id'] . "</td>";
                    echo "<td>" . $row['event_name'] . "</td>";
                    echo "<td>" . $row['contact_number'] . "</td>";
                    echo "<td>" . $row['start_date'] . "</td>";
                    echo "<td>" . $row['end_date'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "<td>" . $row['event_venue'] . "</td>";
                    echo "<td>" . $row['event_guest'] . "</td>";
                    if ($row['event_type'] == 'privateEvent') {
                        echo "<td> private event </td>";
                    } else {
                        echo "<td>" . $row['event_type'] . "</td>";
                    }
                    if ($row['event_type'] == 'privateEvent' && $row['event_theme'] == "annual-dinner") {
                        echo "<td> annual dinner </td>";
                    } elseif ($row['event_type'] == 'privateEvent' && $row['event_theme'] == "birthday-party") {
                        echo "<td> birthday party </td>";
                    } elseif ($row['event_type'] == 'privateEvent') {
                        echo "<td>" . $row['event_theme'] . "</td>";
                    } else {
                        echo "<td></td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<h4>No events booked</h4>";
            }
            ?>

        </div>
    </div>
</body>

</html>