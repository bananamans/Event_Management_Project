<?php
include("sessionAndDB.php");

if (isset($_POST['operation'])) {
    $operation = trim($_POST['operation']);
    $table = trim($_POST['table']);
    $rowId = trim($_POST['row_id']);
    $attribute = trim($_POST['attribute']);
    $value = trim($_POST['value']);

    $sql;
    $result = false;

    if ($operation == "insert") {

        if ($table == 'user') {
            $_SESSION['restricted'] = true;
            mysqli_close($conn);
            header("Location: dataTable.php");
            exit();
        }

        // Get the number of columns in the table
        $sqlColumns = "SHOW COLUMNS FROM $table";
        $resultColumns = mysqli_query($conn, $sqlColumns);
        $numColumns = mysqli_num_rows($resultColumns);

        // Split the input values by comma
        $values = explode(",", $value);
        $values = array_map('trim', $values);

        // Trim each value and check if the count matches the number of columns
        if (count($values) !== $numColumns - 1) {
            $_SESSION['insert_status'] = false;
            mysqli_close($conn);
            header("Location: dataTable.php");
            exit();
        }

        // Escape and quote each value for the query
        $escapedValues = array_map(function ($v) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, trim($v)) . "'";
        }, $values);

        //check whether inserted service is available for our business
        if ($table == 'service' && $operation == 'insert') {
            $available_services = array('decoration', 'audio visual rental', 'door gift', 'catering', 'hire live band', 'hire mc');
            $inputService = str_replace("'", "", $escapedValues[0]);
            if (!in_array($inputService, $available_services)) {
                $_SESSION['available'] = false;
                mysqli_close($conn);
                header("Location: dataTable.php");
                exit();
            }
        }

        // Join the escaped values
        $valueString = implode(",", $escapedValues);

        $sql = "INSERT INTO service (service_name, service_type, service_price) VALUES ($valueString)";
        $result = mysqli_query($conn, $sql);

    } elseif ($operation == "read") {
        $sql = "SELECT * FROM $table";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $rows = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }

            $_SESSION['rows'] = $rows;
            mysqli_close($conn);
            header("Location: dataTable.php");
            exit();
        }
    } elseif ($operation == "update") {
        if ($table == 'user') {
            $_SESSION['restricted'] = true;
            mysqli_close($conn);
            header("Location: dataTable.php");
            exit();
        }

        $sql = "UPDATE $table SET $attribute='$value' WHERE id='$rowId' ";

        //in case admin update username, get old username first, for updating png name
        $username;
        if ($table == 'user' && $attribute == 'username') {
            //get username first
            $sql1 = "SELECT username FROM user WHERE id='$rowId'";
            $result1 = mysqli_query($conn, $sql1);

            if ($result1 && mysqli_num_rows($result1) > 0) {
                $row = mysqli_fetch_assoc($result1);
                $username = $row['username'];
            } else {
                $username = "";
            }

            mysqli_free_result($result1);
        }

        $result = mysqli_query($conn, $sql);

        //update png name if update query is success
        if ($result && $table == 'user' && $attribute == 'username') {
            $oldUsername = str_replace(' ', '_', $username);

            $modifiedUsername = str_replace(' ', '_', $value);

            // Construct the filenames for the old and new profile icons
            $oldProfileIcon = "../images/" . $oldUsername . ".png";
            $newProfileIcon = "../images/" . $modifiedUsername . ".png";

            // Rename the profile icon file if it exists
            if (file_exists($oldProfileIcon)) {
                rename($oldProfileIcon, $newProfileIcon);
            }

            //update username in other table also
            $sql2 = "UPDATE payment SET username='$value' WHERE username='$username'";
            $sql3 = "UPDATE event SET username='$value' WHERE username='$username'";
            $result2 = mysqli_query($conn, $sql2);
            $result3 = mysqli_query($conn, $sql3);
        }

    } elseif ($operation == "delete") {
        if ($table == 'user') {
            $_SESSION['restricted'] = true;
            mysqli_close($conn);
            header("Location: dataTable.php");
            exit();
        }
        if (!$rowId) {
            $_SESSION['success'] = false;
            mysqli_close($conn);
            header("Location: dataTable.php");
            exit();
        }
        $sql = "DELETE FROM $table WHERE id='$rowId' ";
        $result = mysqli_query($conn, $sql);
    }

    if ($result) {
        $_SESSION['success'] = true;
        mysqli_close($conn);
        header("Location: dataTable.php");
        exit();
    } else {
        $_SESSION['success'] = false;
        mysqli_close($conn);
        header("Location: dataTable.php");
        exit();
    }
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
    <link rel="stylesheet" href="db_CRUD.css" />
    <title>Techvent</title>
</head>

<body>

    <?php
    include("admin_navbar.php");
    ?>
    <div class="FormCard">
        <h1>Database CRUD</h1>
        <form action="db_CRUD.php" method="post">

            <p class="dbAccess-title">1. Operation</p>
            <select name="operation" id="select-box">
                <option value="read">Read </option>
                <option value="insert">Insert </option>
                <option value="update">Update </option>
                <option value="delete">Delete </option>
            </select>

            <p class="dbAccess-title">2. Table</p>
            <select name="table" id="select-box">
                <option value="user">user </option>
                <option value="service">service</option>
            </select>

            <p class="dbAccess-title">3. Row ID (for Update and Delete Operation only)</p>
            <input id="row-id" type="number" min="0" max="99999999" name="row_id" /><br />

            <p class="dbAccess-title">4. Attribute (for Update Operation only)</p>
            <input type="text" maxlength="80" name="attribute" /><br />

            <p class="dbAccess-title">5. Value (for Insert and Update Operation only, Please enter full value for
                insert by separating columns with "," in order)( no need to enter id)</p>
            <input type="text" maxlength="80" name="value" /><br />

            <button class="submit" type="submit">
                Submit
            </button>
        </form>
    </div>

</body>

</html>