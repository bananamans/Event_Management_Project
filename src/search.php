<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="search.css" />
    <script src="https://kit.fontawesome.com/c55c2b3c60.js" crossorigin="anonymous"></script>
    <title>Techvent</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>

    <div class="search-box">
        <div class="row">
            <input type="text" id="input-box" placeholder="Search event form here" autocomplete="off">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div class="result-box">

        </div>
    </div>
    <script src="search.js"></script>
</body>

</html>