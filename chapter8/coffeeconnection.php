<?php
// Variables and errors array
$fname = '';
$lname = '';
$email = '';
$age = false;

//Error message variables
$fname_error ='';
$lname_error ='';
$email_error ='';
$age_error ='';


//Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    $fname = trim((string)($_POST['fname'] ?? ''));
    $lname = trim((string)($_POST['lname'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    
//Use isset() to determine whether the age checkbox was selected    
    $age = isset($_POST['age']);
  
//Track if entire form  is valid    
    $okay = true;

    if (empty($fname)) {
        $fname_error = "Please enter your first name.";
        $okay = false;
    }

     if (empty($lname)) {
        $lname_error = "Please enter your last name.";
         $okay = false;
    }

     if (empty($email)) {
        $email_error = "Please enter your email address.";
        $okay = false;
     } 
     
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error ="Please enter a valid email address.";
        $okay = false;
        }
    
     if(!$age) {
        $age_error = "You must confirm you are over 18.";
         $okay = false;
    }

//Redirect after successful validation
if ($okay) {
    header("Location: subscribed.php");
    exit;
}
}

require 'includes/header.php';
?>


    <figure class="center">
        <img src="images/people.png" alt="People drinking coffee" width="300">
    </figure>

    <main id="content">

        <h2 class="center">Welcome to Coffee Connection!</h2>

        <p>
            We’re not just passionate lovers of coffee, but everything else that goes
            with a full and rewarding coffeehouse experience. We also offer a selection
            of premium teas, fine pastries, and other delectable treats. The music you
            hear in store is chosen for its artistry and appeal. It’s not unusual to see
            people coming to Coffee Connection to chat, meet up, or even work. We’re a
            neighborhood gathering place, a part of the daily routine, and would like
            to be part of your way of life.
        </p>

        <section id="contact">
            <h2 class="center">Sign Up to Receive Our Newsletter</h2>

            <!--
                This will become a self-processing form.

                The form uses POST but does not need a separate processing page.
                After this file is renamed coffeeconnection.php, the same page
                will display the form AND process the submitted information.

                novalidate allows PHP to perform the validation instead of
                allowing the browser to stop the form first.
            -->
            <form method="post" novalidate>

                <div class="flexcontainer">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($fname, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Replaced placeholder with the PHP first-name error message. -->
                 <?php if ($fname_error !== ''): ?>
                <p class="red"><?php echo $fname_error; ?></p>
                <?php endif; ?>

                <div class="flexcontainer">
                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" id="lname" value="<?php echo htmlspecialchars($lname, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Replaced placeholder with the PHP last-name error message. -->
                 <?php if ($lname_error !== ''): ?>
                <p class="red"><?php echo $lname_error; ?></p>
                <?php endif; ?>

                <div class="flexcontainer">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Replaced placeholder with the PHP email error message. -->
                 <?php if ($email_error !== ''): ?>
                <p class="red"><?php echo $email_error; ?></p>
                <?php endif; ?>

                <div class="flexcontainer2">
                    <label for="age">I am over 18:</label>
                    <input type="checkbox" name="age" id="age" value="yes" <?php echo $age ? 'checked' :''; ?>>
                </div>

             
                <!-- Replaced placeholder with the PHP age error message. -->
                 <?php if ($age_error !== ''): ?>
                <p class="red"><?php echo $age_error; ?></p>
                <?php endif; ?>

                <!--
                    The submitted text values will eventually be placed back
                    into the form so they remain visible after an error.
                    This creates a sticky form.
                -->
                <div class="form-actions">
                    <button type="submit">Submit</button>
                    <a class="clear-link" href="coffeeconnection.php">Clear Form</a>
                </div>

            </form>
        </section>

        <section id="products">

            <div class="product center">
                <h3>Espresso</h3>
                <p><img src="images/coffee_espresso.jpg" alt="Espresso coffee"></p>
                <p>Popular espresso beverages — latte, americano, cappuccino, macchiato, and cold espresso drinks</p>
            </div>

            <div class="product center">
                <h3>Blended</h3>
                <p><img src="images/coffee_blended.jpg" alt="Blended coffee drinks"></p>
                <p>Delicious icy blends</p>
            </div>

            <div class="product center">
                <h3>Pastries</h3>
                <p><img src="images/coffee_pastries.jpg" alt="Pastries"></p>
                <p>Muffins, bagels, coffee cakes, and more</p>
            </div>

            <div class="product center">
                <h3>Food</h3>
                <p><img src="images/coffee_food.jpg" alt="Sandwiches, salads, and other food"></p>
                <p>Sandwiches, paninis, salads, and more</p>
            </div>

            <div class="product center">
                <h3>Breakfast</h3>
                <p><img src="images/coffee_breakfast.jpg" alt="Breakfast food"></p>
                <p>Biscuits, muffins, wraps, croissants, oatmeal, and more</p>
            </div>

        </section>

    </main>

    <?php require 'includes/footer.php'; ?>