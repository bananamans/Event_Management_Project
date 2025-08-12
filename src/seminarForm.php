<?php
include("connectDB.php");
include("eventFormComponent/get_services.php");
session_start();

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
    <link rel="stylesheet" href="eventForm.css" />
    <title>Techvent</title>
</head>

<body>

    <?php
    include("navbar.php");
    ?>

    <!-- content -->
    <div class="FormCard">
        <h1>Book SEMINAR here</h1>
        <form class="event-form" action="verifyForm.php" method="post">

            <input type="hidden" name="type" value="seminar">

            <?php
            include("eventFormComponent/informationForm.php");
            ?>

            <h2>Services</h2>
            <div class="services">
                <?php
                include("eventFormComponent/decoration.php");
                ?>
            </div>

            <div class="services">
                <?php
                include("eventFormComponent/audio_studio.php");
                ?>
            </div>

            <div class="services">

                <?php
                $hasDoorGift = in_array('door gift', array_column($services, 'service_name'));
                if ($hasDoorGift) {

                    echo '<p class="service-title">- Door Gifts</p>';
                    echo '<select name="door-gift" id="select-box">';
                    echo '<option value="none">None </option>';

                    foreach ($services as $service) {
                        if ($service['service_name'] == 'door gift') {

                            $serviceType = $service['service_type'];
                            $servicePrice = $service['service_price'];

                            echo '<option value="' . $serviceType . '"> ' . ucwords($serviceType) . ' (RM' . $servicePrice . ')' . '</option>';
                        }
                    }
                    echo '</select>';
                }
                ?>
            </div>

            <div class="services">
                <?php
                include("eventFormComponent/catering.php");
                ?>
            </div>
            <?php
            include("eventFormComponent/submitButton.php");
            ?>
        </form>
    </div>

    <script src="verifyForm.js"></script>
</body>

</html>