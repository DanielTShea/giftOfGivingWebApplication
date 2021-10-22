<?php require('code/logincode.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Javascript -->
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
    <title>Gift of Giving</title>
</head>

<body class="container">

    <!-- Logo image -->
    <div class="logo">
        <img id="logoImage" src="images/gift.png" alt="gift with bow">
    </div>

    <!-- Mobile Nav -->
    <div id="hamburgerMenu">
        <img  id="hamburgerMenuImage" src="images/hamburger.png" alt="hamburger menu">
    </div>

    <div class="mobileNav">
        <img id="mobileNavClose" src="images/mobileNavClose.png" alt="Close navigation">

        <div id="mobileNavContent">
                <a id="mNavOne" class="mNavItem" href="home/home.php">Home</a>
                <a id="mNavTwo" class="mNavItem" href="yourProfile/yourProfile.php">Your Profile</a>
                <a id="mNavThree" class="mNavItem" href="birthdays/birthdays.php">Birthdays</a>
                <a id="mNavFour" class="mNavItem" href="holidays/holidays.php"> Holidays </a>
                <a id="mNavFive" class="mNavItem" href="contactus/contactus.php"> Contact Us </a>
        </div>

    </div>

<!-- Login -->
    <div class="login">
        <h1> Gift of Giving</h1>

        <h2>Your first and last stop for your families’ birthday and holiday gift exchanges.
        </h2>

        <h3> Sign In </h3>

        <form class="form" method="post" action="login.php" enctype="application/x-www-form-urlencoded"> 
        
            <input type="text" class="loginBoxes" id="userName" name="userName" placeholder ="Username" maxlength="32">  
            <br><br>
            <input type="password" class="loginBoxes" id="password" name="password" maxlength="16" placeholder  ="Password">
            <p class="loginError"><?php echo $loginError; ?> </p>
            <br><input id="submit" type="submit" value="Login"><br>
        </form>

        <h3> Or <a href="signUp/signUp.php">Sign Up</a></h3>
        
    </div>

<!-- footer -->
    <div class="footer">

        <p><a href="contactus/contactus.php"> Contact Us</a> </p>
        <p id="disclaimer">Gift of Giving © 2021 </p>

    </div>
</body>
</html>