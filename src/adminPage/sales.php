<?php
include("sessionAndDB.php");

$sql = "SELECT * FROM payment";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    $_SESSION['payments'] = $rows;
    mysqli_close($conn);
} elseif ($result) {
    $_SESSION['payments'] = 1;
} else {
    $_SESSION['payments'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="sales.css" />

    <title>Techvent</title>
</head>

<body>
    <?php
    include("admin_navbar.php");
    ?>
    <div class="FormCard">
        <h1>Transactions summary</h1>
        <div class="filters">
            <label for="filter">Filter By</label><br>
            <select id="filter">
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        <div class="summary-container">
            <!-- Summary will be displayed here -->
            <table id="summary-table" class="display">
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>
            <div></div>
        </div>

        <h2>Generate report for transactions in the past 4 month</h2>
        <button id="generateReport-button" onclick="window.open('report.php', '_blank')">Generate report</button>
    </div>
    <script src="sales.js"></script>
</body>

</html>