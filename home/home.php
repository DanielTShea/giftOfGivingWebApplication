<?php require('../code/homecode.php'); ?>
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
    <title>Gift of Giving: Home</title>
</head>

<body>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <div id="logo">
                <img id="logoImage" src="../images/gift.png" alt="gift with bow">
            </div>
        <div id="headline">
            <h1 id="headline"> Gift of Giving </h1>
         </div>

        <div class="hamburgerMenu">
            <img id="hamburgerMenuImage" src="../images/hamburger.png" alt="hamburger menu">
        </div>
        </div>  

        <!-- Desktop Menu -->
        <div class="desktopMenu"> 
            <a id="menuOne" class="menuItem" href="home.php">Home</a>
            <a id="menuTwo" class="menuItem" href="../yourProfile/yourProfile.php"> Your Profile </a>
            <a id="menuThree" class="menuItem" href="../birthdays/birthdays.php">Birthdays</a>
            <a id="menuFour" class="menuItem" href="../holidays/holidays.php">Holidays</a>
        </div>


        <!-- Mobile Nav -->
        <div class="mobileNav">
            <img id="mobileNavClose" src="../images/mobileNavClose.png" alt="Close navigation">

            <div id="mobileNavContent">
                <a id="mNavOne" class="mNavItem" href="home.php">Home</a>
                <a id="mNavTwo" class="mNavItem" href="../yourProfile/yourProfile.php">Your Profile</a>
                <a id="mNavThree" class="mNavItem" href="../birthdays/birthdays.php">Birthdays</a>
                <a id="mNavFour" class="mNavItem" href="../holidays/holidays.php"> Holidays </a>
                <a id="mNavFive" class="mNavItem" href="../contactus/contactus.php"> Contact Us </a>
            </div>

        </div>

        <!-- Breadcrumb -->
        <div id="breadcrumb">
            <p id="breadcrumbContent"> Home > </p>    
        </div>
        
        <!-- Welcome and logout -->
        <div id="welcome">
            <h3><?php displayInfo(); welcomeUser(); ?>  </h3>
        </div>

        <div id="logout">  
            <h3><a href="../code/logoutcode.php">Logout</a></h3>  
        </div>

        <!-- Your Profile Information -->
        <div id="yourProfile">
            <h2 id="yourProfileHeader"> Your Profile </h2>
            <div id="yourProfileContent">
                <table>
                <tr><th>User Profile Image</th></tr>
                <tr><td><img id="currentUserImage" src="../code/getimagecode.php?id=<?=$sessionID?>"></td></tr>
                <?php displayInfo(); 
                profileinformation(); ?>
                </table>

            </div>
        </div>

        <!-- Your Family Information -->
        <div id="yourFamily">
            <h2 id="yourProfileHeader"> Your Family Members</h2>
                <div id="yourFamilyContent">
                    <p  class="FamilyIntro" id="familyIntro"> 
                    Now that you have joined the Gift of Giving, let's find your family 
                    or create a new one to share wishlists and holiday details.</p>

                        <div id="familySearch">
                            <fieldset class="familySearch">
                                <legend>Family Search</legend>
                                    <form action="home.php" action="get">
                                    <input type="text" class="searchbox" name="familySearch" maxlength="50">
                                    <input type="submit" class="searchbox" value="Search"><br>
                                    </form>
                                    <br><br>

                                <table class='tables' id='families'>
                                    <tr>
                                        <th> Family ID</th>
                                        <th>Family Name</th>
                                        <th>Family Members First Name</th>
                                        <th>Family Members Last Name</th>
                                        <th>Join Family</th>
                                    </tr>
                                    <?php 
                                    displayFamily();
                                    joinFamily(); 
                                    ?>
                                </table>
                                <br><br>
                            </fieldset>
                        </div>

                        <div id="createFamily">

                            <p class="FamilyIntro">Don't see your family? No worries, create and join a new family!</p>
                            <fieldset class="familySearch"> 
                            <legend>Create your family</legend>
                                <form action="home.php" action="get">
                                <input type="text" class="searchbox" name="familyNameCreate">
                                <input class="searchbox" type="submit" value="Create and Join" maxlength="50"><br>

                                <?php createFamily();?>
                                </form>
                            </fieldset>
                        </div>
                    </div>            

        </div>

    <!-- Birthday Information -->
    <div class="birthdays">
        <h2 id="birthdaysHeader"> Birthdays</h2>
        <div id="birthdayContent">
            <p > Connect with your family
            members by sharing your
            birthdate and seeing
            theirs. Also, get a link to
            their account for their
            wish list for their birthday. </p>

              <!-- Birthday Button -->
              <div class="submitButton">
                <br>
                <form action="../birthdays/birthdays.php">
                    <input class="buttons" id="Home" type="submit"  value="Birthdays"><br><br> 
                </form>
            </div>
            <br>
            <br>
        </div>
    </div>

    <!-- Holiday information -->
    <div class="holidays">
        <h2 id="holidaysHeader"> Holidays</h2>
        <div id="holidayContent">
            <p > Set up your family’s upcoming holiday gift exchange. 
            Set price limits and the type of exchange. 
            Start early to keep everyone happy and in the loop.
            </p>
              <!-- Holiday Button -->
              <div class="submitButton">
                <br>
                <form action="../holidays/holidays.php">
                    <input class="buttons" id="Home" type="submit"  value="Holidays"><br><br> 
                </form>
            </div>
            <br>
            <br>
        </div>
    </div>

    <!-- Footer -->
    <div id="footer">
        <p> <a href="home.php">Home</a> | <a href="../yourprofile/yourProfile.php">Your Profile</a> | <a href="../birthdays/birthdays.php">Birthdays</a> | <a href="../holidays/holidays.php"> Holidays </a> | <a href="../contactus/contactus.php">Contact Us </a></p>
        <p id="disclaimer"> Gift of Giving © 2021 </p>
    </div>

</div>
</body>
</html>
