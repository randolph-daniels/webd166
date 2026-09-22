<?php
// Creating the variables to save the information entered to be used for later
$milesDriven = $_POST["miles_driven"];
$gallonsUsed = $_POST["gallons_used"];
$pricePerGallon = $_POST["price_gallon"];

// Perform the calculations of the information retrieved
$mpg = $milesDriven / $gallonsUsed;
$total_cost = $gallonsUsed * $pricePerGallon; 
?>


<!DOCTYPE html>
<!-- Randolph Daniels -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MPG and Trip Cost Calculator</title>
</head>
    <body>
        <main>
            <section>
            <h1>Trip Calculator Results</h1>
            <h2>Values Entered</h2>
            <p>Miles Driven: <?php 
            // Gathers the information from the variables, does the proper calculations,and displays results
            echo number_format($milesDriven); ?></p>
            <p>Gallons of Gas Used: <?php echo number_format($gallonsUsed, 1); ?></p>
            <p>Price Per Gallon: $<?php echo number_format($pricePerGallon, 2); ?></p>
            <h3>Your Results</h3>
            <p>Your Vehicle MPG: <?php echo number_format($mpg,2); ?></p>
            <p>Total Cost of Trip: $<?php echo number_format($total_cost, 2); ?></p>
        

        </section>
    </main>
</body>

</html>