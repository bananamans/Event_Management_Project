<?php

session_start();

$decorations = $_SESSION['decorations'];
$audioVisuals = $_SESSION['audioVisuals'];
$catering = $_SESSION['catering'];
$doorGift = $_SESSION['doorGift'];
$liveBand = $_SESSION['liveBand'];
$MC = $_SESSION['MC'];

$doorGift_price = $_SESSION["doorGift_price"];
$liveBand_price = $_SESSION["liveBand_price"];
$MC_price = $_SESSION["MC_price"];

$eventHoldingPrice = $_SESSION["eventHoldingPrice"];
$subtotal = $_SESSION["subtotal"]; // index 0 for decoration, index 1 for audio_visual, index 2 for catering
$totalPrice = $_SESSION["totalPrice"];

$decorationsPrice = $_SESSION["decorationsPrice"];
$audioVisualsPrice = $_SESSION["audioVisualsPrice"];
$cateringPrice = $_SESSION["cateringPrice"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="receipt.css" />
</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <h2 class="receipt-title">Transaction Receipt</h2>
        </div>
        <div class="receipt-info">
            <p>Date:
                <?php
                date_default_timezone_set("Asia/Kuala_Lumpur");
                echo date("Y-m-d");
                ?>
            </p>
            <p>Time:
                <?php
                date_default_timezone_set("Asia/Kuala_Lumpur");
                echo date("H:i:s");
                ?>
            </p>
        </div>
        <table class="receipt-table">
            <tr>
                <th>Item</th>
                <th>Price</th>
            </tr>
            <?php
            for ($i = 0; $i < count($decorations); $i++) {
                echo '<tr>';
                echo '<td>Decoration (' . $decorations[$i] . ')</td>';
                echo '<td>RM ' . $decorationsPrice[$i] . '</td>';
                echo '</tr>';
            }
            ?>
            <?php
            for ($i = 0; $i < count($audioVisuals); $i++) {
                echo '<tr>';
                echo '<td>Audio visual (' . $audioVisuals[$i] . ')</td>';
                echo '<td>RM ' . $audioVisualsPrice[$i] . '</td>';
                echo '</tr>';
            }
            ?>
            <?php
            for ($i = 0; $i < count($catering); $i++) {
                echo '<tr>';
                echo '<td>Catering (' . $catering[$i] . ')</td>';
                echo '<td>RM ' . $cateringPrice[$i] . '</td>';
                echo '</tr>';
            }
            ?>
            <?php if ($doorGift != 'none'): ?>
                <tr>
                    <td>Door Gift
                        <?php
                        echo ' (' . $doorGift . ')';
                        ?>
                    </td>
                    <td>RM
                        <?php echo $doorGift_price; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($liveBand != 'none'): ?>
                <tr>
                    <td>
                        Live Band
                        <?php
                        echo ' (' . $liveBand . ')';
                        ?>
                    </td>
                    <td>RM
                        <?php echo $liveBand_price; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($MC != 'none'): ?>
                <tr>
                    <td>MC
                        <?php
                        echo ' (' . $MC . ')';
                        ?>

                    </td>
                    <td>RM
                        <?php echo $MC_price; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Event Holding Base Price</td>
                <td>RM
                    <?php echo $eventHoldingPrice; ?>
                </td>
            </tr>
        </table>
        <div class="receipt-total">
            <p>Total Price: RM
                <?php echo $totalPrice; ?>
            </p>
        </div>
        <div class="receipt-footer">
            <p>Thank you for choosing our services!</p>
        </div>
    </div>
    <script>
        alert("Payment successful! Your account has been deducted");
    </script>
</body>

</html>