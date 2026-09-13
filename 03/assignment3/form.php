<?php 
error_reporting(E_ALL); 
// Retrieve the information entered for the website to use later
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$heard = $_POST['heard'];
$comments = $_POST['comments'];
?>

<!DOCTYPE html>
<!-- Randolph Daniels -->

<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="form.css">
</head>
    <body>
        <main>
<h1>Thank You For Signing Up!</h1>

<h2>Please Review Your Information:</h2>

    <p><strong>Name:</strong> <?php // This is where the saved information will be displayed
     echo $name;?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Phone:</strong> <?php echo $phone; ?></p>    
    <p><strong>How you heard about us:</strong> <?php echo $heard;?></p>
    <p><strong>Comments:</strong> <?php echo $comments; ?></p>
    
        </main>  
    </body>
</html>