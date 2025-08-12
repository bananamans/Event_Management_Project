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
        <h1>Book PRIVATE event here</h1>
        <form class="event-form" action="verifyForm.php" method="post">

            <input type="hidden" name="type" value="privateEvent">

            <?php
            include("eventFormComponent/informationForm.php");
            ?>

            <div class="grid-item">
                <div class="formGroup" id="genderGroup">
                    <label>Event theme</label>
                    <div class="small-space"></div>
                    <div class="radioGroup">
                        <input type="radio" id="wedding" name="event-theme" value="wedding"
                            onclick="resetError('wedding')" required />
                        <label for="wedding">Wedding</label>
                    </div>
                    <div class="radioGroup">
                        <input type="radio" id="birthday-party" name="event-theme" value="birthday-party"
                            onclick="resetError('wedding')" required />
                        <label for="Birthday-party">Birthday party</label>
                    </div>
                    <div class="radioGroup">
                        <input type="radio" id="anuual-dinner" name="event-theme" value="annual-dinner"
                            onclick="resetError('wedding')" required />
                        <label for="Christmas-party">Annual dinner</label>
                    </div>
                    <div class="radioGroup">
                        <input type="radio" id="other" name="event-theme" value="other" onclick="resetError('wedding')"
                            required />
                        <label for="other">Other</label>
                    </div>
                </div>
            </div>

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
                $hasLiveBand = in_array('hire live band', array_column($services, 'service_name'));
                if ($hasLiveBand) {

                    echo '<p class="service-title">- Hire Live Band</p>';
                    echo '<select name="hire-live-band" id="select-box">';
                    echo '<option value="none">None </option>';

                    foreach ($services as $service) {
                        if ($service['service_name'] == 'hire live band') {

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
                $hasMC = in_array('hire mc', array_column($services, 'service_name'));
                if ($hasMC) {

                    echo '<p class="service-title">- Hire Master of Ceremonies (MC)</p>';
                    echo '<select name="hire-mc" id="select-box">';
                    echo '<option value="none">None </option>';

                    foreach ($services as $service) {
                        if ($service['service_name'] == 'hire mc') {

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