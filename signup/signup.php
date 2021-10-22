<!-- Requiring PHP file -->
<?php require('../code/signupcode.php');?>
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
    <title>Gift of Giving: Sign Up</title>
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

    <!-- Sign Up Form-->
    <div class="signUp">
        <h1>Gift of Giving </h1>

        <h2>Sign Up Information
        </h2>

        <form class="form" method="post" action="signUp.php" enctype="application/x-www-form-urlencoded">
            <fieldset id="signUpFieldset">
                <legend id="infoLegend"> Your Information </legend>
                <br>
                    <label for="firstName"> First Name: </label>
                    <input type="text" class="signUpBoxes" id="firstName" name="firstName" size="35" maxlength="50" value="<?php if (isset($_POST["firstName"])){ echo $_POST["firstName"];} ?>"> 
                    <br><span class="signUpError"><?php echo $firstNameError; ?> </span><br><br>

                    <label for="LastName"> Last Name: </label>
                    <input type="text" class="signUpBoxes" id="lastName" name="lastName" size="35" maxlength="50" value="<?php if (isset($_POST["lastName"])){ echo $_POST["lastName"];} ?>"> 
                    <br><span class="signUpError"><?php echo $lastNameError; ?> </span> <br><br>

                    <label for="LastName"> Birthday: </label>
                    <input type="date" class="signUpBoxes" id="birthday" name="birthday" size="35" max="01/01/2025" value="<?php if (isset($_POST["birthday"])){ echo $_POST["birthday"];} ?>"> 
                    <br><span class="signUpError"><?php echo $birthdayError; ?> </span> <br><br>

                    <label for="userName"> Create a User Name: </label>
                    <input type="text" class="signUpBoxes" id="userName" name="userName" size="32" maxlength="32" value="<?php if (isset($_POST["userName"])){ echo $_POST["userName"];} ?>"> 
                    <br><span class="signUpError"><?php echo $usernameError; ?> </span> <br><br>

                    <label for="passwordTest"> Password (8 characters minimum, one capital letter, and number required): </label><br>
                    <input type="password" class="signUpBoxes" id="passwordTest" name="passwordTest" size="16" maxlength="16" > 
                    <span class="signUpError"><?php echo $passwordError; ?> </span> <br><br>

                    <label for="passwordFinal"> Re-enter Password: </label><br>
                    <input type="password" class="signUpBoxes" id="passwordFinal" name="passwordFinal" size="16" maxlength="16"> <span class="signUpError"><?php echo $confirmpasswordError; ?> </span><br><br>

                    <div id="submitButton">
                    <br><input id="submit" type="submit" value="Sign Up"><br><br>
                    </div>
            </fieldset>


        </form>
        
    </div>

    <!-- Footer -->
    <div class="footer">

        <p> <a href="../login.php">Login</a> | <a href="../contactus/contactus.php">Contact Us</a></p>
        <p id="disclaimer">Gift of Giving © 2021 </p>
    </div>
</body>
</html>