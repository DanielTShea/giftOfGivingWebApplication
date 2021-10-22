<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$( document).ready(function(){
    $( "#hamburgerMenuImage").click(function(){
        $( ".mobileNav").css("width", "50%");
    })

    $( "#mobileNavClose").click(function(){
        $( ".mobileNav").css("width", "0%");
    })
})


</script>

    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift of Giving: Contact Us</title>
</head>

<body class="container">

    <!-- Logo Image -->
    <div class="logo">
        <img id="logoImage" src="../images/gift.png" alt="gift with bow">
    </div>

    <!-- Mobile Nav -->
    <div id="hamburgerMenu">
        <img  id="hamburgerMenuImage" src="../images/hamburger.png" alt="hamburger menu">
    </div>

    <div class="mobileNav">
        <img id="mobileNavClose" src="../images/mobileNavClose.png" alt="Close navigation">

        <div id="mobileNavContent">
                <a id="mNavOne" class="mNavItem" href="../home/home.php">Home</a>
                <a id="mNavTwo" class="mNavItem" href="../yourProfile/yourProfile.php">Your Profile</a>
                <a id="mNavThree" class="mNavItem" href="../birthdays/birthdays.php">Birthdays</a>
                <a id="mNavFour" class="mNavItem" href="../holidays/holidays.php"> Holidays </a>
                <a id="mNavFive" class="mNavItem" href="../contactus/contactus.php"> Contact Us </a>
        </div>

    </div>

    <!-- Contact Us information -->
    <div class="contactUs">
        <h1> Gift of Giving </h1>

        <h2>Contact Us</h2>

        <p> Phone Number: 614-867-5309</p>
        
    </div>

    <!-- Footer -->
    <div class="footer">

        <p> <a href="../login.php">Login</a> | <a href="contactus.php">Contact Us</a></p>
        <p id="disclaimer">Gift of Giving © 2021 </p>
    </div>
    
</body>
</html>