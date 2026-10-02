<?php
// Initializes the message variable.
$message ='';


// Gets and cleans the values from the form.
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$donation =trim( $_POST['donation'] ?? '');

// Escape the value before displaying it in HTML.
$safe_first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
$safe_last_name = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
$safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

// Formats the donation amount to two decimal places.
$formatted_donation = '$' . number_format((float)$donation, 2); 

// Creates a random confirmation number.
$random_int = rand(1000,9999);

// Gets the first letter of the last name and convert it to uppercase.
$last_initial =strtoupper(substr($last_name, 0, 1));

// Counts the number of characters in the last name.
$last_name_length = strlen($last_name);


// Combines the values to create the confirmation number.
$confirmation_number = $last_name_length . $last_initial . $random_int;

// Creates the confirmation message.
$message = "<p>Thank you $safe_first_name  $safe_last_name for your donation of $formatted_donation.</p>";
$message .= "<p>Your order confirmation $confirmation_number. We will email your receipt to $safe_email.</p>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donation Confirmation</title>

    <style>
        body {
            font-family: arial;
            font-size: 100%;
        }

        #outer {
            width: 960px;
            margin: 50px auto;
            padding: 10px;
            border: 1px solid #a8a8a8;
            box-shadow: 0px 0px 20px #a8a8a8;
            background-color: aliceblue;
        }

        h1,
        h2 {
            font-size: 1.5em;
            color: navy;
            text-align: center;
        }

        .info {
            text-align: left;
        }

        input {
            display: block;
            margin-bottom: 25px;
        }

        input[type=submit] {
            margin-top: 25px;
        }
    </style>

</head>

<body>
    <header>
        <h1>Humane Society Donations</h1>
        <h2>Help the Animals</h2>
    </header>

    <section id="outer">
        <h1 class="info">Your Contribution</h1>

        <?php echo $message; ?>

    </section>

</body>

</html>