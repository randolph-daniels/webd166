<?php
// PHP Message Variable
$msg = "<p>Please <a href=\"donation2.html\">GO BACK</a> and fill in the following error(s):</p>\n";

$okay = true;

//Validate the form data
$fname = trim($_POST['fname'] ?? '');
$lname = trim($_POST['lname'] ?? '');
$email = trim($_POST['email'] ?? '');
$amount_raw = trim($_POST['amount'] ?? '');

// Validate first name
if (empty($fname)) {
    $msg .= "<p>First name is required.</p>";
    $okay = false;
}

// Validate last name
if (empty($lname)) {
    $msg .= "<p>Last name is required.</p>";
    $okay = false;
}

// Validate email
if (empty($email)) {
    $msg .= "<p>Email is required.</p>";
    $okay = false;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $msg .= "<p>Invalid email format.</p>";
    $okay = false;
}

// Validate donation amount
if ($amount_raw === "") {
    $msg .= "<p>Donation amount is required.</p>";
    $okay = false;
} elseif (!is_numeric($amount_raw)) {
    $msg .= "<p>Donation amount must be a number.</p>\n";
    $okay = false;
} elseif ($amount_raw <= 0) {
    $msg .= "<p>Donation amount must be greater than zero.</p>\n";
    $okay = false;
} 

// Format the Donated Amount
$formatted_amount = number_format((float)$amount_raw, 2);

//Confirmation Number
$initial = strtoupper(substr($lname, 0, 1));
$length = strlen($lname);
$rand_num = random_int(1000, 9999);
$confirmation = $length . $initial . $rand_num;

// Subscription Message
if (isset($_POST['subscription'])) {
    $subscription_status = 'no_subscription';
} else {
    $subscription_status = 'subscription';
}

$sub_msg ="";
switch ($subscription_status) {
    case 'no_subscription':
        $sub_msg = "<p>You have chosen not to receive a free one-year subscription to our e-magazine.</p>\n";
        break;
    case 'subscription':
        $sub_msg = "<p>You will receive a free one-year subscription to our e-magazine.</p>\n";
        break;
    default:
        $sub_msg = "";
        break;
}

// Donation Level
if ($amount_raw >= 100) {
    $donation_level = "Gold Supporter";
} elseif ($amount_raw >= 50) {
    $donation_level = "Silver Supporter";
} elseif ($amount_raw >= 25) {
    $donation_level = "Bronze Supporter";
} else {
    $donation_level = "Friend of the Animals";
}

// Thank You
$repeated_thanks ="";
for ($i = 1; $i <= 3; $i++) {
    $repeated_thanks .= "Thank you! ";
}

// Escape User-Entered Values
$safe_fname = htmlspecialchars($fname, ENT_QUOTES, 'UTF-8');
$safe_lname = htmlspecialchars($lname, ENT_QUOTES, 'UTF-8');    
$safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$safe_confirmation = htmlspecialchars($confirmation, ENT_QUOTES, 'UTF-8');

// Success Message
if ($okay) {
    $msg = "<p>Thank you $safe_fname $safe_lname for your donation of $$formatted_amount.</p>\n";

    $msg .= "<p>Your confirmation number is $safe_confirmation.</p>\n";
    $msg .= "<p>We will email your receipt to $safe_email.</p>\n";
    $msg .= $sub_msg;
    $msg .= "<p>Your donation level is $donation_level.</p>\n";
    $msg .= $repeated_thanks;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Processing</title>
</head>
<body>

<!-- displaying message here -->
    <?php echo $msg; ?>
    
</body>
</html>