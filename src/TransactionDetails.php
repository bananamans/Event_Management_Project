<?php
include("check_login.php");
include("check_event.php");
include("connectDB.php");

$type;
$eventName;
$contactNumber;
$startDate;
$endDate;
$startTime;
$endTime;
$venue;
$guest;
$theme;
$decorations;
$audioVisuals;
$catering;
$doorGift;
$liveBand;
$MC;
$eventHoldingPrice = 500;

// Check if all the necessary session variables are set
if (isset($_SESSION['type'], $_SESSION['eventName'], $_SESSION['contactNumber'], $_SESSION['startDate'], $_SESSION['endDate'], $_SESSION['startTime'], $_SESSION['endTime'], $_SESSION['venue'], $_SESSION['guest'], $_SESSION['theme'], $_SESSION['decorations'], $_SESSION['audioVisuals'], $_SESSION['catering'], $_SESSION['doorGift'], $_SESSION['liveBand'], $_SESSION['MC'])) {
    // Access the session variables
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
    $decorations = $_SESSION['decorations'];
    $audioVisuals = $_SESSION['audioVisuals'];
    $catering = $_SESSION['catering'];
    $doorGift = $_SESSION['doorGift'];
    $liveBand = $_SESSION['liveBand'];
    $MC = $_SESSION['MC'];

} else {
    // Redirect to the form page if the session variables are not set
    header("Location: memberDashboard.php");
    exit();
}

$sql = "SELECT * FROM service";
$result = mysqli_query($conn, $sql);

if (!$result) {
    mysqli_close($conn);
    $_SESSION['DBerror'] = true;
    header("Location: memberDashboard.php");
    exit();
}

$services = [];
$decorationsPrice = [];
$audioVisualsPrice = [];
$cateringPrice = [];
$subtotal = [0, 0, 0]; // index 0 for decoration, index 1 for audio_visual, index 2 for catering
$doorGift_price = 0;
$liveBand_price = 0;
$MC_price = 0;
$totalPrice = $eventHoldingPrice;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }
}

foreach ($services as $service) {
    if ($service['service_name'] == 'door gift' && $service['service_type'] == $doorGift) {
        $doorGift_price = $service['service_price'];
        $totalPrice += $doorGift_price;
        break;
    }
}
foreach ($services as $service) {
    if ($service['service_name'] == 'hire live band' && $service['service_type'] == $liveBand) {
        $liveBand_price = $service['service_price'];
        $totalPrice += $liveBand_price;
        break;
    }
}
foreach ($services as $service) {
    if ($service['service_name'] == 'hire mc' && $service['service_type'] == $MC) {
        $MC_price = $service['service_price'];
        $totalPrice += $MC_price;
        break;
    }
}

foreach ($decorations as $deco) {
    foreach ($services as $service) {
        if ($service['service_name'] == 'decoration' && $service['service_type'] == $deco) {
            $price = $service['service_price'];
            $decorationsPrice[] = $price;
            $subtotal[0] += $price;
            $totalPrice += $price;
            break;
        }
    }
}

foreach ($audioVisuals as $av) {
    foreach ($services as $service) {
        if ($service['service_name'] == 'audio visual rental' && $service['service_type'] == $av) {
            $price = $service['service_price'];
            $audioVisualsPrice[] = $price;
            $subtotal[1] += $price;
            $totalPrice += $price;
            break;
        }
    }
}

foreach ($catering as $c) {
    foreach ($services as $service) {
        if ($service['service_name'] == 'catering' && $service['service_type'] == $c) {
            $price = $service['service_price'];
            $cateringPrice[] = $price;
            $subtotal[2] += $price;
            $totalPrice += $price;
            break;
        }
    }
}

$_SESSION["doorGift_price"] = $doorGift_price;
$_SESSION["liveBand_price"] = $liveBand_price;
$_SESSION["MC_price"] = $MC_price;

$_SESSION["eventHoldingPrice"] = $eventHoldingPrice;

$_SESSION["subtotal"] = $subtotal;
$_SESSION["totalPrice"] = $totalPrice;

$_SESSION["decorationsPrice"] = $decorationsPrice;
$_SESSION["audioVisualsPrice"] = $audioVisualsPrice;
$_SESSION["cateringPrice"] = $cateringPrice;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/images/favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="TransactionDetails.css" />
    <title>Techvent</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>
    <div class="card">
        <h2>Event Details</h2>
        <p>Please review your event details before proceeding to payment:</p>
        <ol>
            <li>Event type:
                <?php
                if ($type == "seminar") {
                    echo "seminar";
                }
                if ($type == "privateEvent") {
                    echo "private event";
                }

                ?>
            </li>
            <li>Event name:
                <?php echo $eventName; ?>
            </li>
            <li>Contact number: 60
                <?php echo $contactNumber; ?>
            </li>
            <li>Start date:
                <?php echo $startDate; ?>
            </li>
            <li>End date:
                <?php echo $endDate; ?>
            </li>
            <li>Start time:
                <?php echo $startTime; ?>
            </li>
            <li>End time:
                <?php echo $endTime; ?>
            </li>
            <li>Venue:
                <?php echo $venue; ?>
            </li>
            <li>Guest:
                <?php echo $guest; ?>
            </li>
            <?php if ($type == "seminar"): ?>
            <li>
                <div style="display: flex; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin-bottom: 10px;">Decorations</p>
                        <?php
                            $decorationsCount = count($decorations);

                            for ($i = 0; $i < $decorationsCount; $i++) {
                                echo '<p>' . $decorations[$i] . '</p>';
                            }
                            ?>
                    </div>
                    <div style="flex: 1; margin-right: 350px;">
                        <p style="margin-bottom: 10px;">Price</p>
                        <?php
                            $decorationsCount = count($decorations);

                            for ($i = 0; $i < $decorationsCount; $i++) {
                                echo '<p>RM ' . $decorationsPrice[$i] . '</p>';
                            }
                            ?>
                    </div>
                </div>
                <p>Subtotal: RM
                    <?php echo $subtotal[0]; ?>
                </p>
            </li>
            <li>
                <div style="display: flex; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin-bottom: 10px;">Audio Visuals</p>
                        <?php
                            $audioVisualCount = count($audioVisuals);

                            for ($i = 0; $i < $audioVisualCount; $i++) {
                                echo '<p>' . $audioVisuals[$i] . '</p>';
                            }
                            ?>
                    </div>
                    <div style="flex: 1; margin-right: 350px;">
                        <p style="margin-bottom: 10px;">Price</p>
                        <?php
                            $audioVisualCount = count($audioVisuals);

                            for ($i = 0; $i < $audioVisualCount; $i++) {
                                echo '<p>RM ' . $audioVisualsPrice[$i] . '</p>';
                            }
                            ?>
                    </div>
                </div>
                <p>
                    Subtotal: RM
                    <?php echo $subtotal[1]; ?>
                </p>
            </li>
            <li>
                <div style="display: flex; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin-bottom: 10px;">Catering</p>
                        <?php
                            $cateringCount = count($catering);

                            for ($i = 0; $i < $cateringCount; $i++) {
                                echo '<p>' . $catering[$i] . '</p>';
                            }
                            ?>
                    </div>
                    <div style="flex: 1; margin-right: 350px;">
                        <p style="margin-bottom: 10px;">Price</p>
                        <?php
                            $cateringCount = count($catering);

                            for ($i = 0; $i < $cateringCount; $i++) {
                                echo '<p>RM ' . $cateringPrice[$i] . '</p>';
                            }
                            ?>
                    </div>
                </div>
                <p>
                    Subtotal: RM
                    <?php echo $subtotal[2]; ?>
                </p>
            </li>
            <li>Door Gift:
                <?php
                    echo $doorGift;
                    echo '<br><p> Subtotal: RM' . $doorGift_price . '</p>';
                    ?>
            </li>
            </ul>
            <?php endif; ?>
            <?php if ($type == "privateEvent"): ?>
            <li>Theme:
                <?php echo $theme; ?>
            </li>
            <li>
                <div style="display: flex; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin-bottom: 10px;">Decorations</p>
                        <?php
                            $decorationsCount = count($decorations);

                            for ($i = 0; $i < $decorationsCount; $i++) {
                                echo '<p>' . $decorations[$i] . '</p>';
                            }
                            ?>
                    </div>
                    <div style="flex: 1; margin-right: 350px;">
                        <p style="margin-bottom: 10px;">Price</p>
                        <?php
                            $decorationsCount = count($decorations);

                            for ($i = 0; $i < $decorationsCount; $i++) {
                                echo '<p>RM ' . $decorationsPrice[$i] . '</p>';
                            }
                            ?>
                    </div>
                </div>
                <p>Subtotal: RM
                    <?php echo $subtotal[0]; ?>
                </p>
            </li>

            <li>
                <div style="display: flex; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin-bottom: 10px;">Audio Visuals</p>
                        <?php
                            $audioVisualCount = count($audioVisuals);

                            for ($i = 0; $i < $audioVisualCount; $i++) {
                                echo '<p>' . $audioVisuals[$i] . '</p>';
                            }
                            ?>
                    </div>
                    <div style="flex: 1; margin-right: 350px;">
                        <p style="margin-bottom: 10px;">Price</p>
                        <?php
                            $audioVisualCount = count($audioVisuals);

                            for ($i = 0; $i < $audioVisualCount; $i++) {
                                echo '<p>RM ' . $audioVisualsPrice[$i] . '</p>';
                            }
                            ?>
                    </div>
                </div>
                <p>
                    Subtotal: RM
                    <?php echo $subtotal[1]; ?>
                </p>
            </li>
            <li>
                <div style="display: flex; align-items: flex-start;">
                    <div style="flex: 1;">
                        <p style="margin-bottom: 10px;">Catering</p>
                        <?php
                            $cateringCount = count($catering);

                            for ($i = 0; $i < $cateringCount; $i++) {
                                echo '<p>' . $catering[$i] . '</p>';
                            }
                            ?>
                    </div>
                    <div style="flex: 1; margin-right: 350px;">
                        <p style="margin-bottom: 10px;">Price</p>
                        <?php
                            $cateringCount = count($catering);

                            for ($i = 0; $i < $cateringCount; $i++) {
                                echo '<p>RM ' . $cateringPrice[$i] . '</p>';
                            }
                            ?>
                    </div>
                </div>
                <p>
                    Subtotal: RM
                    <?php echo $subtotal[2]; ?>
                </p>
            </li>
            <li>Hire Live Band:
                <?php
                    echo $liveBand;
                    echo '<br><p> Subtotal: RM' . $liveBand_price . '</p>';
                    ?>
            </li>
            <li>Hire MC:
                <?php
                    echo $MC;
                    echo '<br><p> Subtotal: RM' . $MC_price . '</p>';
                    ?>
            </li>
            <?php endif; ?>
            <li>
                <p>Event holding base price:
                    <?php
                    echo '<br><p> Subtotal: RM' . $eventHoldingPrice . '</p>';
                    ?>
                </p>
            </li>

        </ol>

        <p style="margin-top: 30px;">Total Price: RM
            <?php echo $totalPrice; ?>
        </p>
        <p>If the details are correct, click the button below to proceed with the payment:</p>
        <button onclick="window.location.href = 'payment/paymentPage.php'">Proceed to Payment</button>
    </div>
</body>

</html>