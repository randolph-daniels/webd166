<?php
$heading = "Googleplex";
$street = "1600 Amphitheatre Parkway";
$city = "Mountain View";
$state = "CA";
$country = "USA";
?>

<!doctype html>
<!-- Randolph Daniels -->
<?php
//The instruction on step 4 was to put my name directly under the doctype//
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	
    <title>Randolph Daniels</title>
    <?php
    //This will put my name in the browser tab of the page// 
    ?>

</head>

<body>
<header>
    <h1>
        <?php echo "$heading"; 
    //This will put the heading in the body of the page//
     ?>
    </h1>
    
</header>

<p>
 The <?php echo "$heading"; ?> is the corporate headquarters complex of Google and its parent company Alphabet Inc. It is located at:
 <br>
 <?php 
 echo "$street <br>\n";
 //This will put the street address in the body of the page and a break to make it show up on a new line//
 echo "$city, $state, $country</p>\n";
 //This will put the city, state, and country in the body of the page//
 ?>



</body>
</html>