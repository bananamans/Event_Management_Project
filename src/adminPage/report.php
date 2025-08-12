<?php
session_start();

$payments;
$total = 0;

if (!$_SESSION['payments']) {
    echo "<script>
    setTimeout(function () {
        alert('Database query failed');
    }, 100);
    </script>";
    unset($_SESSION['payments']);
} elseif ($_SESSION['payments'] == 1) {
    $payments = false;
    unset($_SESSION['payments']);
} else {
    $payments = $_SESSION['payments'];
    foreach ($payments as $payment) {
        $total += $payment['payment_amount'];
    }
}

$months = [];
function groupPaymentsByMonth($payments, &$months)
{
    $result = array(); // Initialize an empty object to store the result
    foreach ($payments as $payment) { // Loop through each payment
        $date = $payment['payment_date']; // Get the payment date
        $month = date('F', strtotime($date)); // Extract the month name from the date
        if (!isset($result[$month]) && count($result) < 5) { // Check if the result object has a key for the month
            $result[$month] = array(); // If not, create an empty array for the month
            $months[] = $month;
        }
        $result[$month][] = $payment; // Push the payment to the array for the month
    }
    return $result; // Return the result object
}
$paymentsByMonth = groupPaymentsByMonth($_SESSION['payments'], $months);

function getTotalAmountsByMonth($paymentsByMonth)
{
    $result = array(); // Initialize an empty array to store the result
    foreach ($paymentsByMonth as $month => $payments) { // Loop through each month and its payments
        $total = 0; // Initialize a variable to store the total amount for the month
        foreach ($payments as $payment) { // Loop through each payment in the month
            $total += $payment['payment_amount']; // Add the payment amount to the total
        }
        $result[] = $total; // Push the total amount to the result array
    }
    return $result; // Return the result array
}
$totalAmountsByMonth = getTotalAmountsByMonth($paymentsByMonth);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="report.css" />
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <title>Techvent</title>
</head>

<body>
    <div class="title">
        <h1>Sales report</h1>
    </div>
    <?php
    if ($payments) {
        echo "<div id='chart'></div>";
    } else {
        echo "<p> No payment records in the database </p>";
    }
    ?>


    <script>
    const totalAmountsByMonth = <?php echo json_encode($totalAmountsByMonth); ?>;
    const months = <?php echo json_encode($months); ?>;

    // Creating the SVG container
    const svg = d3.select("#chart")
        .append("svg")
        .attr("width", 600)
        .attr("height", 350)
        .append("g")
        .attr("transform", "translate(0, 70)");

    // Creating the x-scale
    const xScale = d3.scaleBand()
        .domain(months)
        .range([0, 410])
        .paddingInner(0.1);

    // Creating the y-scale
    const yScale = d3.scaleLinear()
        .domain([0, d3.max(totalAmountsByMonth)])
        .range([200, 0]);

    // Creating the y-axis
    const yAxis = d3.axisLeft(yScale)
        .ticks(6)
        .tickFormat(d => "$" + d);

    // Appending the y-axis to the SVG container
    const yAxisGroup = svg.append("g")
        .attr("class", "y-axis")
        .attr("transform", "translate(100, 0)")
        .call(yAxis);

    // Appending the y-axis label
    yAxisGroup.append("svg:text")
        .attr("transform", "rotate(-90)")
        .attr("x", -100)
        .attr("y", -50)
        .attr("dy", "1em")
        .attr("text-anchor", "middle")
        .text("Amount in USD");

    // Creating the bars
    svg.selectAll("rect")
        .data(totalAmountsByMonth)
        .enter()
        .append("rect")
        .attr("x", (d, i) => xScale(xScale.domain()[i]) + 80 + xScale.bandwidth() /
            2)
        .attr("y", (d, i) => yScale(d))
        .attr("width", xScale.bandwidth())
        .attr("height", (d, i) => 200 - yScale(d))
        .attr("fill", "steelblue");

    // Creating the labels
    svg.selectAll("text.label")
        .data(totalAmountsByMonth)
        .enter()
        .append("text")
        .attr("class", "label")
        .attr("x", (d, i) => xScale(xScale.domain()[i]) + 125 + xScale.bandwidth() /
            2) // Position the labels horizontally
        .attr("y", (d, i) => yScale(d) - 5) // Position the labels vertically
        .attr("text-anchor", "middle") // Align the labels to the center of the columns
        .text((d, i) => "$" + d) // Display the value of totalAmountsByMonth
        .style("font-size", "12px");

    // Creating the x-axis
    const xAxis = d3.axisBottom().scale(xScale).tickFormat(d => d); // create an x-axis generator

    // Appending the x-axis to the SVG container
    svg.append("g")
        .attr("class", "x-axis")
        .attr("transform", "translate(130, 210)")
        .call(xAxis); // call the x-axis generator
    </script>
</body>

</html>