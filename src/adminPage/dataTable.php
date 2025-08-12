<?php
session_start();

if (isset($_SESSION['success']) && $_SESSION['success']) {
    echo "<script>
    setTimeout(function () {
        alert('Database query successful');
    }, 100);
    </script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['success']) && !$_SESSION['success']) {
    echo "<script>
    setTimeout(function () {
        alert('Database query failed');
    }, 100);
    </script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['insert_status']) && !$_SESSION['insert_status']) {
    echo "<script>
    setTimeout(function () {
        alert('Insertion failed, please make sure you added value for each column');
    }, 100);
    </script>";
    unset($_SESSION['insert_status']);
}
if (isset($_SESSION['available']) && !$_SESSION['available']) {
    echo "<script>
    setTimeout(function () {
        alert('Insertion failed, currently our available service_name are decoration, audio visual rental, door gift, catering, hire live band, hire mc');
    }, 100);
    </script>";
    unset($_SESSION['available']);
}
if (isset($_SESSION['restricted'])) {
    echo "<script>
    setTimeout(function () {
        alert('Admin can only read user table');
    }, 100);
    </script>";
    unset($_SESSION['restricted']);
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
    <link rel="stylesheet" href="admin_page.css" />
    <link rel="stylesheet" href="dataTable.css" />
    <title>Techvent</title>
</head>

<body>
    <?php
    include("admin_navbar.php");
    ?>
    <div id="table-container">
        <h1>Data Table</h1>

        <?php

        if (isset($_SESSION['rows']) && !empty($_SESSION['rows'])) {
            $rows = $_SESSION['rows'];

            // Get the column names from the retrieved row
            $columnNames = array_keys($rows[0]);

            // Display the column names in a table header
            echo "<table class='data-table'>";
            echo "<tr class='table-header'>";
            foreach ($columnNames as $columnName) {
                echo "<th>$columnName</th>";
            }
            echo "</tr>";

            // Display the row data in a table row
            foreach ($rows as $row) {
                echo "<tr class='table-row'>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }

            echo "</table>";

            // Clear the stored row data from the session
            unset($_SESSION['rows']);
        } else {
            echo "No data available.";
        }
        ?>

    </div>
</body>

</html>