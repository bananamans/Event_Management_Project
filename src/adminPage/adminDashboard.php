<?php
include("sessionAndDB.php");

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
    <link rel="stylesheet" href="adminDashboard.css" />
    <title>Techvent</title>
</head>

<body>
    <?php
    include("admin_navbar.php");
    ?>
    <div class="container">
        <div class="welcome-container">
            <h1>Welcome to Techvent Admin page</h1>
            <img src="../images/hello.png" class="small-image" style="margin-left: 20px" />
            <div class="top">
                <div class="menu">
                    <img src="../images/update.png" class="small-image" alt="Database Operations Image" />
                    <ul class="menu">
                        <li><a href="db_CRUD.php">Perform Database Operations</a></li>
                    </ul>
                </div>
                <div class="bottom">
                    <div class="menu">
                        <img src="../images/budget.png" class="small-image" alt="Manage Sales" />
                        <ul class="menu">
                            <li><a href="sales.php">View Sales</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>