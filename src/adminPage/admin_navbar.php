<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="../style.css" />
    <title>Techvent</title>
</head>

<body>
    <div class="navbar">
        <div class="navLeft">
            <img src="../images/favicon.png" alt="logo" id="logo" />
            <div class="navItem"><a href="adminDashboard.php">Home</a></div>
            <div class="navItem"><a href="db_CRUD.php">Database</a></div>
            <div class="navItem"><a href="sales.php">Sales</a></div>
        </div>
        <div class="navRight">
            <div id="navProfilePic"><a href="../logout.php">Logout</a></div>
        </div>
    </div>
    <div class="breakSpace"></div>
    <script>
        document.getElementById("logo").addEventListener('click', () => {
            window.location.href = 'adminDashboard.php';
        });
    </script>

</body>

</html>